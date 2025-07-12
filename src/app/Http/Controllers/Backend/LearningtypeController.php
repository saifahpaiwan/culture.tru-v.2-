<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\learning_types;  

class LearningtypeController extends Controller
{
    public function learningtypelist()
    {
        $data = array();
        return view('backend.learningtype.list', compact('data'));
    }

    public function learningtypeadd()
    {
        $data = array();
        return view('backend.learningtype.add', compact('data'));
    }

    public function learningtypeedit($get_id)
    {
        $data = array(
            "learningtype_find" => learning_types::find($get_id),
        );
        return view('backend.learningtype.edit', compact('data'));
    }
 
    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {
        $keywrod_sql = "";
        $status_sql = "";
        $date_sql = "";

        if (isset($keywrod)) {
            $keywrod_sql = " and learning_types.name LIKE '%" . $keywrod . "%' ";
        }

        if (isset($status)) {
            $status_sql = " and learning_types.deleted_at = " . $status . "";
        }

        if (isset($date)) {
            $date_sql=" and (learning_types.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59')";  
        }

        $data = DB::select('select * 
        from `learning_types` 
        where learning_types.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . ' ' . $date_sql . '
        order by learning_types.id DESC');

        return $data;
    }

    public function datatablelearningtype(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status, $request->date);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn('name', function ($row) {
                    return '<a href="' . route('learningtype.edit', [$row->id]) . '"> ' . $row->name . '</a>';
                })  
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('deleted_at', function ($row) {
                    $deleted_at = '<span class="badge badge-success"> เปิดการแสดงผล </span>';
                    if ($row->deleted_at == 1) {
                        $deleted_at = '<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                    }
                    return $deleted_at;
                })
                ->addColumn('bntManger', function ($row) {
                    $html = '<a href="' . route('learningtype.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['id', 'name', 'created_at', 'deleted_at', 'bntManger'])
                ->make(true);
        }
    }

    public function closelearningtype(Request $request)
    {
        if (isset($request)) { 
            $data = DB::table('learning_types')
                ->where('learning_types.id', $request->id)
                ->delete(); 
        }
        return $data;
    }

    public function savelearningtype(Request $request)
    {
        if (isset($request)) {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],   
                ]
            );

            if ($request->statusData == "C") {
                $dataType = "created_at";
                $msg = "Save data successfully."; 
            } else if ($request->statusData == "U") {
                $dataType = "updated_at";
                $msg = "Update data successfully."; 
            }
   
            $data = array(
                'name'  => $request->name, 
                  
                'deleted_at' => $request->status,
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),
            );

            if ($request->statusData == "C") {
                DB::table('learning_types')->insert($data);
                return redirect()->route('learningtype.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('learning_types')
                    ->where('learning_types.id', $request->id)
                    ->update($data);
                return redirect()->route('learningtype.edit', [$request->id])->with('success', $msg);
            }
        }
    }
    
}
