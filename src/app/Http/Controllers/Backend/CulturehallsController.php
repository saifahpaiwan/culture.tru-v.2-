<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\culturehalls;
use App\Models\culturehall_gallerys;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CulturehallsController extends Controller
{
    public function culturehallslist()
    {
        $data = array();
        return view('backend.culturehalls.list', compact('data'));
    }

    public function culturehallsadd()
    {
        $data = array();
        return view('backend.culturehalls.add', compact('data'));
    }

    public function culturehallsedit($get_id)
    {
        $data = array(
            "culturehalls_find" => culturehalls::find($get_id),
        );
        return view('backend.culturehalls.edit', compact('data'));
    }

    public function culturehallsdropzone($get_id)
    {
        $data = array(
            "culturehalls_find" => culturehalls::find($get_id),
            "gallerys"      => DB::table('culturehall_gallerys')->where('culturehall_id', $get_id)->get(),
            "get_id"        => $get_id,
        );
        return view('backend.culturehalls.dropzone', compact('data'));
    }


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {
        $keywrod_sql = "";
        $status_sql = "";
        $date_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and culturehalls.title LIKE '%" . $keywrod . "%'";
        }

        if (isset($status)) {
            $status_sql = " and culturehalls.deleted_at = " . $status . "";
        }

        if (isset($date)) {
            $date_sql = " and (culturehalls.created_at BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59')";
        }

        $data = DB::select('select * 
        from `culturehalls` 
        where culturehalls.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . ' ' . $date_sql . '
        order by culturehalls.id DESC');

        return $data;
    }

    public function datatableculturehalls(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status, $request->date);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('images', function ($row) {
                    $img = '<img src="' . asset('images/culturehalls') . '/' . $row->image_desktop . '" alt="contact-img" title="contact-img" class="mr-2" width="100%" style="border: 1px solid #ddd;border-radius: 5px;">';
                    return '<a href="' . route('culturehalls.edit', [$row->id]) . '"> ' . $img . ' </a>';
                })
                ->addColumn('title', function ($row) { 
                    return '<a href="' . route('culturehalls.edit', [$row->id]) . '"> '  . $row->title . '</a>';
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
                    $html = '<a href="' . route('culturehalls.dropzone', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-primary mb-1"> <i class="fe-image"></i> </a>';
                    $html .= '<a href="' . route('culturehalls.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary mb-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger mb-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['images', 'title', 'created_at', 'deleted_at', 'bntManger'])
                ->make(true);
        }
    }

    public function closeculturehalls(Request $request)
    {
        if (isset($request)) {
            $data = culturehalls::find($request->id);
            $uploade_location = 'images/culturehalls/';
            $uploade_location_pdf = 'images/culturehalls/pdf/';

            $data_gallerys = DB::table('culturehall_gallerys')->where('culturehall_gallerys.culturehall_id', $request->id)->get();
            if (isset($data_gallerys) && count($data_gallerys) > 0) {
                $uploade_location_gallery = 'images/culturehalls/gallery/';
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

            $data = DB::table('culturehalls')
                ->where('culturehalls.id', $request->id)
                ->delete();
            $data_gallerys = DB::table('culturehall_gallerys')
                ->where('culturehall_gallerys.culturehall_id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function saveculturehalls(Request $request)
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
                $file_text = "culturehalls-" . hexdec(uniqid()) . ".text";
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
                    $uploade_location_pdf = 'images/culturehalls/pdf/';

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
                    $uploade_location_dektop = 'images/culturehalls/';

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
                DB::table('culturehalls')->insert($data);
                return redirect()->route('culturehalls.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('culturehalls')
                    ->where('culturehalls.id', $request->id)
                    ->update($data);
                return redirect()->route('culturehalls.edit', [$request->id])->with('success', $msg);
            }
        }
    }

    public function closeculturehallsPdf(Request $request)
    {
        if (isset($request)) {
            $uploade_location_pdf = 'images/culturehalls/pdf/';
            $data_pdf = array("file_pdf" => NULL);
            $data = DB::table('culturehalls')
                ->where('culturehalls.id', $request->id)
                ->update($data_pdf);
            if (!empty($request->file)) {
               @unlink($uploade_location_pdf . $request->file);
            }
        }
        return $data;
    }

    public function saveculturehallsDropzone(Request $request)
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
            $destinationPath = public_path('images/culturehalls/gallery/');

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
                    'culturehall_id'   => $request->id,
                    'image_desktop' => $filename,
                    'ip_address' => $request->ip(),
                    'created_at' => new \DateTime(),
                );
            }
            return DB::table('culturehall_gallerys')->insert($data);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function closeculturehallsgallery(Request $request)
    {
        if (isset($request)) {
            $data = culturehall_gallerys::find($request->id);
            $uploade_location = 'images/culturehalls/gallery/';
            if (!empty($data->image_desktop)) {
               @unlink($uploade_location . $data->image_desktop);
            }

            $data = DB::table('culturehall_gallerys')
                ->where('culturehall_gallerys.id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function closeCulturehallsDropzoneAll(Request $request)
    {
        if (isset($request)) {
            $data = culturehall_gallerys::where('culturehall_id', $request->id)->get();
            $uploade_location = 'images/culturehalls/gallery/';
            if (isset($data) && count($data)) {
                foreach ($data as $row) {
                    if (!empty($row->image_desktop)) {
                        @unlink($uploade_location . $row->image_desktop);
                    }
                }
            }
        }
        $data = DB::table('culturehall_gallerys')->where('culturehall_id', $request->id)->delete();
        return $data;
    }
}
