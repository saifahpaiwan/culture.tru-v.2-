<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\networks;
use App\Models\network_gallerys;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class NetworksController extends Controller
{
    public function networkslist()
    {
        $data = array();
        return view('backend.networks.list', compact('data'));
    }

    public function networksadd()
    {
        $data = array();
        return view('backend.networks.add', compact('data'));
    }

    public function networksedit($get_id)
    {
        $data = array(
            "networks_find" => networks::find($get_id),
        );
        return view('backend.networks.edit', compact('data'));
    }

    public function networksdropzone($get_id)
    {
        $data = array(
            "networks_find" => networks::find($get_id),
            "gallerys"      => DB::table('network_gallerys')->where('network_id', $get_id)->get(),
            "get_id"        => $get_id,
        );
        return view('backend.networks.dropzone', compact('data'));
    }


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {
        $keywrod_sql = "";
        $status_sql = "";
        $date_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and networks.title LIKE '%" . $keywrod . "%'";
        }

        if (isset($status)) {
            $status_sql = " and networks.deleted_at = " . $status . "";
        }

        if (isset($date)) {
            $date_sql = " and (networks.created_at BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59')";
        }

        $data = DB::select('select * 
        from `networks` 
        where networks.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . ' ' . $date_sql . '
        order by networks.id DESC');

        return $data;
    }

    public function datatablenetworks(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status, $request->date);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('images', function ($row) {
                    $img = '<img src="' . asset('images/networks') . '/' . $row->image_desktop . '" alt="contact-img" title="contact-img" class="mr-2" width="100%" style="border: 1px solid #ddd;border-radius: 5px;">';
                    return '<a href="' . route('networks.edit', [$row->id]) . '"> ' . $img . ' </a>';
                })
                ->addColumn('title', function ($row) {
                    return '<a href="' . route('networks.edit', [$row->id]) . '"> '  . $row->title . '</a>';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('deleted_at', function ($row) {
                    $deleted_at = '<span class="badge badge-success p-1"> เปิดการแสดงผล </span>';
                    if ($row->deleted_at == 1) {
                        $deleted_at = '<span class="badge badge-danger p-1"> ปิดการแสดงผล </span>';
                    }
                    return $deleted_at;
                })
                ->addColumn('bntManger', function ($row) {
                    $html = '<a href="' . route('networks.dropzone', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-primary mb-1"> <i class="fe-image"></i> </a>';
                    $html .= '<a href="' . route('networks.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary mb-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger mb-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['images', 'title', 'created_at', 'deleted_at', 'bntManger'])
                ->make(true);
        }
    }

    public function closenetworks(Request $request)
    {
        if (isset($request)) {
            $data = networks::find($request->id);
            $uploade_location = 'images/networks/';
            $uploade_location_pdf = 'images/networks/pdf/';

            $data_gallerys = DB::table('network_gallerys')->where('network_gallerys.network_id', $request->id)->get();
            if (isset($data_gallerys) && count($data_gallerys) > 0) {
                $uploade_location_gallery = 'images/networks/gallery/';
                foreach ($data_gallerys as $row) {
                    if (!empty($row->image_desktop)) {
                        @unlink($uploade_location_gallery . $row->image_desktop);
                    }
                }
            }

            if (!empty($data->file_pdf)) {
                @unlink($uploade_location_pdf . $data->file_pdf);
            }
            if (!empty($data->image_desktop)) {
                @unlink($uploade_location . $data->image_desktop);
            }

            if (!empty($data->file_text)) {
                @unlink(storage_path() . '/app/' . $data->file_text);
            }

            $data = DB::table('networks')
                ->where('networks.id', $request->id)
                ->delete();
            $data_gallerys = DB::table('network_gallerys')
                ->where('network_gallerys.network_id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function savenetworks(Request $request)
    {
        if (isset($request)) {
            $request->validate(
                [
                    'title' => ['required', 'string', 'max:255'],
                    'intro' => ['required', 'string', 'max:255'],
                    'file_text' => ['required'],

                    'file_upload_pdf' => ['mimes:pdf', 'max:50000'],
                    'file_upload_dektop' => 'image|mimes:jpeg,png,jpg|max:3072',
                ]
            );

            if ($request->statusData == "C") {
                $dataType = "created_at";
                $msg = "Save data successfully.";
                $file_name_decktop = NULL;
                $file_name_pdf = NULL;
                $file_text = "networks-" . hexdec(uniqid()) . ".text";
            } else if ($request->statusData == "U") {
                $dataType = "updated_at";
                $msg = "Update data successfully.";
                $file_name_decktop = $request->file_upload_dektop_hdf;
                $file_name_pdf = $request->file_upload_pdf_hdf;
                $file_text = $request->file_text_hdfs;
            }

            if (!empty($request->file_text)) {
                Storage::disk('local')->put($file_text, $request->file_text);
            }


            if ($request->file('file_upload_pdf')) {
                if (!empty($request->file('file_upload_pdf'))) {
                    $uploade_location_pdf = 'images/networks/pdf/';

                    if ($request->statusData == "U" && $file_name_pdf != "") {
                        @unlink($uploade_location_pdf . $file_name_pdf);
                    }

                    $file_pdf = $request->file('file_upload_pdf');
                    $file_gen_pdf = hexdec(uniqid());
                    $file_ext_pdf = strtolower($file_pdf->getClientOriginalExtension());
                    $file_name_pdf = $file_gen_pdf . '.' . $file_ext_pdf;
                    $file_pdf->move($uploade_location_pdf, $file_name_pdf);
                }
            }

            if ($request->file('file_upload_dektop')) {
                if (!empty($request->file('file_upload_dektop'))) {
                    $uploade_location_dektop = 'images/networks/';

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
                'title'  => $request->title,
                'intro'  => $request->intro,
                'file_text' => $file_text,

                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keyword'     => $request->meta_keyword,

                'image_desktop' => $file_name_decktop,
                'file_pdf' => $file_name_pdf,

                'date'  => new \DateTime(),
                'deleted_at' => $request->status,
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),
            );

            if ($request->statusData == "C") {
                DB::table('networks')->insert($data);
                return redirect()->route('networks.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('networks')
                    ->where('networks.id', $request->id)
                    ->update($data);
                return redirect()->route('networks.edit', [$request->id])->with('success', $msg);
            }
        }
    }

    public function closenetworksPdf(Request $request)
    {
        if (isset($request)) {
            $uploade_location_pdf = 'images/networks/pdf/';
            $data_pdf = array("file_pdf" => NULL);
            $data = DB::table('networks')
                ->where('networks.id', $request->id)
                ->update($data_pdf);
            if (!empty($request->file)) {
                @unlink($uploade_location_pdf . $request->file);
            }
        }
        return $data;
    }

    public function savenetworksDropzone(Request $request)
    { 
         if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_ext = strtolower($file->getClientOriginalExtension());

            // ตรวจสอบว่าเป็นรูปภาพ
            if (!in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                return response()->json(['error' => 'Invalid image format.'], 400);
            }

            $file_gen = hexdec(uniqid());
            $filename = 'rs-' . $file_gen . '.' . $file_ext;
            $destinationPath = public_path('images/networks/gallery/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // ย่อขนาดภาพให้ไม่เกิน 800px (กว้างหรือสูง) และบีบอัด
            $image = Image::make($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // ไม่ขยายภาพเล็ก
                })->save($destinationPath . $filename, 80); // ค่าความคมชัด (0–100)
            if (!empty($filename)) {
                $data = array(
                    'network_id'   => $request->id,
                    'image_desktop' => $filename,
                    'ip_address' => $request->ip(),
                    'created_at' => new \DateTime(),
                );
            }
            return DB::table('network_gallerys')->insert($data);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function closenetworksgallery(Request $request)
    {
        if (isset($request)) {
            $data = network_gallerys::find($request->id);
            $uploade_location = 'images/networks/gallery/';
            if (!empty($data->image_desktop)) {
                @unlink($uploade_location . $data->image_desktop);
            }

            $data = DB::table('network_gallerys')
                ->where('network_gallerys.id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function closeNetworksDropzoneAll(Request $request)
    {
        if (isset($request)) {
            $data = network_gallerys::where('network_id', $request->id)->get();
            $uploade_location = 'images/networks/gallery/';
            if (isset($data) && count($data)) {
                foreach ($data as $row) {
                    if (!empty($row->image_desktop)) {
                        @unlink($uploade_location . $row->image_desktop);
                    }
                }
            }
        }
        $data = DB::table('network_gallerys')->where('network_id', $request->id)->delete();
        return $data;
    }
}
