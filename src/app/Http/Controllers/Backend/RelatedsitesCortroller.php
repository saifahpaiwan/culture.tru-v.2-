<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\related_sites;

class RelatedsitesCortroller extends Controller
{
    public function relatedsiteslist()
    {
        $data = array();
        return view('backend.relatedsites.relatedsite_list', compact('data'));
    }

    public function relatedsitesadd()
    {
        $data = array();
        return view('backend.relatedsites.relatedsite_add', compact('data'));
    }

    public function relatedsitesedit($get_id)
    {
        $data = array(
            "relatedsites_find" => related_sites::find($get_id),
        );
        return view('backend.relatedsites.relatedsite_edit', compact('data'));
    }


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {
        $keywrod_sql = "";  
        $status_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and related_sites.title LIKE '%" . $keywrod . "%'";
        }
        if(isset($status)){  
            $status_sql=" and related_sites.deleted_at = ".$status.""; 
        }
 
        $data = DB::select('select * 
        from `related_sites` 
        where related_sites.id != "" 
        ' . $keywrod_sql . ' '.$status_sql.'
        order by related_sites.id DESC');

        return $data;
    }

    public function datatableRelatedsites(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('relatedsites_img', function ($row) {
                    $img = '<img src="' . asset('images/relatedsites') . '/' . $row->image_desktop . '"  class="mr-2" width="100" height="50" style="border: 1px solid #ddd;border-radius: 5px;">';
                    return '<a href="' . route('relatedsites.edit', [$row->id]) . '"> ' .  $img . '</a>';
                })
                ->addColumn('title', function ($row) { 
                    return '<a href="' . route('relatedsites.edit', [$row->id]) . '"> '.$row->title . '</a>';;
                })
                ->addColumn('relatedsites_status', function ($row) {
                    $deleted_at = '<span class="badge badge-success"> เปิดการแสดงผล </span>';
                    if ($row->deleted_at == 1) {
                        $deleted_at = '<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                    }
                    return $deleted_at;
                })
                ->addColumn('bntManger', function ($row) {
                    $html = '<a href="' . route('relatedsites.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['relatedsites_img', 'relatedsites_status', 'title', 'bntManger'])
                ->make(true);
        }
    }

    public function closeRelatedsites(Request $request)
    {
        if (isset($request)) {
            $data = related_sites::find($request->id);
            $uploade_location = 'images/relatedsites/';

            if (!empty($data->image_desktop)) {
               @unlink($uploade_location . $data->image_desktop);  
            }

            $data = DB::table('related_sites')
                ->where('related_sites.id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function saveRelatedsites(Request $request)
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
                    $uploade_location_dektop = 'images/relatedsites/';

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
                'title'  => $request->relatedsites_title, 
                'slug'             => $request->relatedsites_link, 
                'image_desktop' => $file_name_decktop,

                'deleted_at' => $request->status,
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),
            );

            if ($request->statusData == "C") {
                DB::table('related_sites')->insert($data);
                return redirect()->route('relatedsites.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('related_sites')
                    ->where('related_sites.id', $request->id)
                    ->update($data);
                return redirect()->route('relatedsites.edit', [$request->id])->with('success', $msg);
            }
        }
    }
}
