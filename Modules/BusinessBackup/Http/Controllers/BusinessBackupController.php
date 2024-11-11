<?php

namespace Modules\BusinessBackup\Http\Controllers;

use App\Business;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Utils\ModuleUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Storage;

class BusinessBackupController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param CommonUtil
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {   
        if (request()->ajax()) {
            $date_today = \Carbon::today();
            $businesses = Business::leftjoin('subscriptions AS s', function($join) use ($date_today){
                                $join->on('business.id', '=', 's.business_id')
                                    ->whereDate('s.start_date', '<=', $date_today)
                                    ->whereDate('s.end_date', '>=', $date_today)
                                    ->where('s.status', 'approved');
                            })
                            ->leftjoin('packages as p', 's.package_id', '=', 'p.id' )
                            ->leftjoin('business_locations as bl', 'business.id', '=', 'bl.business_id' )
                            ->leftjoin('users as u', 'u.id', '=', 'business.owner_id')
                            ->leftjoin('users as creator', 'creator.id', '=', 'business.created_by')
                            ->select(
                                    'business.id', 
                                    'business.name',
                                    DB::raw("CONCAT(COALESCE(u.surname, ''), ' ', COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, '')) as owner_name"),
                                    'u.email as owner_email',
                                    'u.contact_number',
                                    'bl.mobile',
                                    'bl.alternate_number',
                                    'bl.city',
                                    'bl.state',
                                    'bl.country',
                                    'bl.landmark',
                                    'bl.zip_code',
                                    'business.is_active',
                                    's.start_date',
                                    's.end_date',
                                    'p.name as package_name',
                                    'business.created_at',
                                    DB::raw("CONCAT(COALESCE(creator.surname, ''), ' ', COALESCE(creator.first_name, ''), ' ', COALESCE(creator.last_name, '')) as biz_creator")
                                )->groupBy('business.id');
                    if (!auth()->user()->can('superadmin')) {
                        $businesses->where('business.id', request()->business_id);
                    }
                        
            return Datatables::of($businesses)
                ->addColumn( 'address', '{{$city}}, {{$state}}, {{$country}} {{$landmark}}, {{$zip_code}}')
                ->addColumn( 'business_contact_number', '{{$mobile}} @if(!empty($alternate_number)), {{$alternate_number}}@endif')
                ->editColumn( 'is_active', '@if($is_active == 1) <span class="label bg-green">@lang("business.is_active")</span> @else <span class="label bg-gray">@lang("lang_v1.inactive")</span> @endif')
                ->addColumn('action', function($row) {
                    $html = '<a href="' . 
                            action("\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@download", [$row->id]) . '"
                                class="btn btn-info btn-xs">' . __('Backup' ) . '</a>
                            ';

                            // if(request()->session()->get('user.business_id') != $row->id) {
                            //     $html .= ' <a href="' . action('\Modules\Superadmin\Http\Controllers\BusinessController@destroy', [$row->id]) . '"
                            //         class="btn btn-danger btn-xs delete_business_confirmation">' . __('messages.delete' ) . '</a>';
                            // }

                    return $html;
                })
                ->filterColumn('owner_name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('address', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(city, ''), ', ', COALESCE(state, ''), ', ', COALESCE(country, ''), ', ', COALESCE(landmark, ''), ', ', COALESCE(zip_code, '')) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('business_contact_number', function ($query, $keyword) {
                    $query->where(function($q) use ($keyword){
                        $q->where('bl.mobile', 'like', "%{$keyword}%")
                        ->orWhere('bl.alternate_number', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('current_subscription', '{{$package_name ?? ""}} @if(!empty($start_date) && !empty($end_date)) ({{@format_date($start_date)}} - {{@format_date($end_date)}}) @endif')
                ->editColumn('created_at', '{{@format_datetime($created_at)}}')
                ->rawColumns(['action', 'is_active', 'created_at'])
                ->make(true);
        }

        $business_id = request()->session()->get('user.business_id');
        
        return view('businessbackup::index')
            ->with(compact('business_id'));

    }

     /**
     * Create a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');
        if (!auth()->user()->can('backup')) {
            abort(403, 'Unauthorized action.');
        }

        try {
           
            $targetTables = ['users', 'units'];
            $newLine = "\n";
    
            foreach ($targetTables as $table)
            {
                $tableData = DB::select(DB::raw('SELECT * FROM ' . $table . ' WHERE business_id=1'));
                $res = DB::select(DB::raw('SHOW CREATE TABLE ' . $table))[0];
    
                $cnt = 0;
                $content = (!isset($content) ?  "SET FOREIGN_KEY_CHECKS = 0; DROP TABLE IF EXISTS '{$table}'; " : $content." DROP TABLE IF EXISTS '{$table}'; ") . $res->{"Create Table"} . ";" . $newLine . $newLine;
                foreach ($tableData as $row)
                {
                    $subContent = "";
                    $firstQueryPart = "";
                    if ($cnt == 0 || $cnt % 100 == 0)
                    {
                        $firstQueryPart .= "INSERT INTO {$table} VALUES ";
                        if (count($tableData) > 1)
                        {
                            $firstQueryPart .= $newLine;
                        }
                    }
    
                    $valuesQuery = "(";
                    foreach ($row as $key => $value)
                    {
                        $valuesQuery .= "'$value'" . ", ";
                    }
    
                    $subContent = $firstQueryPart . rtrim($valuesQuery, ", ") . ")";
    
                    if ((($cnt + 1) % 100 == 0 && $cnt != 0) || $cnt + 1 == count($tableData))
                    {
                        $subContent .= ";" . $newLine;
                    }
                    else
                    {
                        $subContent .= ",";
                    }
    
                    $content .= $subContent;
                    $cnt++;
                }
    
                $content .= $newLine;
            }
    
            $content = trim($content);
    
            $dbBackupFile = public_path('uploads\UltimatePOS\\' );
            if (!File::exists($dbBackupFile))
            {
                File::makeDirectory($dbBackupFile, 0755, true);
            }
    
            $dbBackupFile .= "BackupDB.sql";
    
            $handle = fopen($dbBackupFile, "w+");
            fwrite($handle, $content);
            fclose($handle);

            // log the results
            // Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            
            $output = ['success' => 1,
                        'msg' => __('lang_v1.success')
                    ];
        } catch (Exception $e) {
            $output = ['success' => 0,
                        'msg' => $e->getMessage()
                    ];
        }

        return back()->with('status', $output);
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($business_id)
    {
        // if (!auth()->user()->can('backup')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $targetTables = [];
        $newLine = "\n";

        
        $queryTables = DB::select(DB::raw('SHOW TABLES'));
        foreach ($queryTables as $table)
        {
            
            foreach ($table as $tbname)
            {
                $columns = DB::select("SHOW COLUMNS FROM $tbname");
                foreach ($columns as $column) {
                    if ($column->Field == 'business_id')
                        $targetTables[] = $tbname;
                }
            }
        }
            $newLine = "\n";
    
            foreach ($targetTables as $table)
            {
                $tableData = DB::select(DB::raw('SELECT * FROM ' . $table . ' WHERE business_id='.$business_id));
                $res = DB::select(DB::raw('SHOW CREATE TABLE ' . $table))[0];
    
                $cnt = 0;
                $content = (!isset($content) ?  "SET FOREIGN_KEY_CHECKS = 0; DROP TABLE IF EXISTS '{$table}'; " : $content." DROP TABLE IF EXISTS '{$table}'; ") . $res->{"Create Table"} . ";" . $newLine . $newLine;
                foreach ($tableData as $row)
                {
                    $subContent = "";
                    $firstQueryPart = "";
                    if ($cnt == 0 || $cnt % 100 == 0)
                    {
                        $firstQueryPart .= "INSERT INTO {$table} VALUES ";
                        if (count($tableData) > 1)
                        {
                            $firstQueryPart .= $newLine;
                        }
                    }
    
                    $valuesQuery = "(";
                    foreach ($row as $key => $value)
                    {
                        $valuesQuery .= "'$value'" . ", ";
                    }
    
                    $subContent = $firstQueryPart . rtrim($valuesQuery, ", ") . ")";
    
                    if ((($cnt + 1) % 100 == 0 && $cnt != 0) || $cnt + 1 == count($tableData))
                    {
                        $subContent .= ";" . $newLine;
                    }
                    else
                    {
                        $subContent .= ",";
                    }
    
                    $content .= $subContent;
                    $cnt++;
                }
    
                $content .= $newLine;
            }
    
            $content = trim($content);
    
            $dbBackupFile = public_path('uploads/'.config('backup.backup.name').'/' );
            if (!File::exists($dbBackupFile))
            {
                File::makeDirectory($dbBackupFile, 0755, true);
            }
            $date_today = \Carbon::today();
            $file_name = $business_id."_BackupDB".$date_today->toDateString().".sql";
            $dbBackupFile .= $file_name;
    
            $handle = fopen($dbBackupFile, "w+");
            fwrite($handle, $content);
            fclose($handle);

        $file = config('backup.backup.name') . '/' . $file_name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            $fs = Storage::disk(config('backup.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        if (!auth()->user()->can('backup')) {
            abort(403, 'Unauthorized action.');
        }

        //Disable in demo
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                            'msg' => 'Feature disabled in demo!!'
                        ];
            return back()->with('status', $output);
        }

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists(config('backup.backup.name') . '/' . $file_name)) {
            $disk->delete(config('backup.backup.name') . '/' . $file_name);
            return redirect()->back();
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }
}
