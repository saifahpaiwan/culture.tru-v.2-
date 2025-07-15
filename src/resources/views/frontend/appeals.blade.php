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
    .invalid {
        border-color: #F44336;
        color: #F44336;
    }
</style>
@endsection
@section('content')
<div class="page-header--section pd--80-0 text-center bg--overlay" data-bg-img="{{ asset('images/bg_detail.jpg') }}">
    <div class="container">
        <h2 class="h2"> ช่องทางรับฟังความคิดเห็น ข้อเสนอแนะ และการร้องเรียน </h2>
        <ul class="breadcrumb">
            <li><a href="#">หน้าหลัก</a></li>
            <li><span> ช่องทางรับฟังความคิดเห็น ข้อเสนอแนะ และการร้องเรียน </span></li>
        </ul>
    </div>
</div>

<div class="container">
    <form action="{{ route('save.appeals') }}" method="POST" id="appeals-form">
        @csrf
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
        <input type="hidden" name="action" value="validate_captcha">
        <div class="row mt-2" style="display: flex; justify-content: center;">
            <div class="col-xs-12 col-md-7">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="150">
                        @if(session("success"))
                        <div class="alert alert-success text-success mt-2" role="alert">
                            <i class="icon-check"></i> {{session("success")}}
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control @error('title') invalid @enderror" id="name" name="name" placeholder="โปรดระบุชื่อ-นามสกุล" required>
                            @error('name')
                            <div class="mt-2">
                                <small style="color: #F44336;">{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">อีเมล์</label>
                            <input type="email" class="form-control @error('title') invalid @enderror" id="email" name="email" placeholder="โปรดระบุอีเมล์" required>
                            @error('email')
                            <div class="mt-2">
                                <small style="color: #F44336;">{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="topic" class="form-label">หัวข้อร้องเรียนร้องทุกข์</label>
                            <input type="text" class="form-control @error('title') invalid @enderror" id="topic" name="topic" placeholder="โปรดระบุหัวข้อ" required>
                            @error('topic')
                            <div class="mt-2">
                                <small style="color: #F44336;">{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">คำร้องเรียนร้องทุกข์</label>
                            <textarea class="form-control @error('title') invalid @enderror" id="description" name="description" rows="3" required></textarea>
                            @error('description')
                            <div class="mt-2">
                                <small style="color: #F44336;">{{ $message }}</small>
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <button type="submit" class="btn btn-default" data-sitekey="6LcN2_4kAAAAADAmggKvkzcm4-oGMF0Cza3rCCRk" data-callback="onSubmit">ส่งคำร้อง</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('script') 
<script src="https://www.google.com/recaptcha/api.js?render=6LcN2_4kAAAAADAmggKvkzcm4-oGMF0Cza3rCCRk"></script>
<script>
    grecaptcha.ready(function() { 
        grecaptcha.execute('6LcN2_4kAAAAADAmggKvkzcm4-oGMF0Cza3rCCRk', {
                action: 'validate_captcha'
            })
            .then(function(token) { 
                document.getElementById('g-recaptcha-response').value = token;
            });
    });
</script>
@endsection