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

@endsection
@section('content') 
<div class="page-header--section pd--80-0 text-center bg--overlay" data-bg-img="{{ asset('images/bg_detail.jpg') }}">
    <div class="container">
        <h2 class="h2">งานประกันคุณภาพ</h2>
        <ul class="breadcrumb">
            <li><a href="#">หน้าหลัก</a></li>
            <li><span>งานประกันคุณภาพ</span></li>
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
                        <div class="h3">รายการงานประกันคุณภาพ</div>
                    </div>
                    <div>   
                         <form class="header--search navbar-form" action="{{ route('qualitieslist') }}" method="GET">
                           <div style="display: flex;">
                                <input type="search" name="search" placeholder="ค้นหาเพิ่มเติม..." class="form-control m-0" value="{{ $data['search'] ?? '' }}" style="margin: 0 1px;">
                                <input type="month" name="month" placeholder="ค้นหาปีเดือนประกันคุณภาพ" class="form-control m-0" value="{{ $data['month'] ?? '' }}" style="margin: 0 1px;">
                           </div>
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"> 
            @if(isset($data['Query_qualities']) && count($data['Query_qualities'])>0)
            @foreach($data['Query_qualities'] as $row)
            <div class="col-xs-6 col-sm-4 col-md-3"> 
                <div class="service--item book-img" style="background-image: url(<?php echo asset('images/qualitie/') . '/' . $row->image_desktop; ?>);">
                    <div class="flipped">
                        <div class="title">
                            <h3 class="h3 white-space-1">งานประกันคุณภาพ</h3>
                        </div>
                        <div class="content">
                            <p>{{ $row->title }}</p>  
                        </div>
                        <div class="action">
                            <a href="{{ route('qualities', [$row->id]) }}" class="btn btn-default">อ่านเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
              <div class="col-md-12">
                <div style="float: inline-end;">{!! $data['Query_qualities']->links() !!}</div>
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