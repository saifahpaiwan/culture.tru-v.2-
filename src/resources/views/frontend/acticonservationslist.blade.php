@extends('layouts.appfrontend')
@section('meta')
<meta name="title" content="สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี">
<meta name="description" content="สำนักศิลปะและวัฒนธรรม เป็นหน่วยงานสนับสนุนการผลิตบัณฑิต โดยจัดกิจกรรมทำนุบำรุงศิลปวัฒนธรรมให้แก่นักเรียน นักศึกษา บุคลากรของมหาวิทยาลัยฯ และบุคคลทั่วไป อย่างต่อเนื่อง โดยมี การแบ่งการบริหารงานให้สอดคล้องกับภารกิจเป็น 4 งาน ได้แก่ งานธุรการ งานหอวัฒนธรรม งานส่งเสริมและเผยแพร่ และงานศึกษาค้นคว้าวิจัย">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('index') }}">
<meta property="og:title" content="สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี">
<meta property="og:description" content="สำนักศิลปะและวัฒนธรรม เป็นหน่วยงานสนับสนุนการผลิตบัณฑิต โดยจัดกิจกรรมทำนุบำรุงศิลปวัฒนธรรมให้แก่นักเรียน นักศึกษา บุคลากรของมหาวิทยาลัยฯ และบุคคลทั่วไป อย่างต่อเนื่อง โดยมี การแบ่งการบริหารงานให้สอดคล้องกับภารกิจเป็น 4 งาน ได้แก่ งานธุรการ งานหอวัฒนธรรม งานส่งเสริมและเผยแพร่ และงานศึกษาค้นคว้าวิจัย">
<meta property="og:image" content="{{ asset('images/logo.png') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ route('index') }}">
<meta property="twitter:title" content="สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี">
<meta property="twitter:description" content="สำนักศิลปะและวัฒนธรรม เป็นหน่วยงานสนับสนุนการผลิตบัณฑิต โดยจัดกิจกรรมทำนุบำรุงศิลปวัฒนธรรมให้แก่นักเรียน นักศึกษา บุคลากรของมหาวิทยาลัยฯ และบุคคลทั่วไป อย่างต่อเนื่อง โดยมี การแบ่งการบริหารงานให้สอดคล้องกับภารกิจเป็น 4 งาน ได้แก่ งานธุรการ งานหอวัฒนธรรม งานส่งเสริมและเผยแพร่ และงานศึกษาค้นคว้าวิจัย">
<meta property="twitter:image" content="{{ asset('images/logo.png') }}">
@endsection
@section('style')
<style>
    .header--search .form-control {
        border: 2px solid #662c81;
        color: #662c81;
    }

    .header--search button[type="submit"] {
        border: 2px solid #662c81;
        line-height: 18px;
    }

    .header--search {
        margin-top: 0;
        height: 50px;
    }
</style>
@endsection
@section('content')
<div class="page-header--section pd--80-0 text-center bg--overlay" data-bg-img="{{ asset('images/bg_detail.jpg') }}">
    <div class="container">
        <h2 class="h2">กิจกรรมหน่วยอนุรักษ์ฯ</h2>
        <ul class="breadcrumb">
            <li><a href="#">หน้าหลัก</a></li>
            <li><span>กิจกรรมหน่วยอนุรักษ์ฯ</span></li>
        </ul>
    </div>
</div>

<div class="pd--80-0-20">
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="top-title">
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">รายการกิจกรรมหน่วยอนุรักษ์ฯ</div>
                    </div>
                    <div>
                        <form class="header--search navbar-form" action="{{ route('acticonservationslist') }}" method="GET">
                           <div style="display: flex;">
                                <input type="search" name="search" placeholder="ค้นหาเพิ่มเติม..." class="form-control m-0" value="{{ $data['search'] ?? '' }}" style="margin: 0 1px;">
                                <input type="number" name="year" placeholder="ค้นหาตาม พศ. ปีกิจกรรมหน่วยอนุรักษ์ฯ" class="form-control m-0" value="{{ $data['year'] ?? '' }}" style="margin: 0 1px;">
                           </div>
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(isset($data['Query_acticonservations']) && count($data['Query_acticonservations'])>0)
            @foreach($data['Query_acticonservations'] as $row)
            <div class="col-md-4">
                <a href="{{ route('acticonservations', [$row->id]) }}">
                    <div class="card mb-2">
                        <div class="card-img" style="background-image: url(<?php echo asset('images/acticonservation/') . '/' . $row->image_desktop; ?>); "> </div>
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
            <div class="col-md-12">
                <div style="float: inline-end;">{!! $data['Query_acticonservations']->links() !!}</div>
            </div>
            @else
            <div class="col-md-12 text-center"> --- ไม่มีข้อมูล --- </div>
            @endif
        </div>
    </div>
</div>

@endsection
@section('script')
<script>

</script>
@endsection