<?php

namespace Modules\SocialManagement\Http\Controllers;

use App\User;
use Illuminate\Routing\Controller;
use Modules\SocialManagement\Entities\SocialAudit;
use Modules\SocialManagement\Entities\Social;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class SocialAuditController extends Controller
{
    public function index(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $users = User::forDropdown($business_id, false);

        if ($request->ajax()) {
            try {
                $query = SocialAudit::where('business_id', $business_id)
                    ->selectRaw('DATE(created_at) as social_date, user_id, 
                                    SUM(social_audit_morning = 1) as morning_audit_done_count, 
                 SUM(social_audit_afternoon = 1) as afternoon_audit_done_count,
                 SUM(social_audit_morning = 0) as morning_audit_pending_count,
                 SUM(social_audit_afternoon = 0) as afternoon_audit_pending_count,
                 SUM(posted_morning = 1) as posted_morning_count,
                 SUM(posted_morning = 0) as not_posted_morning_count,
                 SUM(posted_afternoon = 1) as posted_afternoon_count,
                 SUM(posted_afternoon = 0) as not_posted_afternoon_count,
                 COUNT(DISTINCT social_id) as social_count')
                    ->groupBy('social_date', 'user_id');

                if ($request->has('user_id') && !empty($request->user_id)) {
                    $query->where('user_id', $request->user_id);
                }

                if ($request->has('start_date') && !empty($request->start_date)) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }

                if ($request->has('end_date') && !empty($request->end_date)) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }

                Log::info('SocialAudit Query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

                $socialAudits = $query->get();

                return DataTables::of($socialAudits)
                    ->addColumn('user_name', function ($row) {
                        $user = User::find($row->user_id);
                        $userName = $user ? $user->first_name . ' ' . $user->last_name : '';
                        $showRoute = route('social_audits.show', ['user_id' => $row->user_id, 'date' => $row->social_date]);

                        return '<a href="' . $showRoute . '">' . htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') . '</a>';
                    })
                    ->addColumn('social_date', function ($row) {
                        return $row->social_date;
                    })
                    // ->addColumn('morning_done_count', function ($row) {
                    //     return $row->morning_done_count;
                    // })
                    // ->addColumn('afternoon_done_count', function ($row) {
                    //     return $row->afternoon_done_count;
                    // })
                    ->addColumn('social_count', function ($row) {
                        return $row->social_count;
                    })
                    ->rawColumns(['user_name'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('Error in SocialAuditController@index:', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
            }
        }

        return view('socialmanagement::social_audit.index', compact('users'));
    }

    public function show(Request $request, $user_id, $date)
{
    $business_id = $request->session()->get('user.business_id');

    if ($request->ajax()) {
        $query = SocialAudit::where('business_id', $business_id)
            ->where('user_id', $user_id)
            ->whereDate('created_at', $date);

        if ($request->has('audit_status') && !is_null($request->audit_status)) {
            $auditStatus = $request->audit_status;
            $query->where(function ($q) use ($auditStatus) {
                $q->where('social_audit_morning', $auditStatus)
                    ->orWhere('social_audit_afternoon', $auditStatus);
            });
        }

        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $socialAudits = $query->get();

        return datatables()->of($socialAudits)
            ->addColumn('social_name', function ($row) {
                $social = Social::findOrFail($row->social_id);
                return $social->name;
            })
            ->addColumn('user_name', function ($row) {
                $user = User::findOrFail($row->user_id);
                return $user->first_name . ' ' . $user->last_name;
            })
            ->addColumn('morning_audit', function ($row) {
                return $row->posted_morning;
            })
            ->addColumn('afternoon_audit', function ($row) {
                return $row->sposted_afternoon;
            })
            ->addColumn('morning_note', function ($row) {
                return $row->social_note_morning;
            })
            ->addColumn('afternoon_note', function ($row) {
                return $row->social_note_afternoon;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->rawColumns(['user_name'])
            ->make(true);
    }

    return view('socialmanagement::social_audit.view', compact('user_id', 'date'));
}


    public function create(Request $request)
    {
        $businessId = $request->query('business_id');
        $business_id = request()->session()->get('user.business_id');
        $userId = $request->query('user_id');
        $users = User::forDropdown($business_id, false);

        $socialAudits = collect();
        $socials = collect();

        if ($userId) {
            // Check if there are existing SocialAudit records for today
            $today = now()->format('Y-m-d');
            $socialAudits = SocialAudit::where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->get();

            if ($socialAudits->isEmpty()) {
                // If no records for today, get socials assigned to the user
                $socials = Social::where('assign_to', $userId)
                    ->get();
            }
        }

        return view('socialmanagement::social_audit.create', compact('users', 'socials', 'businessId', 'socialAudits', 'userId'));
    }

    // Function to store data into the SocialAudit model
    public function store(Request $request)
    {
        $request->validate([
            'audits.*.user_id' => 'required|integer',
            'audits.*.business_id' => 'required|integer',
            'audits.*.social_id' => 'required|integer',
            'audits.*.social_audit_morning' => 'boolean',
            'audits.*.posted_morning' => 'boolean',
            'audits.*.social_note_morning' => 'nullable|string',
            'audits.*.social_audit_afternoon' => 'boolean',
            'audits.*.posted_afternoon' => 'boolean',
            'audits.*.social_note_afternoon' => 'nullable|string',
        ]);

        foreach ($request->audits as $auditData) {
            SocialAudit::create($auditData);
        }

        return response()->json(['message' => 'Social Audit created successfully.']);
    }

    // Function to update data in the SocialAudit model
    public function update(Request $request)
    {
        $request->validate([
            'audits.*.id' => 'required|integer',
            'audits.*.user_id' => 'required|integer',
            'audits.*.business_id' => 'required|integer',
            'audits.*.social_id' => 'required|integer',
            'audits.*.social_audit_morning' => 'boolean',
            'audits.*.posted_morning' => 'boolean',
            'audits.*.social_note_morning' => 'nullable|string',
            'audits.*.social_audit_afternoon' => 'boolean',
            'audits.*.posted_afternoon' => 'boolean',
            'audits.*.social_note_afternoon' => 'nullable|string',
        ]);

        foreach ($request->audits as $auditData) {
            $audit = SocialAudit::find($auditData['id']);
            $audit->update($auditData);
        }

        return response()->json(['message' => 'Social Audit updated successfully.']);
    }
}
