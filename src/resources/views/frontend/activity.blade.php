@extends('layouts.appfrontend')
@section('meta')
<meta name="title" content=" @if(isset($data['result_activitys']->activity_meta_title)) {{ $data['result_activitys']->activity_meta_title }} @endif">
<meta name="description" content="@if(isset($data['result_activitys']->activity_meta_description)) {{ $data['result_activitys']->activity_meta_description }} @endif">
<meta name="keywords" content="@if(isset($data['result_activitys']->activity_meta_keyword)) {{ $data['result_activitys']->activity_meta_keyword }} @endif">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('activity', [$data['get_id']]) }}">
<meta property="og:title" content=" @if(isset($data['result_activitys']->activity_meta_title)) {{ $data['result_activitys']->activity_meta_title }} @endif">
<meta property="og:description" content="@if(isset($data['result_activitys']->activity_meta_description)) {{ $data['result_activitys']->activity_meta_description }} @endif">
<meta property="og:keywords" content="@if(isset($data['result_activitys']->activity_meta_keyword)) {{ $data['result_activitys']->activity_meta_keyword }} @endif">
<meta property="og:image" content="@if(isset($data['result_activitys']->activity_image_desktop)) {{ asset('images/activity').'/'.$data['result_activitys']->activity_image_desktop }} @endif ">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ route('activity', [$data['get_id']]) }}">
<meta property="twitter:title" content=" @if(isset($data['result_activitys']->activity_meta_title)) {{ $data['result_activitys']->activity_meta_title }} @endif">
<meta property="twitter:description" content="@if(isset($data['result_activitys']->activity_meta_description)) {{ $data['result_activitys']->activity_meta_description }} @endif">
<meta property="twitter:keywords" content="@if(isset($data['result_activitys']->activity_meta_keywords)) {{ $data['result_activitys']->activity_meta_keywords }} @endif">
<meta property="twitter:image" content="@if(isset($data['result_activitys']->activity_image_desktop)) {{ asset('images/activity').'/'.$data['result_activitys']->activity_image_desktop }} @endif">
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
        <h2 class="h2">โครงการ/กิจกรรม</h2>
        <ul class="breadcrumb">
            <li><a href="#">หน้าหลัก</a></li>
            <li><span>โครงการ/กิจกรรม</span></li>
        </ul>
    </div>
</div>

<div class="pd--80-0-20">
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-12">
                <h1 class="responsive-h1"> {{ $data['result_activitys']->activity_title }} </h1>
            </div>
            <div class="col-md-4">
                <img class="rounded w-100 mb-1" src="<?php echo asset('images/activity/') . '/' . $data['result_activitys']->activity_image_desktop; ?>" width="100%">
            </div>
            <div class="col-md-8">
                <?php
                $w = date("w", strtotime($data['result_activitys']->activity_date));
                $m = date("m", strtotime($data['result_activitys']->activity_date));
                $d = date("d", strtotime($data['result_activitys']->activity_date));
                $Y = date("Y", strtotime($data['result_activitys']->activity_date));
                $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์");
                $ThMonth = array("มกรามก", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                $week = $w;
                $months = $m - 1;
                $day = $d;
                $years = $Y + 543;
                ?>
                <div class="mb-2">{{ $data['result_activitys']->activity_intro }}</div>
                <div class="text-muted mb-1"> <i class="fa fa-calendar"></i> ปีโครงการ {{ $activity_year ?? '-'; }} </div>
                <div class="text-muted mb-1">
                    <i class="fa fa-calendar"></i> {{ $ThDay[$week] . " " . $day . " " . $ThMonth[$months] . " " . $years; }}
                </div>
                <div class="text-muted mb-1"><i class="fa fa-eye"></i> จำนวนผู้เข้าชม {{ number_format($data['result_activitys']->count_view) }} คน </div>
                <div class="sharethis-inline-share-buttons mt-2"></div>
            </div>
        </div>
        <hr>
        <div class="row mb-2">

            <div class="col-md-12">
                @if(isset($data['result_activitys']->file_pdf))
                @if(!empty($data['result_activitys']->file_pdf))
                <div class="text-center mb-3 d-none d-sm-block">
                    <object data="{{ asset('images/activity/pdf').'/'.$data['result_activitys']->file_pdf }}" type="application/pdf" width="100%" height="700"> </object>
                </div>
                <div class="text-center mb-3 d-block d-sm-none show-node-pdf">
                    <div><b>เบราว์เซอร์นี้ไม่สนับสนุน PDF กรุณาดาวน์โหลดไฟล์ PDF เพื่อดู</b> </div>
                    <a class="btn mt-1" href="{{ asset('images/activity/pdf').'/'.$data['result_activitys']->file_pdf }}">Download PDF</a>
                </div>
                @endif
                @endif
            </div>
            <div class="col-md-12">
                <?php
                if (isset($data['result_activitys']->activity_file_text)) {
                    echo @file_get_contents(storage_path() . '/app/' . $data['result_activitys']->activity_file_text);
                }
                ?>
            </div>
            <div class="col-md-12">
 
                <div class="zoom-gallery mt-2">
                    <div class="row" style="display: flex; flex-wrap: wrap;">
                        @if(isset($data['gallerys']) && count($data['gallerys'])>0)
                        @foreach($data['gallerys'] as $row)
                        <div class="col-xs-6 col-sm-6 col-md-3 text-center">
                            <a href="{{ asset('images/activity/gallery').'/'.$row->image_desktop }}" data-source="{{ asset('images/activity/gallery').'/'.$row->image_desktop }}" title="" style="width:200px;height:200px;">
                                <img src="{{ asset('images/activity/gallery').'/'.$row->image_desktop }}" width="100%" class="rounded m-1" style="margin: 5px;">
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-md-12 text-center">
                <a href="{{ route('activitylist') }}" class="btn btn-default mt-2">ย้อนกลับ</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="top-title mb-2">
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">โครงการ/กิจกรรม อื่นๆ</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="owl-carousel owl-theme owl-other">
                    @if(isset($data['Query_activitys']) && count($data['Query_activitys'])>0)
                    @foreach($data['Query_activitys'] as $row)
                    <div class="item">
                        <a href="{{ route('activity', [$row->id]) }}">
                            <div class="card mb-2">
                                <div class="card-img" style="background-image: url(<?php echo asset('images/activity/') . '/' . $row->activity_image_desktop; ?>); "> </div>
                                <div class="card-body">
                                    <h4 class="m-0 white-space-1 font-size-12">{{ $row->activity_title }}</h4>
                                    <p class="card-text white-space-2 font-size-11">{{ $row->activity_intro }}</p>
                                    <div style="display: flex; justify-content: space-between;">
                                        <?php
                                        $w = date("w", strtotime($row->activity_date));
                                        $m = date("m", strtotime($row->activity_date));
                                        $d = date("d", strtotime($row->activity_date));
                                        $Y = date("Y", strtotime($row->activity_date));
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
<script> </script>
@endsection