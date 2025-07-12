<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DataTables;  
use App\Models\User; 

class RolesController extends Controller
{
    public function roleslist()
    {
        $data = array();
        return view('backend.roles.roles_list', compact('data'));
    }

    public function rolesadd()
    {
        $data = array();
        return view('backend.roles.roles_add', compact('data'));
    }

    public function rolesedit($get_id)
    {
        $data = array(
            "User_find" => User::find($get_id),
        );
        return view('backend.roles.roles_edit', compact('data'));
    }

    // ==========FUNCTION========== //

    public function Query_Datatable($keywrod, $status)
    {
        $keywrod_sql = "";
        $status_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and users.name LIKE '%" . $keywrod . "%'
            or users.email LIKE '%" . $keywrod . "%'
            or users.tel LIKE '%" . $keywrod . "%'";
        }

        if (isset($status)) {
            $status_sql = " and users.deleted_at = " . $status . "";
        }

        $data = DB::select('select * 
        from `users` 
        where users.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . '
        order by users.id asc');

        return $data;
    }

    public function datatableRoles(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn('name', function ($row) {
                    $img = '<img src="' . asset('images/admin.png') . '" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
                    $tag = $img . $row->name;
                    if ($row->roles != 1) {
                        $tag = '<a href="' . route('roles.edit', $row->id) . '">' . $img . $row->name . '</a>';
                    }
                    return $tag;
                })
                ->addColumn('deleted_at', function ($row) {
                    $deleted_at = '<span class="badge badge-success"> เปิดการเข้าใช้งาน </span>';
                    if ($row->deleted_at == 1) {
                        $deleted_at = '<span class="badge badge-danger"> ปิดการเข้าใช้งาน </span>';
                    }
                    return $deleted_at;
                })
                ->addColumn('bntManger', function ($row) {
                    $html = '<div class="text-left"> <span class="badge badge-primary w-100"> Owner </span> </div>';
                    if ($row->roles != 1) {
                        if ($row->id == Auth::user()->id) {
                            $html = '<a href="' . route('roles.edit', $row->id) . '" class="btn btn-xs btn-icon waves-effect btn-secondary"> <i class="mdi mdi-pencil"></i> </a>';
                            $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-info"> Active </button>';
                        } else {
                            $html = '<a href="' . route('roles.edit', $row->id) . '" class="btn btn-xs btn-icon waves-effect btn-secondary"> <i class="mdi mdi-pencil"></i> </a>';
                            $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                        }
                    }
                    return $html;
                })
                ->rawColumns(['id', 'name', 'deleted_at', 'bntManger'])
                ->make(true);
        }
    }

    public function saveRoles(Request $request)
    {
        if (isset($request)) {

            if ($request->statusData == "C") {
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'], 
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'same:passwordConfirm'],
                        'passwordConfirm' => 'required',

                        'status' => 'required'
                    ]
                );

                $dataType = "created_at";
                $msg = "Save data successfully.";

                $data = array(
                    'name'  => $request->name, 
                    'email'  => $request->email,
                    'password'  => Hash::make($request->password),
                    'roles'     => 2,

                    'ip_address'    => $request->ip(),
                    'deleted_at' => $request->status,
                    $dataType    => new \DateTime(),
                );
            } else if ($request->statusData == "U") {
                $user = User::find($request->id);
                $userPassword = $user->password;
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'], 
                        'old_password' => ['string', 'min:8'],
                        'password' => ['string', 'min:8', 'same:passwordConfirm'],

                        'status' => 'required'
                    ]
                );

                if (isset($request->changepassCheck) && $request->changepassCheck == "Y") {
                    if (!Hash::check($request->old_password, $userPassword)) {
                        return back()->withErrors(['old_password' => 'รหัสผ่านไม่ตรงกัน !']);
                    }
                }

                $dataType = "updated_at";
                $msg = "Update data successfully.";

                $data = array(
                    'name'  => $request->name, 
                    'password'  => Hash::make($request->password),
                    'roles'     => 2,

                    'ip_address'    => $request->ip(),
                    'deleted_at' => $request->status,
                    $dataType    => new \DateTime(),
                );
            }

            if ($request->statusData == "C") {
                DB::table('users')->insert($data);
                return redirect()->route('roles.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('users')
                    ->where('users.id', $request->id)
                    ->update($data);
                return redirect()->route('roles.edit', [$request->id])->with('success', $msg);
            }
        }
    }

    public function closeRoles(Request $request)
    {
        if (isset($request)) {

            $data = DB::table('users')
                ->where('users.id', $request->id)
                ->delete();
        }
        return $data;
    }
}
