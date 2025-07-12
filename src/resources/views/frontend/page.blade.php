@extends('layouts.appfrontend')
@section('meta')
<meta name="title" content=" @if(isset($data['result_page']->page_meta_title)) {{ $data['result_page']->page_meta_title }} @endif">
<meta name="description" content="@if(isset($data['result_page']->page_meta_description)) {{ $data['result_page']->page_meta_description }} @endif">
<meta name="keywords" content="@if(isset($data['result_page']->page_meta_keyword)) {{ $data['result_page']->page_meta_keyword }} @endif">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('page', [$data['get_id']]) }}">
<meta property="og:title" content=" @if(isset($data['result_page']->page_meta_title)) {{ $data['result_page']->page_meta_title }} @endif">
<meta property="og:description" content="@if(isset($data['result_page']->page_meta_description)) {{ $data['result_page']->page_meta_description }} @endif">
<meta property="og:keywords" content="@if(isset($data['result_page']->page_meta_keyword)) {{ $data['result_page']->page_meta_keyword }} @endif">
<meta property="og:image" content="@if(isset($data['result_page']->page_image_desktop)) {{ asset('images/page').'/'.$data['result_page']->page_image_desktop }} @endif ">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ route('page', [$data['get_id']]) }}">
<meta property="twitter:title" content=" @if(isset($data['result_page']->page_meta_title)) {{ $data['result_page']->page_meta_title }} @endif">
<meta property="twitter:description" content="@if(isset($data['result_page']->page_meta_description)) {{ $data['result_page']->page_meta_description }} @endif">
<meta property="twitter:keywords" content="@if(isset($data['result_page']->page_meta_keywords)) {{ $data['result_page']->page_meta_keywords }} @endif">
<meta property="twitter:image" content="@if(isset($data['result_page']->page_image_desktop)) {{ asset('images/page').'/'.$data['result_page']->page_image_desktop }} @endif">
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

    a {
        color: #ff9800;
    }

    a:hover {
        color: #fedba7;
    }
</style>
@endsection
@section('content')
<div class="container mb-2">

    <div class="row p-2">
        <div class="col-md-12">
            <h2 class="mr-auto topic-font"> {{ $data['result_page']->page_title }} </h2>
            <p>
                {{ $data['result_page']->page_intro }}
            </p>
            <hr>
        </div>
        <div class="col-md-12">
            @if(isset($data['result_page']->file_pdf))
            @if(!empty($data['result_page']->file_pdf))
            <div class="text-center mb-3 d-none d-sm-block">
                <object data="{{ asset('images/page/pdf').'/'.$data['result_page']->file_pdf }}" type="application/pdf" width="100%" height="700"> </object>
            </div>
            <div class="text-center mb-3 d-block d-sm-none show-node-pdf">
                <div><b>เบราว์เซอร์นี้ไม่สนับสนุน PDF กรุณาดาวน์โหลดไฟล์ PDF เพื่อดู</b> </div>
                <a class="btn mt-1" href="{{ asset('images/page/pdf').'/'.$data['result_page']->file_pdf }}">Download PDF</a>
            </div>
            @endif
            @endif
        </div>
        <div class="col-md-12">
            <?php
            if (isset($data['result_page']->page_file_text)) {
                echo @file_get_contents(storage_path() . '/app/' . $data['result_page']->page_file_text);
            }
            ?>
        </div>
        <div class="col-md-12">
          
            <div class="zoom-gallery text-center mt-2">
                @if(isset($data['gallerys']) && count($data['gallerys'])>0)
                @foreach($data['gallerys'] as $row)
                <a href="{{ asset('images/page/gallery').'/'.$row->image_desktop }}" data-source="{{ asset('images/page/gallery').'/'.$row->image_desktop }}" title="" style="width:200px;height:200px;">
                    <img src="{{ asset('images/page/gallery').'/'.$row->image_desktop }}" width="200" height="200">
                </a>
                @endforeach
                @endif
            </div>

        </div>
    </div>
</div>



</div>

@endsection
@section('script')
<script>

</script>
@endsection