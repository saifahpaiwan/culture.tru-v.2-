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

</style>
<link rel="stylesheet" href="{{ asset('template-front/css/owl.carousel.min.css') }}">
@endsection
@section('content')

<!-- ******Pop Up****** -->
@if(isset($data['Query_popups']) && count($data['Query_popups'])>0)
<div id="pu-overlay"></div>
<div id="pu-popup" style="background-color: unset;">
    <div class="card" style="background-color: unset;">

        <div class="owl-carousel owl-popups mb-2">
            @foreach($data['Query_popups'] as $row)
            <div>
                <div class="pu-popupcontent" style="background-image: url(<?php echo asset('images/popups') . '/' . $row->image_desktop; ?>); border-top-left-radius: 1rem; border-top-right-radius: 1rem;"> </div>
                <div class="card-body" style="background-color: #FFF; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                    @if(!empty($row->title))
                    <h5 class="m-0">{{ $row->title }}</h5>
                    @endif
                    @if(!empty($row->description))
                    <p class="card-text">{{ $row->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <button type="button" id="pu-popupclose" style="border-radius: 25px;  padding: 10px 15px;"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
@endif

<!-- ******Pop Up****** -->

<!-- ******BANNER****** -->
<div class="banner--section">
    <div class="banner--slider owl-carousel" data-owl-nav="true" data-owl-dots="true" data-owl-drag="false" data-owl-animate-in="fadeIn" data-owl-animate-out="fadeOut" data-owl-interval="8000">
        @if(isset($data['Query_slideshow']))
        @if(count($data['Query_slideshow'])>0)
        @foreach($data['Query_slideshow'] as $row)
        <div class="banner--item @if(!empty($row->title) || !empty($row->description)) bg--overlay @endif" data-bg-img="{{ asset('images/slideshow').'/'.$row->image_desktop }}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vc--parent">
                            <div class="vc--child-middle">
                                <div class="banner--content pd--100-0">
                                    @if(!empty($row->title))
                                    <div class="title animated fadeInDown">
                                        <h2 class="h1 white-space-1">{{ $row->title }}</h2>
                                    </div>
                                    @endif
                                    @if(!empty($row->description))
                                    <div class="animated fadeIn">
                                        <p class="white-space-2">{{ $row->description }}</p>
                                    </div>
                                    @endif
                                    @if(!empty($row->link) && !empty($row->title))
                                    <div class="buttons animated fadeInUp">
                                        <a href="{{ $row->link }}" class="btn btn-default">อ่านเพิ่มเติม</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        @endif
    </div>
</div>
<!-- ******BANNER****** -->

<!-- ******ACTIVITY&JOURNAL****** -->
<div class="pd--80-0-20">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="top-title">
                    <a href="{{ route('learningslist') }}">
                        <div class="sec-title">
                            <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                            <span style="color: #FFF;">สำนักศิลปะและวัฒนธรรม</span>
                            <div class="h3">แหล่งเรียนรู้ 3 บุรี</div>
                        </div>
                    </a>
                    <div> <a href="{{ route('learningslist') }}"> <span>ดูทั้งหมด</span> </a> </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme owl-activity">
                            @if(isset($data['Query_learning']) && count($data['Query_learning'])>0)
                            @foreach($data['Query_learning'] as $row)
                            <a href="{{ route('learnings', [$row->id]) }}">
                                <div class="card mb-2">
                                    <div class="card-img height-b-150" style="background-image: url(<?php echo asset('images/learning/') . '/' . $row->image_desktop; ?>);"> </div>
                                    <div class="card-body" style="min-height: 116.67px;">
                                        <h4 class="m-0 white-space-1 font-size-12">{{ $row->title }}</h4>
                                        <p class="card-text white-space-2 font-size-11">แหล่งเรียนรู้ {{ $row->rLearningTypes->name ?? '-' }}</p>
                                        <div>
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
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            @endif
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="top-title">
                    <a href="{{ route('activitylist') }}">
                        <div class="sec-title">
                            <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                            <span style="color: #FFF;">สำนักศิลปะและวัฒนธรรม</span>
                            <div class="h3">โครงการ/กิจกรรม</div>
                        </div>
                    </a>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">

                        <div class="owl-carousel owl-theme owl-journal">
                            @if(isset($data['Query_activity']) && count($data['Query_activity'])>0)
                            @foreach($data['Query_activity'] as $row)
                            <a href="{{ route('activity', [$row->id]) }}">
                                <div class="card mb-2">
                                    <div class="card-img height-b-150" style="background-image: url(<?php echo asset('images/activity/') . '/' . $row->activity_image_desktop; ?>);"> </div>
                                    <div class="card-body">
                                        <h4 class="m-0 white-space-1 font-size-12">{{ $row->activity_title }}</h4>
                                        <p class="card-text white-space-2 font-size-11">{{ $row->activity_intro }}</p>
                                        <div>
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
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ******ACTIVITY&JOURNAL****** -->

<!-- ******Dashboard****** -->
<div style="padding: 50px 0; background: #eadef0;">
    <div class="container">
        <div class="dashboard-box-center">
            <div class="dashboard-box">
                <div class="dashboard-content">
                    <img src="/images/books-stack-of-three.png" class="mb-2 filter-purple" width="40">
                    <div class="h4 mb-1" style="color: #56174c;"> <?php echo number_format($data['books']); ?> <b>+</b> </div>
                    <div style="color: #56174c;">แหล่งเรียนรู้</div>
                </div>
                <div class="dashboard-content">
                    <img src="/images/journal.png" class="mb-2 filter-purple" width="40">
                    <div class="h4 mb-1" style="color: #56174c;"> <?php echo number_format($data['journal']); ?> <b class="b-12">+</b></div>
                    <div style="color: #56174c;">หนังสือและวารสารสำนักฯ</div>
                </div>
                <div class="dashboard-content">
                    <img src="/images/research.png" class="mb-2 filter-purple" width="40">
                    <div class="h4 mb-1" style="color: #56174c;"> <?php echo number_format($data['research']); ?> <b class="b-12">+</b></div>
                    <div style="color: #56174c;">งานวิจัยและบทความ</div>
                </div>
                <div class="dashboard-content">
                    <img src="/images/project-management.png" class="mb-2 filter-purple" width="40">
                    <div class="h4 mb-1" style="color: #56174c;"> <?php echo number_format($data['project']); ?> <b class="b-12">+</b></div>
                    <div style="color: #56174c;">โครงการกิจกรรม</div>
                </div>
                <div class="dashboard-content" style="border: 0;">
                    <img src="/images/star.png" class="mb-2 filter-purple" width="40">
                    <div class="h4 mb-1" style="color: #56174c;"> <?php echo number_format($data['star']); ?> <b class="b-12">+</b></div>
                    <div style="color: #56174c;">ความพึงพอใจต่อบริการ</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ******Dashboard****** -->

<!-- ******BOOK****** -->
<div class="pd--80-0-50">
    <div class="container">
        <div class="section--title">
            <h2 class="h2 fa fa-book"> หนังสือและวารสารสำนักฯ </h2>
        </div>
        <div class="row">
            @if(isset($data['Query_books']) && count($data['Query_books'])>0)
            @foreach($data['Query_books'] as $row)
            <div class="col-xs-6 col-md-3">
                <div class="service--item book-img" style="background-image: url(<?php echo asset('images/book/') . '/' . $row->image_desktop; ?>);">
                    <div class="flipped">
                        <div class="title">
                            <h3 class="h3 white-space-1">หนังสือและวารสาร</h3>
                        </div>
                        <div class="content">
                            <p class="white-space-1"> {{ $row->title }} </p>
                            <p class="white-space-1"> ชื่อผู้แต่ง : {{ $row->author }} </p>
                            <p class="white-space-1">ปีที่พิมพ์ : {{ $row->year }}</p>
                            <p class="white-space-1">ประเภท : {{ $row->type }}</p>
                            <p class="white-space-1">จัดพิมพ์โดย : {{ $row->published }}</p>
                            <p class="white-space-1">คำสำคัญ : {{ $row->keyword }}</p>
                        </div>
                        <div class="action">
                            <a href="{{ route('books', [$row->id]) }}" class="btn btn-default">อ่านเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-md-12 text-center"> --- ไม่มีข้อมูล --- </div>
            @endif
        </div>
        <div class="text-center">
            <a href="{{ route('bookslist') }}" class="btn btn-default"> ดูทั้งหมด </a>
        </div>
    </div>
</div>
<!-- ******BOOK****** -->

<!-- ******RESEARCH****** -->
<div class="pd--80-0-50 bg--color-lightgray">
    <div class="container">
        <div class="section--title">
            <h2 class="h2 fa fa-book"> งานวิจัยและบทความ </h2>
        </div>
        <div class="row">
            @if(isset($data['Query_research']) && count($data['Query_research'])>0)
            @foreach($data['Query_research'] as $row)
            <div class="col-xs-6 col-md-3">
                <div class="service--item book-img" style="background-image: url(<?php echo asset('images/research/') . '/' . $row->image_desktop; ?>);">
                    <div class="flipped">
                        <div class="title">
                            <h3 class="h3 white-space-1">งานวิจัยและบทความ</h3>
                        </div>
                        <div class="content">
                            <p class="white-space-1"> {{ $row->title }} </p>
                            <p class="white-space-1"> ชื่อผู้แต่ง : {{ $row->author }} </p>
                            <p class="white-space-1">ปีที่แต่ง : {{ $row->year }}</p>
                            <p class="white-space-1">ประเภท : {{ $row->type }}</p>
                            <p class="white-space-1">จัดพิมพ์โดย : {{ $row->published }}</p>
                            <p class="white-space-1">คำสำคัญ : {{ $row->keyword }}</p>
                        </div>
                        <div class="action">
                            <a href="{{ route('researchs', [$row->id]) }}" class="btn btn-default">อ่านเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-md-12 text-center"> --- ไม่มีข้อมูล --- </div>
            @endif
        </div>
        <div class="text-center">
            <a href="{{ route('researchslist') }}" class="btn btn-default"> ดูทั้งหมด </a>
        </div>
    </div>
</div>
<!-- ******RESEARCH****** -->


<!-- ******NEWS&FB****** -->
<div class="pd--80-0-20">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="top-title">
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">ข่าวประชาสัมพันธ์</div>
                    </div>
                    <div> <a href="{{ route('newslist') }}"> <span>ดูทั้งหมด</span> </a> </div>
                </div>
                <div class="row mt-2">
                    @if(isset($data['Query_news']) && count($data['Query_news'])>0)
                    @foreach($data['Query_news'] as $row)
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
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="row">
                                <div class="col-xs-4 col-md-3">
                                    <div class="box-news-img" style="background-image: url(<?php echo asset('images/news') . '/' . $row->news_image_desktop; ?>);"> </div>
                                </div>
                                <div class="col-xs-8 col-md-9 d-flex-column">
                                    <div style="padding: 5px;">
                                        <div>
                                            <h4 class="h4 m-0 white-space-1"> {{ $row->news_title }} </h4>
                                            <p class="white-space-2"> {{ $row->news_intro }} </p>
                                        </div>
                                        <div class="row" style="display: flex; align-items: flex-end;">
                                            <div class="col-md-6">
                                                <span class="font-size-11 me-2"><i class="fa fa-calendar"></i> <?php echo $ThDay[$week] . " " . $day . " " . $ThMonth[$months] . " " . $years; ?></span>
                                                <span class="font-size-11 me-2"><i class="fa fa-eye"></i> จำนวนผู้เข้าชม {{ number_format($row->count_view) }} คน</span>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <a href="{{ route('news', [$row->id]) }}" class="btn btn-default font-size-12">อ่านเพิ่มเติม</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-md-12">
                        <div class="col-md-12 text-center"> --- ไม่มีข้อมูล --- </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="fb-page" data-href="https://web.facebook.com/artcultureTRU99/?_rdc=1&amp;_rdr" data-tabs="timeline" data-width="400" data-height="700" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://web.facebook.com/artcultureTRU99/?_rdc=1&amp;_rdr" class="fb-xfbml-parse-ignore">
                        <a href="https://web.facebook.com/artcultureTRU99/?_rdc=1&amp;_rdr">สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ******NEWS&FB****** -->

<!-- ******VDO&CALENDAR****** -->
<div class="pd--80-0 bg--color-lightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="mb-2">
                    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FBangkok&title=%E0%B8%9B%E0%B8%8F%E0%B8%B4%E0%B8%97%E0%B8%B4%E0%B8%99%E0%B8%81%E0%B8%B4%E0%B8%88%E0%B8%81%E0%B8%A3%E0%B8%A3%E0%B8%A1%20%E0%B8%AA%E0%B8%B3%E0%B8%99%E0%B8%B1%E0%B8%81%E0%B8%A8%E0%B8%B4%E0%B8%A5%E0%B8%9B%E0%B8%B0%E0%B9%81%E0%B8%A5%E0%B8%B0%E0%B8%A7%E0%B8%B1%E0%B8%92%E0%B8%99%E0%B8%98%E0%B8%A3%E0%B8%A3%E0%B8%A1%20%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B8%A3%E0%B8%B2%E0%B8%8A%E0%B8%A0%E0%B8%B1%E0%B8%8F%E0%B9%80%E0%B8%97%E0%B8%9E%E0%B8%AA%E0%B8%95%E0%B8%A3%E0%B8%B5&src=dGhlcHNhdHJpY3VsdHVyZUBsYXdhc3JpLnRydS5hYy50aA&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%2333B679" style="border:solid 1px #777" width="100%" height="420" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
            <div class="col-md-5">
                <div class="title">
                    <div class="h2 text-center"> ผลงานผ่านเลนส์ </div>
                </div>
                <div class="">
                    @if(isset($data['videoYoutube']->link) && !empty($data['videoYoutube']->link))
                    <div class="col-md-12 text-center">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ (isset(explode('?v=', $data['videoYoutube']->link)[1]))? explode('?v=', $data['videoYoutube']->link)[1] : '' }}?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ******VDO&CALENDAR****** -->

