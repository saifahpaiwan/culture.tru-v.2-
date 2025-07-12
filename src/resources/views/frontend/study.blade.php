@extends('layouts.appfrontend')
@section('meta')
<meta name="title" content=" @if(isset($data['result_study']->meta_title)) {{ $data['result_study']->meta_title }} @endif">
<meta name="description" content="@if(isset($data['result_study']->meta_description)) {{ $data['result_study']->meta_description }} @endif">
<meta name="keywords" content="@if(isset($data['result_study']->meta_keyword)) {{ $data['result_study']->meta_keyword }} @endif">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('study', [$data['get_id']]) }}">
<meta property="og:title" content=" @if(isset($data['result_study']->meta_title)) {{ $data['result_study']->meta_title }} @endif">
<meta property="og:description" content="@if(isset($data['result_study']->meta_description)) {{ $data['result_study']->meta_description }} @endif">
<meta property="og:keywords" content="@if(isset($data['result_study']->meta_keyword)) {{ $data['result_study']->meta_keyword }} @endif">
<meta property="og:image" content="@if(isset($data['result_study']->image_desktop)) {{ asset('images/studys').'/'.$data['result_study']->image_desktop }} @endif ">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ route('study', [$data['get_id']]) }}">
<meta property="twitter:title" content=" @if(isset($data['result_study']->meta_title)) {{ $data['result_study']->meta_title }} @endif">
<meta property="twitter:description" content="@if(isset($data['result_study']->meta_description)) {{ $data['result_study']->meta_description }} @endif">
<meta property="twitter:keywords" content="@if(isset($data['result_study']->meta_keywords)) {{ $data['result_study']->meta_keywords }} @endif">
<meta property="twitter:image" content="@if(isset($data['result_study']->image_desktop)) {{ asset('images/studys').'/'.$data['result_study']->image_desktop }} @endif">
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
</style>
@endsection
@section('content')
<div class="page-header--section pd--80-0 text-center bg--overlay" data-bg-img="{{ asset('images/bg_detail.jpg') }}">
    <div class="container">
        <h2 class="h2">หนังสือและวารสารสำนักฯ</h2>
        <ul class="breadcrumb">
            <li><a href="#">หน้าหลัก</a></li>
            <li><span>หนังสือและวารสารสำนักฯ</span></li>
        </ul>
    </div>
</div>

<div class="pd--80-0-20">
    <div class="container">
        <div class="row mb-2">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <img src="<?php echo asset('images/studys/') . '/' . $data['result_study']->image_desktop; ?>" alt="{{ $data['result_study']->title }}" width="100%" class="mb-2">
                <div>
                    <div class="sharethis-inline-share-buttons mb-2"></div>
                    
                    <?php
                    $w = date("w", strtotime($data['result_study']->date));
                    $m = date("m", strtotime($data['result_study']->date));
                    $d = date("d", strtotime($data['result_study']->date));
                    $Y = date("Y", strtotime($data['result_study']->date));
                    $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์");
                    $ThMonth = array("มกรามก", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                    $week = $w;
                    $months = $m - 1;
                    $day = $d;
                    $years = $Y + 543;
                    ?>
                    <div><b>วันที่ </b>{{ $ThDay[$week] . " " . $day . " " . $ThMonth[$months] . " " . $years; }}</div>
                    <div><b>จำนวนผู้เข้าชม</b> {{ number_format($data['result_study']->count_view) }} คน</div>
                </div>
            </div>
           <div class="col-xs-12 col-sm-6 col-md-8">
                <h2 class="m-0"> {{ $data['result_study']->title }} </h2>
                <div class="mt-2">{{ $data['result_study']->intro }}</div>
                  
                <div class="row mt-2"> 
                    <div class="col-md-6">
                        <a href="{{ route('studylist') }}" class="btn btn-default">ย้อนกลับ</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-2">

            <div class="col-md-12">
                @if(isset($data['result_study']->file_pdf))
                @if(!empty($data['result_study']->file_pdf))
                <div class="text-center mb-3 d-none d-sm-block">
                    <object data="{{ asset('images/studys/pdf').'/'.$data['result_study']->file_pdf }}" type="application/pdf" width="100%" height="700"> </object>
                </div>
                <div class="text-center mb-3 d-block d-sm-none show-node-pdf">
                    <div><b>เบราว์เซอร์นี้ไม่สนับสนุน PDF กรุณาดาวน์โหลดไฟล์ PDF เพื่อดู</b> </div>
                    <a class="btn mt-1" href="{{ asset('images/studys/pdf').'/'.$data['result_study']->file_pdf }}">Download PDF</a>
                </div>
                @endif
                @endif
            </div>
            <div class="col-md-12">
                <?php
                if (isset($data['result_study']->file_text)) {
                    echo @file_get_contents(storage_path() . '/app/' . $data['result_study']->file_text);
                }
                ?>
            </div>
            <div class="col-md-12">
                <div class="zoom-gallery text-center mt-2">
                    @if(isset($data['gallerys']) && count($data['gallerys'])>0)
                    @foreach($data['gallerys'] as $row)
                    <a href="{{ asset('images/studys/gallery').'/'.$row->image_desktop }}" data-source="{{ asset('images/studys/gallery').'/'.$row->image_desktop }}" title="" style="width:200px;height:200px;">
                        <img src="{{ asset('images/studys/gallery').'/'.$row->image_desktop }}" width="200" height="200">
                    </a>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-12 text-center">
                <a href="{{ route('studylist') }}" class="btn btn-default mt-2">ย้อนกลับ</a>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="top-title mb-2">
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">หนังสือและวารสารสำนักฯ อื่นๆ</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="owl-carousel owl-theme owl-other">
                    @if(isset($data['Query_study']) && count($data['Query_study'])>0)
                    @foreach($data['Query_study'] as $row)
                    <div class="item">
                        <div class="service--item book-img" style="background-image: url(<?php echo asset('images/studys/') . '/' . $row->image_desktop; ?>);">
                            <div class="flipped">
                                <div class="title">
                                    <h3 class="h3">หนังสือและวารสาร</h3>
                                </div>
                                <div class="content">
                                    <p class="white-space-2"> {{ $row->title }} </p> 
                                </div>
                                <div class="action">
                                    <a href="{{ route('study', [$row->id]) }}" class="btn btn-default">อ่านเพิ่มเติม</a>
                                </div>
                            </div>
                        </div>
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
<script>

</script>
@endsection