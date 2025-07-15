<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\appeals;
use App\Models\researchs;
use App\Models\satisfaction;
use App\Models\video_youtube; 

class HomeController extends Controller
{
    public function home()
    {
        $data = array();
        return view('backend.home', compact('data'));
    }  

    public function appealslist()
    {
        $data = array();
        return view('backend.appeals.list', compact('data'));
    } 

    public function appealsview($get_id)
    {
        $data = array(
            "appeals_find" => appeals::find($get_id),
        );
        return view('backend.appeals.view', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {
        $keywrod_sql = "";
        $status_sql = "";
        $date_sql = "";

        if (isset($keywrod)) {
            $keywrod_sql = " and appeals.name LIKE '%" . $keywrod . "%'
            or appeals.email LIKE '%" . $keywrod . "%'
            or appeals.topic LIKE '%" . $keywrod . "%' ";
        }

        if (isset($status)) {
            $status_sql = " and appeals.deleted_at = " . $status . "";
        }

        if (isset($date)) {
            $date_sql=" and (appeals.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59')"; 
        }

        $data = DB::select('select * 
        from `appeals` 
        where appeals.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . ' ' . $date_sql . '
        order by appeals.id DESC');

        return $data;
    }

    public function datatableAppeals(Request $request)
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
                    return $row->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                }) 
                ->addColumn('topic', function ($row) {
                    return '<a href="' . route('appeals.view', [$row->id]) . '"> ' .$row->topic . '</a>';
                })  
                ->addColumn('bntManger', function ($row) { 
                    $html = '<a href="' . route('appeals.view', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="fe-file-text"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['id', 'topic', 'name', 'email', 'bntManger'])
                ->make(true);
        }
    }

    public function closeappeals(Request $request)
    {
        if (isset($request)) { 
            if(DB::table('appeals')
                ->where('appeals.id', $request->id)
                ->delete()){
                    return "success";
                }
        } 
    }

    public function youtubeEdit()
    {
        $data = array(
            "videoYoutube" => video_youtube::where('id', 1)->first(),
        );
        return view('backend.videoYoutube.view', compact('data'));
    }

     public function youtubeSave(Request $request)
    { 
        video_youtube::where('id', $request->id)->update([
            'link' => $request->link,
            'deleted_at' => $request->status,
        ]);

        return redirect()->route('youtube.edit')->with("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    }

    public function satisfactionEdit()
    {
        $data = array(
            "satisfaction" => satisfaction::where('id', 1)->first(),
        );
        return view('backend.satisfaction.view', compact('data'));
    }

     public function satisfactionSave(Request $request)
    { 
        satisfaction::where('id', $request->id)->update([
            'value' => $request->value ?? 0,
        ]);

        return redirect()->route('satisfaction.edit')->with("success", "บันทึกข้อมูลเรียบร้อยแล้ว");
    }
}
