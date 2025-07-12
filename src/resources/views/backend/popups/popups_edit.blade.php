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
          <h4 class="page-title"> <i class="fe-image"></i> Pop Up </h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background: #ddd;">
            <div class="row">
              <div class="col-md-12">
                <h5 class="m-0"> แก้ไข Pop Up
                  <a href="{{ route('popups.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
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
            <form method="POST" action="{{ route('save.popups') }}" id="form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="statusData" name="statusData" value="U">
              <input type="hidden" id="id" name="id" value="{{ $data['popups_find']->id }}">

              <div class="row">
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="popups_title"> ชื่อ Pop Up</label>
                      <input id="popups_title" type="text" class="form-control form-control-lg @error('popups_title') invalid @enderror" name="popups_title"
                        value="{{ $data['popups_find']->title }}"
                        autocomplete="popups_title" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('popups_title')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="description"> คำอธิบาย</label>
                      <input id="description" type="text" class="form-control form-control-lg @error('description') invalid @enderror" name="description"
                        value="{{ $data['popups_find']->description }}"
                        autocomplete="description" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('description')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>

                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="popups_link"> ลิงค์ <i class="fe-link"></i></label>
                      <input id="popups_link" type="link" class="form-control form-control-lg @error('popups_link') invalid @enderror" name="popups_link"
                        value="{{ $data['popups_find']->link }}"
                        autocomplete="popups_link" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('popups_link')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-3">

                  <div class="col-md-12 form-group">
                    <label for="file_upload_dektop"> รูปแสดงผลบน Web <span class="text-danger">*</span></label>
                    <div class="img-file-upload-2">
                      <img src="{{ asset('images/popups').'/'.$data['popups_find']->image_desktop }}" class="rounded w-100">
                    </div>
                    <div class="mt-1 mb-1"> Size image 800*400 2MB. </div>
                    <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop"
                      value="{{ old('file_upload_dektop') }}"
                      autocomplete="file_upload_dektop" autofocus>
                    <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="{{ $data['popups_find']->image_desktop }}">
                    @error('file_upload_dektop')
                    <span class="invalid-feedback" role="alert">
                      <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="col-md-12 form-group">
                    <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>
                    <div class="cc-selector">
                      <div class="cc-selector">
                        <input id="status1" type="radio" name="status" value="0" {{ $data['popups_find']->deleted_at == true ? $data['popups_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }} />
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>

                        <input id="status2" type="radio" name="status" value="1" {{ $data['popups_find']->deleted_at == 1 ? "checked" : "" }} />
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12 form-group text-right">
                  <a href="{{ route('popups.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
                  <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['popups_find']->id }}">
                    <i class="mdi mdi-delete"></i> ยกเลิกข้อมูล
                  </button>
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
  $('#popups_type').select2();

  $(document).on('click', '#close', function(event) {
    var id = $(this)[0].dataset.id;
    var vthis = $(this);
    vthis[0].innerHTML = '<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
    Swal.fire({
      title: 'ยืนยันการยกเลิกข้อมูล หรือไม่?',
      text: "ระบบจะทำการยกเลิกข้อมูล และจะไม่สามารถนำกลับได้ !",
      type: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      confirmButtonClass: "btn btn-primary btn-lg",
      cancelButtonClass: "btn btn-secondary btn-lg ml-1",
      buttonsStyling: !1
    }).then((result) => {
      if (result.value) {
        $.post("{{ route('close.popups') }}", {
            _token: "{{ csrf_token() }}",
            id: id,
          })
          .done(function(data, status, error) {
            if (error.status == 200) {
              location.href = "{{ route('popups.list') }}";
            }
          })
          .fail(function(xhr, status, error) {
            //alert('An error occurred, please try again.'); 
            location.reload();
          });
      } else {
        vthis[0].innerHTML = '<i class="mdi mdi-delete"></i> ยกเลิกข้อมูล';
      }
    });
  });


  $(document).on('change', '#file_upload_dektop', function(event) {
    var img = "{{ asset('images/no-img.jpeg') }}";
    html = '<img src="' + img + '" class="rounded w-100">';
    var Images = $('#file_upload_dektop');
    if (Images[0].files[0]) {
      url = window.URL.createObjectURL(Images[0].files[0]);
      html = '<img src="' + url + '" class="rounded w-100">';
    }
    $('.img-file-upload-2').html(html);
  });


  setTimeout(function() {
    $('.alert-success').fadeOut();
  }, 3000);
  $("form").submit(function(event) {
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $("form").submit();
  });
</script>
@endsection