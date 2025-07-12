<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\pages;
use App\Models\page_gallerys;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PageCortroller extends Controller
{
    public function pagelist()
    {
        $data = array();
        return view('backend.page.page_list', compact('data'));
    }

    public function pageadd()
    {
        $data = array();
        return view('backend.page.page_add', compact('data'));
    }

    public function pageedit($get_id)
    {
        $data = array(
            "page_find" => pages::find($get_id),
        );
        return view('backend.page.page_edit', compact('data'));
    }

    public function pagedropzone($get_id)
    {
        $data = array(
            "page_find" => pages::find($get_id),
            "gallerys"      => DB::table('page_gallerys')->where('page_id', $get_id)->get(),
            "get_id" => $get_id,
        );
        return view('backend.page.page_dropzone', compact('data'));
    }


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {
        $keywrod_sql = "";
        $status_sql = "";
        $date_sql = "";
        if (isset($keywrod)) {
            $keywrod_sql = " and pages.page_title LIKE '%" . $keywrod . "%'";
        }

        if (isset($status)) {
            $status_sql = " and pages.deleted_at = " . $status . "";
        }

        if (isset($date)) {
            $date_sql = " and (pages.created_at BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59')";
        }

        $data = DB::select('select * 
        from `pages` 
        where pages.id != "" 
        ' . $keywrod_sql . ' ' . $status_sql . ' ' . $date_sql . '
        order by pages.id DESC');

        return $data;
    }

    public function datatablePage(Request $request)
    {
        if ($request->ajax()) {
            // ===================QUERY-DATATABLE======================= //
            $data = $this->Query_Datatable($request->keywrod, $request->status, $request->date);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {
                    return '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-dark ml-1 clipboard" data-url="' . route('page', [$row->id]) . '"> URL <i class="fe-link-2"></i> </button>';
                })
                ->addColumn('page_title', function ($row) {
                    return '<a href="' . route('page.edit', [$row->id]) . '"> ' . $row->page_title . '</a>';
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
                    $html  = '<a href="' . route('page.dropzone', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-primary ml-1"> <i class="fe-image"></i> </a>';
                    $html .= '<a href="' . route('page.edit', [$row->id]) . '" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                    $html .= '<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="' . $row->id . '"> <i class="mdi mdi-delete"></i> </button>';
                    return $html;
                })
                ->rawColumns(['id', 'page_title', 'created_at', 'deleted_at', 'bntManger'])
                ->make(true);
        }
    }

    public function closePage(Request $request)
    {
        if (isset($request)) {
            if ($request->id != 16 && $request->id != 17) {
                $data = pages::find($request->id);
                $uploade_location = 'images/page/';
                $uploade_location_pdf = 'images/page/pdf/';

                $data_gallerys = DB::table('page_gallerys')->where('page_gallerys.page_id', $request->id)->get();
                if (isset($data_gallerys) && count($data_gallerys) > 0) {
                    $uploade_location_gallery = 'images/page/gallery/';
                    foreach ($data_gallerys as $row) {
                        if (!empty($row->image_desktop)) {
                            @unlink($uploade_location_gallery . $row->image_desktop);
                        }
                    }
                }

                if (!empty($data->file_pdf)) {
                    @unlink($uploade_location_pdf . $data->file_pdf);
                }
                if (!empty($data->page_image_desktop)) {
                    @unlink($uploade_location . $data->page_image_desktop);
                }

                if (!empty($data->page_file_text)) {
                    @unlink(storage_path() . '/app/' . $data->page_file_text);
                }

                $data = DB::table('pages')
                    ->where('pages.id', $request->id)
                    ->delete();

                $data_gallerys = DB::table('page_gallerys')
                    ->where('page_gallerys.page_id', $request->id)
                    ->delete();
            }
        }
        return $data;
    }

    public function savePage(Request $request)
    {
        if (isset($request)) {
            $request->validate(
                [
                    'page_title' => ['required', 'string', 'max:255'],
                    'page_intro' => ['max:255'],
                    'page_file_text' => ['required'],

                    'page_meta_title' => ['max:255'],
                    'page_meta_description' => ['max:255'],
                    'page_meta_keyword' => ['max:255'],

                    'file_upload_pdf' => ['mimes:pdf', 'max:80000'],
                ]
            );

            if ($request->statusData == "C") {
                $dataType = "created_at";
                $msg = "Save data successfully.";
                $file_name_decktop = NULL;
                $file_name_pdf = NULL;
                $file_text = "page-" . hexdec(uniqid()) . ".text";
            } else if ($request->statusData == "U") {
                $dataType = "updated_at";
                $msg = "Update data successfully.";
                $file_name_decktop = $request->file_upload_dektop_hdf;
                $file_name_pdf = $request->file_upload_pdf_hdf;
                $file_text = $request->page_file_text_hdfs;
            }

            if (!empty($request->page_file_text)) {
                Storage::disk('local')->put($file_text, $request->page_file_text);
            }


            if ($request->file('file_upload_pdf')) {
                if (!empty($request->file('file_upload_pdf'))) {
                    $uploade_location_pdf = 'images/page/pdf/';

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



            $data = array(
                'page_title'  => $request->page_title,
                'page_intro'  => $request->page_intro,
                'page_file_text' => $file_text,

                'page_meta_title'       => $request->page_meta_title,
                'page_meta_description' => $request->page_meta_description,
                'page_meta_keyword'     => $request->page_meta_keyword,

                'file_pdf' => $file_name_pdf,

                'page_date'  => new \DateTime(),
                'deleted_at' => $request->status,
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),
            );

            if ($request->statusData == "C") {
                DB::table('pages')->insert($data);
                return redirect()->route('page.add')->with('success', $msg);
            } else if ($request->statusData == "U") {
                DB::table('pages')
                    ->where('pages.id', $request->id)
                    ->update($data);
                return redirect()->route('page.edit', [$request->id])->with('success', $msg);
            }
        }
    }

    public function closePagePdf(Request $request)
    {
        if (isset($request)) {
            $uploade_location_pdf = 'images/page/pdf/';
            $data_pdf = array("file_pdf" => NULL);
            $data = DB::table('pages')
                ->where('pages.id', $request->id)
                ->update($data_pdf);
            if (!empty($request->file)) {
                @unlink($uploade_location_pdf . $request->file);
            }
        }
        return $data;
    }

    public function savePageDropzone(Request $request)
    {
        // $file_name = null;
        // if ($request->file('file')) {
        //     if (!empty($request->file('file'))) {
        //         $uploade_location = 'images/page/gallery/';
        //         $file_dektop = $request->file('file');
        //         $file_gen_dektop = hexdec(uniqid());
        //         $file_ext_dektop = strtolower($file_dektop->getClientOriginalExtension());
        //         $file_name = $file_gen_dektop . '.' . $file_ext_dektop;
        //         $file_dektop->move($uploade_location, $file_name);
        //     }
        // }
        // if (!empty($file_name)) {
        //     $data = array(
        //         'page_id'   => $request->id,
        //         'image_desktop' => $file_name,
        //         'ip_address' => $request->ip(),
        //         'created_at' => new \DateTime(),
        //     );
        //     return DB::table('page_gallerys')->insert($data);
        // }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_ext = strtolower($file->getClientOriginalExtension());

            // ตรวจสอบว่าเป็นรูปภาพ
            if (!in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                return response()->json(['error' => 'Invalid image format.'], 400);
            }

            $file_gen = hexdec(uniqid());
            $filename = 'rs-' . $file_gen . '.' . $file_ext;
            $destinationPath = public_path('images/page/gallery/');

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
                    'page_id'   => $request->id,
                    'image_desktop' => $filename,
                    'ip_address' => $request->ip(),
                    'created_at' => new \DateTime(),
                );
            }
            return DB::table('page_gallerys')->insert($data);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function closepagegallery(Request $request)
    {
        if (isset($request)) {
            $data = page_gallerys::find($request->id);
            $uploade_location = 'images/page/gallery/';
            if (!empty($data->image_desktop)) {
                @unlink($uploade_location . $data->image_desktop);
            }
            $data = DB::table('page_gallerys')
                ->where('page_gallerys.id', $request->id)
                ->delete();
        }
        return $data;
    }

    public function ckeditorupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->query('amp;path');
            $uploade_location = 'images/' . $path . '/upload_link/';
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo(hexdec(uniqid()), PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '.' . $extension;
            $request->file('upload')->move($uploade_location, $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = $uploade_location . $fileName;
            $url = asset('images/' . $path . '/upload_link/' . $fileName);
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
            return $response;
        }
    }

    public function closePageDropzoneAll(Request $request)
    {
        if (isset($request)) {
            $data = page_gallerys::where('page_id', $request->id)->get();
            $uploade_location = 'images/page/gallery/';
            if (isset($data) && count($data)) {
                foreach ($data as $row) {
                    if (!empty($row->image_desktop)) {
                        @unlink($uploade_location . $row->image_desktop);
                    }
                }
            }
        }
        $data = DB::table('page_gallerys')->where('page_id', $request->id)->delete();
        return $data;
    }
}