<!-- ******FOOTERINDEX****** -->
<div class="pd--80-0-50" data-bg-parallax="{{ asset('images/bg_footer.jpg') }}">
    <div class="container">
        <div class="row" style="display: flex; justify-content: center;">
            <div class="col-md-5 col-xs-6 col-xxs-12">
                <a href="{{ route('appeals') }}" style="color: #FFF;">
                    <div class="counter--item">
                        <div class="icon">
                            <i class="fa fa-gavel"></i>
                        </div>
                        <div class="number h1">
                            <p> </p>
                        </div>
                        <div class="title">
                            <h2 class="h4"> ช่องทางรับฟังความคิดเห็น ข้อเสนอแนะ และการร้องเรียน </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-xs-6 col-xxs-12">
                <a href="{{ url('page/16') }}" style="color: #FFF;">
                    <div class="counter--item">
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <div class="number h1">
                            <p> </p>
                        </div>
                        <div class="title">
                            <h2 class="h4"> คู่มือประชาชน </h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- ******FOOTERINDEX****** -->
@endsection
@section('script')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v13.0" nonce="JRKdkS0F"></script>

<script src="{{ asset('template-front/js/owl.carousel.min.js') }}"></script>
<script>
    $(".owl-popups").owlCarousel({
        items: 1
    });
    $('.owl-activity').owlCarousel({
        autoplay: true,
        autoplayTimeout: 7000,
        margin: 10,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    $('.owl-journal').owlCarousel({
        autoplay: true,
        autoplayTimeout: 7000,
        margin: 10,
        loop: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 2
            },
            1000: {
                items: 1
            }
        }
    });

    var closePopup = document.getElementById("pu-popupclose");
    var overlay = document.getElementById("pu-overlay");
    var popup = document.getElementById("pu-popup");

    if (closePopup) {
        closePopup.onclick = function() {
            overlay.style.display = 'none';
            popup.style.display = 'none';
        };
    }
</script>
@endsection