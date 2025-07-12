<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\popups;

class PopupsController extends Controller
{
    public function popupslist()
    {
        $data = array();
        return view('backend.popups.popups_list', compact('data'));
    }

    public function popupsadd()
    {
        $data = array();
        return view('backend.popups.popups_add', compact('data'));
    }

    public function popupsedit($get_id)
    {
        $data = array(
            "popups_find" => popups::find($get_id),
        );
        return view('backend.popups.popups_edit', compact('data'));
    }


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {
        $keywrod_sql = "";  
        $status_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and popups.title LIKE '%" . $keywrod . "%'";
        }
        if(isset($status)){  
            $status_sql=" and popups.deleted_at = ".$status.""; 
        }
 
        $data = DB::select('select * 
        from `popups` 
        where popups.id != "" 
        ' . $keywrod_sql . ' '.$status_sql.'
        order by popups.id DESC');

        return $data;
    }

    public function datatablePopups(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('popups_img', function ($row) {
                    $img = '<img src="' . asset('images/popups') . '/' . $row->image_desktop . '"  class="mr-2" height="100" style="border: 1px solid #ddd;border-radius: 5px;">';
                    return '<a href="' . route('popups.edit', [$row->id]) . '"> ' .  $img . '</a>';
                })
                ->addColumn('title', function ($row) { 
                    return '<a href="' . route('popups.edit', [$row->id]) . '"> '.$row->title . '</a>';;
                })
                ->addColumn('popups_status', function ($row) {
                    $deleted_at = '<span class="badge badge-success p-1"> เปิดการแสดงผล </span>';
                    if ($row->deleted_at == 1) {
                        $deleted_at = '<span class="badge badge-danger p-1"> ปิดการแสดงผล </span>';
                    }
                    return $deleted_at;
                })
                ->addColumn('bntManger', function ($row) {
                    $html = '<a href="' . route('popups.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary mb-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger mb-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['popups_img', 'popups_status', 'title', 'bntManger'])
                ->make(true);
        }
    }

    public function closePopups(Request $request)
    {
        if (isset($request)) {
            $data = popups::find($request->id);
            $uploade_location = 'images/popups/';

            if (!empty($data->image_desktop)) {
               @unlink($uploade_location . $data->image_desktop);  
            }

            $data = DB::table('popups')
                ->where('popups.id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function savePopups(Request $request)
    {
        if (isset($request)) {
            $request->validate(
                [ 
                    'status' => ['required'], 
                    'file_upload_dektop' => 'image|mimes:jpeg,png,jpg|max:3072',
                ]
            );

            if ($request->statusData == "C") {
                $dataType = "created_at";
                $msg = "Save data successfully."; 
                $file_name_decktop = NULL;
            } else if ($request->statusData == "U") {
                $dataType = "updated_at";
                $msg = "Update data successfully."; 
                $file_name_decktop = $request->file_upload_dektop_hdf;
            }
  
            if ($request->file('file_upload_dektop')) {
                if (!empty($request->file('file_upload_dektop'))) {
                    $uploade_location_dektop = 'images/popups/';

                    if ($request->statusData == "U" && $file_name_decktop != "") {
                       @unlink($uploade_location_dektop . $file_name_decktop);
                    }

                    $file_dektop = $request->file('file_upload_dektop');
                    $file_gen_dektop = hexdec(uniqid());
                    $file_ext_dektop = strtolower($file_dektop->getClientOriginalExtension());
                    $file_name_decktop = $file_gen_dektop . '.' . $file_ext_dektop;
                    $file_dektop->move($uploade_location_dektop, $file_name_decktop);
                }
            }

            $data = array(
                'title'  => $request->popups_title,
                'description'       => $request->description,
                'link'             => $request->popups_link, 
                'image_desktop' => $file_name_decktop,

                'deleted_at' => $request->status,
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),
            );

            if ($request->statusData == "C") {
                DB::table('popups')->insert($data);
                return redirect()->route('popups.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('popups')
                    ->where('popups.id', $request->id)
                    ->update($data);
                return redirect()->route('popups.edit', [$request->id])->with('success', $msg);
            }
        }
    }
}
