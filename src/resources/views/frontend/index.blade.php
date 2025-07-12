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
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">โครงการ/กิจกรรม</div>
                    </div>
                    <div> <a href="{{ route('activitylist') }}"> <span>ดูทั้งหมด</span> </a> </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme owl-activity">
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
                                            <div class="font-size-11"><i class="fa fa-eye"></i> จำนวนผู้เข้าชม {{ number_format($row->count_view) }} คน </div>
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
                    <div class="sec-title">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="25" height="25" style="margin-right: 10px;">
                        <span>สำนักศิลปะและวัฒนธรรม</span>
                        <div class="h3">จดหมายข่าวล่าสุด</div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">

                        <div class="owl-carousel owl-theme owl-journal">
                            @if(isset($data['Query_journal']) && count($data['Query_journal'])>0)
                            @foreach($data['Query_journal'] as $row)
                            <div class="item">
                                <div class="service--item book-img" style="background-image: url(<?php echo asset('images/journals/') . '/' . $row->image_desktop; ?>);">
                                    <div class="flipped">
                                        <div class="title">
                                            <h3 class="h3 white-space-1">จดหมายข่าว</h3>
                                        </div>
                                        <div class="content">
                                            <p class="white-space-1">{{ $row->title }}</p>
                                            <p class="white-space-1">ปีเดือนวารสาร : {{ date("M", strtotime($row->month)).', '.date("Y", strtotime($row->month)) }}</p>
                                        </div>
                                        <div class="action">
                                            <a href="{{ route('journals', [$row->id]) }}" class="btn btn-default">อ่านเพิ่มเติม</a>
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
    </div>
</div>
<!-- ******ACTIVITY&JOURNAL****** -->

<!-- ******TITLEDETAIL****** -->
<div data-bg-parallax="{{ $data['bg_detail'] }}">
    <div class="pd--80-0">
        <div class="container">
            <div class="section--title">
                <h2 class="h2 fa-building-o">สำนักศิลปะและวัฒนธรรม</h2>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <div class="subscribe--form text-center">
                        <p>
                            เป็นหน่วยงานสนับสนุนการผลิตบัณฑิต โดยจัดกิจกรรมทำนุบำรุงศิลปวัฒนธรรมให้แก่นักเรียน นักศึกษา บุคลากรของมหาวิทยาลัยฯ
                            และบุคคลทั่วไป อย่างต่อเนื่อง โดยมี การแบ่งการบริหารงานให้สอดคล้องกับภารกิจเป็น 4 งาน ได้แก่ งานธุรการ งานหอวัฒนธรรม
                            งานส่งเสริมและเผยแพร่ และงานศึกษาค้นคว้าวิจัย
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ******TITLEDETAIL****** -->

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
                        <div class="row mb-2">
                            <div class="col-xs-4 col-md-3">
                                <div class="box-news-img" style="background-image: url(<?php echo asset('images/news') . '/' . $row->news_image_desktop; ?>);"> </div>
                            </div>
                            <div class="col-xs-8 col-md-9 d-flex-column">
                                <div>
                                    <h4 class="h4 m-0 white-space-1"> {{ $row->news_title }} </h4>
                                    <p class="white-space-2"> {{ $row->news_intro }} </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="font-size-11"><i class="fa fa-calendar"></i> <?php echo $ThDay[$week] . " " . $day . " " . $ThMonth[$months] . " " . $years; ?></div>
                                        <div class="font-size-11"><i class="fa fa-eye"></i> จำนวนผู้เข้าชม {{ number_format($row->count_view) }} คน</div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('news', [$row->id]) }}" class="btn btn-default font-size-12">อ่านเพิ่มเติม</a>
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
                    <div class="h2"> ผลงานผ่านเลนส์ </div>
                </div>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/u13frD7rHaY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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