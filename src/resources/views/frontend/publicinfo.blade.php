@extends('layouts.appfrontend')
@section('meta')
<meta name="title" content=" @if(isset($data['result_publicinfo']->meta_title)) {{ $data['result_publicinfo']->meta_title }} @endif">
<meta name="description" content="@if(isset($data['result_publicinfo']->meta_description)) {{ $data['result_publicinfo']->meta_description }} @endif">
<meta name="keywords" content="@if(isset($data['result_publicinfo']->meta_keyword)) {{ $data['result_publicinfo']->meta_keyword }} @endif">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('publicinfo', [$data['get_id']]) }}">
<meta property="og:title" content=" @if(isset($data['result_publicinfo']->meta_title)) {{ $data['result_publicinfo']->meta_title }} @endif">
<meta property="og:description" content="@if(isset($data['result_publicinfo']->meta_description)) {{ $data['result_publicinfo']->meta_description }} @endif">
<meta property="og:keywords" content="@if(isset($data['result_publicinfo']->meta_keyword)) {{ $data['result_publicinfo']->meta_keyword }} @endif">
<meta property="og:image" content="@if(isset($data['result_publicinfo']->image_desktop)) {{ asset('images/publicinfo').'/'.$data['result_publicinfo']->image_desktop }} @endif ">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ route('publicinfo', [$data['get_id']]) }}">
<meta property="twitter:title" content=" @if(isset($data['result_publicinfo']->meta_title)) {{ $data['result_publicinfo']->meta_title }} @endif">
<meta property="twitter:description" content="@if(isset($data['result_publicinfo']->meta_description)) {{ $data['result_publicinfo']->meta_description }} @endif">
<meta property="twitter:keywords" content="@if(isset($data['result_publicinfo']->meta_keywords)) {{ $data['result_publicinfo']->meta_keywords }} @endif">
<meta property="twitter:image" content="@if(isset($data['result_publicinfo']->image_desktop)) {{ asset('images/publicinfo').'/'.$data['result_publicinfo']->image_desktop }} @endif">
@endsection
@section('style')
<style>
    .show-node-pdf {
        border: 1px solid #fedba7;
        background: #fff2df;
        border-radius: 10px;
        padding: 0.5rem;
    }

    .box-img-gallery {
        width: 150px;
        height: 150px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin: 0 0.25rem;
    }

    #pdf-render {
        border: 1px solid #ccc;
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
    }
</style>
@endsection
@section('content')
<div class="page-header--section pd--80-0 text-center bg--overlay" data-bg-img="{{ asset('images/bg_detail.jpg') }}">
    <div class="container">
        <h2 class="h2">ข้อมูลสาธารณะ</h2>
        <ul class="breadcrumb">
            <li><a href="#">หน้าหลัก</a></li>
            <li><span>ข้อมูลสาธารณะ</span></li>
        </ul>
    </div>
</div>

