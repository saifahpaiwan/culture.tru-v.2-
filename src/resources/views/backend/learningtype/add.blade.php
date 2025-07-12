@extends('layouts.appbackend')
@section('style')
<link href="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template-end/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
<style>
  .select2-container--default .select2-selection--single {
    height: 42px;
    border: 1px solid #dee2e6;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 42px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 42px;
  }
</style>
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box">
          <h4 class="page-title"> <i class="fe-box"></i> ประเภทแหล่งเรียนรู้ </h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background: #ddd;">
            <div class="row">
              <div class="col-md-12">
                <h5 class="m-0"> เพิ่มประเภทแหล่งเรียนรู้
                  <a href="{{ route('learningtype.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
                </h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            @if(session("success"))
            <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;">
              <i class="icon-check"></i> {{session("success")}}
            </div>
            @endif

            <form method="POST" action="{{ route('save.learningtype') }}" id="form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="statusData" name="statusData" value="C">
              <input type="hidden" id="id" name="id" value="">

              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="name"> ชื่อประเภทแหล่งเรียนรู้ <span class="text-danger">*</span></label>
                      <input id="name" type="text" class="form-control form-control-lg @error('name') invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('name')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                       
                    <div class="col-md-12 form-group">
                      <div class="mb-2">
                        <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>
                        <div class="cc-selector">
                          <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }} />
                          <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>

                          <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }} />
                          <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label>
                        </div>
                      </div> 
                    </div> 
                  </div>
                </div> 
              </div>

              <hr>
              <div class="row">
                <div class="col-md-12 form-group text-right">
                  <a href="{{ route('learningtype.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
                  <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light">
                    <span class="text-submit"> <i class="fe-save"></i> บันทึกข้อมูล </span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script src="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('template-end/libs/select2/select2.min.js') }}"></script>  
<script>
  $("form").submit(function(event) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $("form").submit();
  });

  $('#status').select2();  
  setTimeout(function() {
    $('.alert-success').fadeOut();
  }, 3000);
</script>
@endsection