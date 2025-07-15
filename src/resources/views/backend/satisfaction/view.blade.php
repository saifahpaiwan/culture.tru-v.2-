@extends('layouts.appbackend')
@section('style')
<value href="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<value href="{{ asset('template-end/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
          <h4 class="page-title"> <i class="fa fa-sign-language"></i> แก้ไขความพึงพอใจต่อบริการ </h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background: #ddd;">
            <div class="row">
              <div class="col-md-12">
                <h5 class="m-0"> แก้ไขความพึงพอใจต่อบริการ </h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            @if(session("success"))
            <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;">
              <i class="icon-check"></i> {{session("success")}}
            </div>
            @endif
            <form method="POST" action="{{ route('satisfaction.save') }}" id="form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="statusData" name="statusData" value="U">
              <input type="hidden" id="id" name="id" value="{{ $data['satisfaction']->id ?? 0 }}">

              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="value"> แก้ไขความพึงพอใจต่อบริการ หน้าหลัก <span class="text-danger">*</span></label>
                      <input id="value" type="number" class="form-control form-control-lg @error('value') invalid @enderror" name="value" value="{{ $data['satisfaction']->value ?? '' }}" required autocomplete="value" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('value')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                  </div>
                </div> 
              </div>

              <hr>
              <div class="row">
                <div class="col-md-12 form-group text-right">
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
</script>
@endsection