<div class="pd--80-0-20">
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-12">
                <h1 class="responsive-h1"> {{ $data['result_publicinfo']->title }} </h1>
            </div>
            <div class="col-md-4">
                <img class="rounded w-100 mb-1" src="<?php echo asset('images/publicinfo/') . '/' . $data['result_publicinfo']->image_desktop; ?>" width="100%">
            </div>
            <div class="col-md-8">
                <?php
                $w = date("w", strtotime($data['result_publicinfo']->date));
                $m = date("m", strtotime($data['result_publicinfo']->date));
                $d = date("d", strtotime($data['result_publicinfo']->date));
                $Y = date("Y", strtotime($data['result_publicinfo']->date));
                $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์");
                $ThMonth = array("มกรามก", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                $week = $w;
                $months = $m - 1;
                $day = $d;
                $years = $Y + 543;
                ?>
                <div class="mb-2">{{ $data['result_publicinfo']->intro }}</div>
                <div class="text-muted mb-1">
                    <i class="fa fa-calendar"></i> {{ $ThDay[$week] . " " . $day . " " . $ThMonth[$months] . " " . $years; }}
                </div>
                <div class="text-muted mb-1"><i class="fa fa-eye"></i> จำนวนผู้เข้าชม {{ number_format($data['result_publicinfo']->count_view) }} คน </div>
                <div class="sharethis-inline-share-buttons mt-2"></div>
            </div>
        </div>
        <hr>
        <div class="row mb-2">

            <div class="col-md-12 text-center mb-3">
                @if(isset($data['result_publicinfo']->file_pdf))
                @if(!empty($data['result_publicinfo']->file_pdf))
                <!-- <div class="text-center mb-3 d-none d-sm-block">
                    <object data="{{ asset('images/publicinfo/pdf').'/'.$data['result_publicinfo']->file_pdf }}" type="application/pdf" width="100%" height="700"> </object>
                </div>
                <div class="text-center mb-3 d-block d-sm-none show-node-pdf">
                    <div><b>เบราว์เซอร์นี้ไม่สนับสนุน PDF กรุณาดาวน์โหลดไฟล์ PDF เพื่อดู</b> </div>
                    <a class="btn mt-1" href="{{ asset('images/publicinfo/pdf').'/'.$data['result_publicinfo']->file_pdf }}">Download PDF</a>
                </div> -->
                <div class="text-center mb-3" style="display: flex; justify-content: space-evenly; align-items: center;">
                    <button class="btn btn-dark" id="prev-page">Previous</button>
                    <span>Page: <span id="page-num">1</span> / <span id="page-count">?</span></span>
                    <button class="btn btn-dark" id="next-page">Next</button>
                </div>
                <canvas id="pdf-render"></canvas>
                @endif
                @endif
            </div>
            <div class="col-md-12">
                <?php
                if (isset($data['result_publicinfo']->file_text)) {
                    echo @file_get_contents(storage_path() . '/app/' . $data['result_publicinfo']->file_text);
                }
                ?>
            </div>
            <div class="col-md-12">

                <div class="zoom-gallery mt-2">
                    <div class="row" style="display: flex; flex-wrap: wrap;">
                        @if(isset($data['gallerys']) && count($data['gallerys'])>0)
                        @foreach($data['gallerys'] as $row)
                        <div class="col-xs-6 col-sm-6 col-md-3 text-center">
                            <a href="{{ asset('images/publicinfo/gallery').'/'.$row->image_desktop }}" data-source="{{ asset('images/publicinfo/gallery').'/'.$row->image_desktop }}" title="" style="width:200px;height:200px;">
                                <img src="{{ asset('images/publicinfo/gallery').'/'.$row->image_desktop }}" width="100%" class="rounded m-1" style="margin: 5px;">
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-md-12 text-center">
                <a href="{{ route('publicinfolist') }}" class="btn btn-default mt-2">ย้อนกลับ</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="top-title mb-2">
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">ข้อมูลสาธารณะ อื่นๆ</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="owl-carousel owl-theme owl-other">
                    @if(isset($data['Query_publicinfo']) && count($data['Query_publicinfo'])>0)
                    @foreach($data['Query_publicinfo'] as $row)
                    <div class="item">
                        <a href="{{ route('publicinfo', [$row->id]) }}">
                            <div class="card mb-2">
                                <div class="card-img" style="background-image: url(<?php echo asset('images/publicinfo/') . '/' . $row->image_desktop; ?>); "> </div>
                                <div class="card-body">
                                    <h4 class="m-0 white-space-1 font-size-12">{{ $row->title }}</h4>
                                    <p class="card-text white-space-2 font-size-11">{{ $row->intro }}</p>
                                    <div style="display: flex; justify-content: space-between;">
                                        <?php
                                        $w = date("w", strtotime($row->date));
                                        $m = date("m", strtotime($row->date));
                                        $d = date("d", strtotime($row->date));
                                        $Y = date("Y", strtotime($row->date));
                                        $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์");
                                        $ThMonth = array("มกรามก", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                                        $week = $w;
                                        $months = $m - 1;
                                        $day = $d;
                                        $years = $Y + 543;
                                        ?>
                                        <div class="font-size-11"><i class="fa fa-calendar"></i> <?php echo $ThDay[$week] . " " . $day . " " . $ThMonth[$months] . " " . $years; ?></div>
                                        <div class="font-size-11">ผู้เข้าชม {{ number_format($row->count_view) }} คน </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62335409b947cf001aac6740&product=inline-share-buttons" async="async"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
    const url = "{{ asset('images/publicinfo/pdf').'/'.$data['result_publicinfo']->file_pdf ?? '' }}"; // เปลี่ยนเป็นไฟล์ PDF ของคุณ

    if (url != '') {
        let pdfDoc = null,
            pageNum = 1,
            pageCount = 0,
            canvas = document.getElementById('pdf-render'),
            ctx = canvas.getContext('2d');

        const renderPage = num => {
            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({
                    scale: 1.5
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                page.render(renderContext);
            });

            document.getElementById('page-num').textContent = num;
        };

        const queueRenderPage = num => {
            if (num >= 1 && num <= pdfDoc.numPages) {
                pageNum = num;
                renderPage(pageNum);
            }
        };

        document.getElementById('prev-page').addEventListener('click', () => {
            if (pageNum <= 1) return;
            queueRenderPage(pageNum - 1);
        });

        document.getElementById('next-page').addEventListener('click', () => {
            if (pageNum >= pdfDoc.numPages) return;
            queueRenderPage(pageNum + 1);
        });

        // Load PDF
        pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            pageCount = pdfDoc.numPages;
            document.getElementById('page-count').textContent = pageCount;
            renderPage(pageNum);
        });
    }
</script>
@endsection