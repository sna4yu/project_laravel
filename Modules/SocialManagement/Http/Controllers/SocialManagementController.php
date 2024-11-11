<?php

namespace Modules\SocialManagement\Http\Controllers;

use App\BusinessLocation;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SocialManagement\Entities\SocialCategory;
use Modules\SocialManagement\Entities\Social;
use Modules\AssetManagement\Entities\Asset;
use Modules\AssetManagement\Entities\AssetTransaction;
use Modules\AssetManagement\Utils\AssetUtil;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class SocialManagementController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $moduleUtil;

    protected $commonUtil;

    protected $assetUtil;

    protected $purchaseTypes;

    /**
     * Constructor
     */
    public function __construct(ModuleUtil $moduleUtil, Util $commonUtil, AssetUtil $assetUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->assetUtil = $assetUtil;

        $this->purchaseTypes = [
            'owned' => __('assetmanagement::lang.owned'),
            'rented' => __('assetmanagement::lang.rented'),
            'leased' => __('assetmanagement::lang.leased'),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $assets = Social::all();

            return DataTables::of($assets)
                ->addColumn('action', function ($row) {
                    $html = '<button class="btn btn-xs btn-info btn-modal" data-href="' . route('social.edit', $row->id) . '" data-container=".asset_modal"><i class="fa fa-edit"></i> ' . __('messages.edit') . '</button>';
                    $html .= ' <button class="btn btn-xs btn-danger delete-asset" data-href="' . route('social.destroy', $row->id) . '"><i class="fa fa-trash"></i> ' . __('messages.delete') . '</button>';
                    return $html;
                })
                ->addColumn('category_id', function ($row) {
                    $category = SocialCategory::find($row->social_category_id);
                    return $category ? $category->name : '';
                })
                ->addColumn('assign_to', function ($row) {
                    $user = User::find($row->assign_to);
                    $name = $user->first_name . ' ' . $user->last_name;
                    return $name ? $name : '';
                })
                ->addColumn('create_by', function ($row) {
                    $user = User::find($row->created_by);
                    $name = $user->first_name . ' ' . $user->last_name;
                    return $name ? $name : '';
                })
                ->addColumn('link', function ($row) {
                    return '<a href="' . $row->link . '" target="_blank">' . $row->link . '</a>';
                })
                ->rawColumns(['action', 'link'])
                ->make(true);
        }

        return view('socialmanagement::asset.index');
    }

    public function create(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $asset_categories = SocialCategory::forDropdown($business_id);
        $users = User::forDropdown($business_id);

        return view('socialmanagement::asset.create', compact('asset_categories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'social_category_id' => 'required|integer|exists:social_categories,id',
            'assign_to',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'link' => 'nullable|url|max:255',
        ]);

        $business_id = request()->session()->get('user.business_id');

        try {
            $social = new Social();
            $social->asset_id = $request->asset_id;
            $social->name = $request->name;
            $social->description = $request->description;
            $social->business_id = $business_id;
            $social->social_category_id = $request->social_category_id;
            $social->assign_to = $request->assign_to;
            $social->email = $request->email;
            $social->password = $request->password;
            $social->link = $request->link;
            $social->created_by = auth()->user()->id;
            $social->save();

            return response()->json(['success' => true, 'msg' => __('messages.saved_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('messages.something_went_wrong')]);
        }
    }

    public function edit($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $social = Social::find($id);
        $asset_categories = SocialCategory::forDropdown($business_id);
        $users = User::forDropdown($business_id);

        return view('socialmanagement::asset.edit', compact('social', 'asset_categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'social_category_id' => 'required|integer|exists:social_categories,id',
            'assign_to',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'link' => 'nullable|url|max:255',
        ]);

        try {
            $social = Social::find($id);
            $social->asset_id = $request->asset_id;
            $social->name = $request->name;
            $social->description = $request->description;
            $social->social_category_id = $request->social_category_id;
            $social->assign_to = $request->assign_to;
            $social->email = $request->email;
            $social->password = $request->password;
            $social->link = $request->link;
            $social->created_by = auth()->user()->id;
            $social->save();

            return response()->json(['success' => true, 'msg' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('messages.something_went_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            Social::destroy($id);
            return response()->json(['success' => true, 'msg' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('messages.something_went_wrong')]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function dashboard()
    {
        $business_id = request()->session()->get('user.business_id');

    // Total social accounts
    $total_social_accounts = DB::table('social_table')
        ->where('business_id', $business_id)
        ->count();

    $total_social_category =SocialCategory::where('business_id', $business_id)
    ->count();

    // Social accounts by category
    $social_by_category = DB::table('social_table as s')
        ->leftJoin('social_categories as sc', 's.social_category_id', '=', 'sc.id')
        ->select(
            DB::raw('COUNT(s.id) as total'),
            'sc.name as category'
        )
        ->where('s.business_id', $business_id)
        ->groupBy('sc.id')
        ->get();

    // Social accounts assigned to the current user
    // $user_id = auth()->user()->id;
    // $assigned_social_accounts = DB::table('social_table')
    //     ->where('business_id', $business_id)
    //     ->where('assign_to', $user_id)
    //     ->count();

     // Social accounts assigned to the current user
     $user_id = auth()->user()->id;
     $assigned_social_accounts = DB::table('social_table as s')
         ->leftJoin('social_categories as sc', 's.social_category_id', '=', 'sc.id')
         ->select('s.name as social_account', 'sc.name as category')
         ->where('s.business_id', $business_id)
         ->where('s.assign_to', $user_id)
         ->get();

    return view('socialmanagement::asset.dashboard')
        ->with(compact('total_social_accounts', 'social_by_category', 'assigned_social_accounts','total_social_category'));
    }

    public function getCategories(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        if (request()->ajax()) {
            $categories = SocialCategory::where('business_id', $business_id)->get();

            return DataTables::of($categories)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('asset.edit')) {
                        $html .= '<button class="btn btn-xs btn-info btn-modal" data-href="' . route('social-categories.edit', $row->id) . '" data-container=".category_modal"><i class="fa fa-edit"></i> ' . __('messages.edit') . '</button>';
                    }
                    if (auth()->user()->can('asset.delete')) {
                        $html .= ' <button class="btn btn-xs btn-danger delete-category" data-href="' . route('social-categories.destroy', $row->id) . '"><i class="fa fa-trash"></i> ' . __('messages.delete') . '</button>';
                    }
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('socialmanagement::category.index');
    }



    public function createCategory()
    {
        return view('socialmanagement::category.create');
    }

    public function storeCategory(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        try {
            $category = new SocialCategory();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->business_id = $business_id;
            $category->save();

            return response()->json(['success' => true, 'msg' => __('messages.saved_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('messages.something_went_wrong')]);
        }
    }

    public function editCategory($id)
    {
        $category = SocialCategory::find($id);
        return view('socialmanagement::category.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $business_id = request()->session()->get('user.business_id');

        try {
            $category = SocialCategory::find($id);
            $category->name = $request->name;
            $category->business_id = $business_id;
            $category->description = $request->description;
            $category->save();

            return response()->json(['success' => true, 'msg' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('messages.something_went_wrong')]);
        }
    }

    public function destroyCategory($id)
    {
        try {
            SocialCategory::destroy($id);
            return response()->json(['success' => true, 'msg' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('messages.something_went_wrong')]);
        }
    }
}
