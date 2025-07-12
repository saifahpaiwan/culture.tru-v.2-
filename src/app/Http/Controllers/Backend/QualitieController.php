<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\qualities;
use App\Models\qualitie_gallerys;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class QualitieController extends Controller
{
    public function qualitielist()
    {
        $data = array();
        return view('backend.qualitie.list', compact('data'));
    }

    public function qualitieadd()
    {
        $data = array();
        return view('backend.qualitie.add', compact('data'));
    }

    public function qualitieedit($get_id)
    {
        $data = array(
            "qualitie_find" => qualities::find($get_id),
        );
        return view('backend.qualitie.edit', compact('data'));
    }

    public function qualitiedropzone($get_id)
    {
        $data = array(
            "qualitie_find" => qualities::find($get_id),
            "gallerys"      => DB::table('qualitie_gallerys')->where('qualitie_id', $get_id)->get(),
            "get_id"        => $get_id,
        );
        return view('backend.qualitie.dropzone', compact('data'));
    }


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {
        $keywrod_sql = "";
        $status_sql = "";
        $date_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and qualities.title LIKE '%" . $keywrod . "%'";
        }

        if (isset($status)) {
            $status_sql = " and qualities.deleted_at = " . $status . "";
        }

        if (isset($date)) {
            $date_sql = " and (qualities.created_at BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59')";
        }

        $data = DB::select('select * 
        from `qualities` 
        where qualities.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . ' ' . $date_sql . '
        order by qualities.id DESC');

        return $data;
    }

    public function datatableQualities(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status, $request->date);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
               ->addColumn('images', function ($row) {
                    $img = '<img src="' . asset('images/qualitie') . '/' . $row->image_desktop . '" alt="contact-img" title="contact-img" class="mr-2" width="100%" style="border: 1px solid #ddd;border-radius: 5px;">';
                    return '<a href="' . route('qualitie.edit', [$row->id]) . '"> ' . $img . ' </a>';
                })
                ->addColumn('title', function ($row) { 
                    return '<a href="' . route('qualitie.edit', [$row->id]) . '"> ' .  $row->title . '</a>';
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
                    $html = '<a href="' . route('qualitie.dropzone', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-primary mb-1"> <i class="fe-image"></i> </a>';
                    $html .= '<a href="' . route('qualitie.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary mb-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger mb-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['images', 'title', 'created_at', 'deleted_at', 'bntManger'])
                ->make(true);
        }
    }

    public function closeQualities(Request $request)
    {
        if (isset($request)) {
            $data = qualities::find($request->id);
            $uploade_location = 'images/qualitie/';
            $uploade_location_pdf = 'images/qualitie/pdf/';

            $data_gallerys = DB::table('qualitie_gallerys')->where('qualitie_gallerys.qualitie_id', $request->id)->get();
            if (isset($data_gallerys) && count($data_gallerys) > 0) {
                $uploade_location_gallery = 'images/qualitie/gallery/';
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

            $data = DB::table('qualities')
                ->where('qualities.id', $request->id)
                ->delete();
            $data_gallerys = DB::table('qualitie_gallerys')
                ->where('qualitie_gallerys.qualitie_id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function saveQualities(Request $request)
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
                $file_text = "qualitie-" . hexdec(uniqid()) . ".text";
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
                    $uploade_location_pdf = 'images/qualitie/pdf/';

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
                    $uploade_location_dektop = 'images/qualitie/';

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
                'date'   => date('Y-m-d', strtotime($request->month)),
                'intro'  => $request->intro,
                'file_text' => $file_text,

                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keyword'     => $request->meta_keyword,

                'image_desktop' => $file_name_decktop,
                'file_pdf' => $file_name_pdf,
 
                'deleted_at' => $request->status,
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),
            );

            if ($request->statusData == "C") {
                DB::table('qualities')->insert($data);
                return redirect()->route('qualitie.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('qualities')
                    ->where('qualities.id', $request->id)
                    ->update($data);
                return redirect()->route('qualitie.edit', [$request->id])->with('success', $msg);
            }
        }
    }

    public function closeQualitiesPdf(Request $request)
    {
        if (isset($request)) {
            $uploade_location_pdf = 'images/qualitie/pdf/';
            $data_pdf = array("file_pdf" => NULL);
            $data = DB::table('qualities')
                ->where('qualities.id', $request->id)
                ->update($data_pdf);
            if (!empty($request->file)) {
               @unlink($uploade_location_pdf . $request->file);
            }
        }
        return $data;
    }

    public function saveQualitiesDropzone(Request $request)
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
            $destinationPath = public_path('images/qualitie/gallery/');

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
                    'qualitie_id'   => $request->id,
                    'image_desktop' => $filename,
                    'ip_address' => $request->ip(),
                    'created_at' => new \DateTime(),
                );
            }
            return DB::table('qualitie_gallerys')->insert($data);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function closequalitiegallery(Request $request)
    {
        if (isset($request)) {
            $data = qualitie_gallerys::find($request->id);
            $uploade_location = 'images/qualitie/gallery/';
            if (!empty($data->image_desktop)) {
               @unlink($uploade_location . $data->image_desktop);
            }

            $data = DB::table('qualitie_gallerys')
                ->where('qualitie_gallerys.id', $request->id)
                ->delete();
        }
        return $data;
    }

     public function closeQualitieDropzoneAll(Request $request)
    {
        if (isset($request)) {
            $data = qualitie_gallerys::where('qualitie_id', $request->id)->get();
            $uploade_location = 'images/qualitie/gallery/';
            if (isset($data) && count($data)) {
                foreach ($data as $row) {
                    if (!empty($row->image_desktop)) {
                        @unlink($uploade_location . $row->image_desktop);
                    }
                }
            }
        }
        $data = DB::table('qualitie_gallerys')->where('qualitie_id', $request->id)->delete();
        return $data;
    }
}
