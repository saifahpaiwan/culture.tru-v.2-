@extends('layouts.appbackend')
@section('style')
<link href="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template-end/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template-end/libs/summernote-0.9.0-dist/summernote-bs4.min.css') }}" rel="stylesheet">
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
          <h4 class="page-title"> <i class="fa fa-universal-access"></i> ประกันคุณภาพการศึกษา </h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background: #ddd;">
            <div class="row">
              <div class="col-md-12">
                <h5 class="m-0"> แก้ไขประกันคุณภาพการศึกษา
                  <a href="{{ route('reportannuals.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
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
            <form method="POST" action="{{ route('save.reportannuals') }}" id="form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="statusData" name="statusData" value="U">
              <input type="hidden" id="id" name="id" value="{{ $data['reportannuals_find']->id }}">

              <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="title"> ชื่อประกันคุณภาพการศึกษา <span class="text-danger">*</span></label>
                      <input id="title" type="text" class="form-control form-control-lg @error('title') invalid @enderror" name="title" value="{{ $data['reportannuals_find']->title }}" required autocomplete="title" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('title')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="intro"> รายละเอียดย่อ <span class="text-danger">*</span></label>
                      <textarea class="form-control form-control-lg @error('intro') invalid @enderror" rows="2" id="intro" name="intro" autocomplete="intro" autofocus placeholder="โปรดระบุข้อมูล..." required>{{ $data['reportannuals_find']->intro }}</textarea>
                      @error('intro')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>

                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="meta_title"> News Meta Title </label>
                      <input id="meta_title" type="text" class="form-control form-control-lg @error('meta_title') invalid @enderror" name="meta_title" value="{{ $data['reportannuals_find']->meta_title }}" autocomplete="meta_title" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('meta_title')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="meta_description"> News Meta Description </label>
                      <input id="meta_description" type="text" class="form-control form-control-lg @error('meta_description') invalid @enderror" name="meta_description" value="{{ $data['reportannuals_find']->meta_description }}" autocomplete="meta_description" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('meta_description')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                    <div class="col-md-12 form-group">
                      <label class="ml-1" for="meta_keyword"> News Meta Keyword </label>
                      <input id="meta_keyword" type="text" class="form-control form-control-lg @error('meta_keyword') invalid @enderror" name="meta_keyword" value="{{ $data['reportannuals_find']->meta_keyword }}" autocomplete="meta_keyword" autofocus placeholder="โปรดระบุข้อมูล...">
                      @error('meta_keyword')
                      <ul class="parsley-errors-list filled">
                        <li class="parsley-required">{{ $message }}</li>
                      </ul>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="col-md-12 form-group">
                    <div class="mb-1">
                      <label for="file_upload_dektop"> รูปแสดงผลบน Web <span class="text-danger">*</span></label>
                      <div class="img-file-upload-2">
                        <img src="{{ asset('images/reportannuals').'/'.$data['reportannuals_find']->image_desktop }}" class="rounded w-100">
                      </div>
                      <div class="my-2"> Size image 2MB. 800*800px </div>
                      <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop" value="{{ old('file_upload_dektop') }}" autocomplete="file_upload_dektop" autofocus>
                      <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="{{ $data['reportannuals_find']->image_desktop }}">
                      @error('file_upload_dektop')
                      <span class="invalid-feedback" role="alert">
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12 form-group">
                    <div class="mb-2">
                      <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>
                      <div class="cc-selector">
                        <input id="status1" type="radio" name="status" value="0" {{  $data['reportannuals_find']->deleted_at == true ?  $data['reportannuals_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }} />
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>

                        <input id="status2" type="radio" name="status" value="1" {{  $data['reportannuals_find']->deleted_at == 1 ? "checked" : "" }} />
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label>
                      </div>
                    </div>
                    <div class="mb-1"><i class="far fa-file-pdf"></i> อัพโหลดไฟล์ PDF ถ้ามี Size 30MB.</div>
                    <input id="file_upload_pdf" type="file" class="@error('file_upload_pdf') invalid @enderror" name="file_upload_pdf" value="{{ old('file_upload_pdf') }}" autocomplete="file_upload_pdf" autofocus>
                    <input type="hidden" id="file_upload_pdf_hdf" name="file_upload_pdf_hdf" value="{{ $data['reportannuals_find']->file_pdf }}">
                    @if(!empty($data['reportannuals_find']->file_pdf))
                    <a href="javascript: void(0);" data-file="{{ $data['reportannuals_find']->file_pdf }}" class="h2 m-0 text-danger" id="close-pdf"><i class="fe-trash-2"></i></a>
                    @endif

                    <span class="mt-1 ml-1" style="font-size: 10px;"> {{ $data['reportannuals_find']->file_pdf }} </span>
                    @error('file_upload_pdf')
                    <ul class="parsley-errors-list filled">
                      <li class="parsley-required">{{ $message }}</li>
                    </ul>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <hr>
                  <label for="file_text">รายละเอียดประกันคุณภาพการศึกษา <span class="text-danger">*</span></label>
                  <textarea cols="10" id="file_text" name="file_text" rows="10"><?php echo @file_get_contents(storage_path() . '/app/' . $data['reportannuals_find']->file_text); ?></textarea>
                  <input type="hidden" id="file_text_hdfs" name="file_text_hdfs" value="{{ $data['reportannuals_find']->file_text }}">
                  @error('file_text')
                  <span class="invalid-feedback" role="alert">
                    <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <hr> 
              <div class="row">
                <div class="col-md-6 form-group">
                  <a href="{{ route('reportannuals.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
                  <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['reportannuals_find']->id }}">
                    <i class="mdi mdi-delete"></i> ยกเลิกข้อมูล
                  </button>
                </div>
                <div class="col-md-6 form-group text-right">
                  <a href="{{ route('reportannuals.dropzone', $data['reportannuals_find']->id) }}" class="btn btn-lg btn-secondary waves-effect waves-light">
                    <i class="fe-image"></i>
                    <span>Add Images Gallerys</span>
                  </a>
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
<script src="{{ asset('template-end/libs/summernote-0.9.0-dist/summernote-bs4.min.js') }}"></script>
<script>
  $(document).on('click', '#close-pdf', function(event) {
    var file = $(this)[0].dataset.file;
    var id = $('#id').val();
    Swal.fire({
      title: 'ยืนยันการลบไฟล์ หรือไม่?',
      text: "ระบบจะทำการลบไฟล์ และจะไม่สามารถนำกลับได้ !",
      type: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      confirmButtonClass: "btn btn-primary btn-lg",
      cancelButtonClass: "btn btn-secondary btn-lg ml-1",
      buttonsStyling: !1
    }).then((result) => {
      if (result.value) {
        $.post("{{ route('close.reportannualspdf') }}", {
            _token: "{{ csrf_token() }}",
            id: id,
            file: file,
          })
          .done(function(data, status, error) {
            if (error.status == 200) {
              location.reload();
            }
          })
          .fail(function(xhr, status, error) {
            //alert('An error occurred, please try again.');
            location.reload();
          });
      }
    });
  });

  $("form").submit(function(event) {
    $('input[name=file_text]').val(sum_val);
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $("form").submit();
  });
  $('#status').select2();

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
        $.post("{{ route('close.reportannuals') }}", {
            _token: "{{ csrf_token() }}",
            id: id,
          })
          .done(function(data, status, error) {
            if (error.status == 200) {
              location.href = "{{ route('reportannuals.list') }}";
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

  $('#file_text').summernote({
    placeholder: 'กรอกข้อมูล',
    tabsize: 2,
    height: 300,
    callbacks: {
      onImageUpload: function(files) {
        sendFileToServer(files[0]);
      },
      onMediaDelete: function(target) {
        deleteFile(target[0].src);
      }
    }
  });

  function sendFileToServer(file) {
    var data = new FormData();
    data.append("file", file);
    data.append("_token", "{{ csrf_token() }}");

    $.ajax({
      url: "{{ route('summernote.upload.image.endpoint') }}", // เปลี่ยน URL ตรงนี้ให้ตรงกับฝั่ง Server
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      type: "POST",
      success: function(url) {
        $('#file_text').summernote('insertImage', url);
      },
      error: function(err) {
        alert("อัปโหลดไม่สำเร็จ");
      }
    });
  }

  function deleteFile(file) {
    var data = new FormData();
    data.append("file", file);
    data.append("_token", "{{ csrf_token() }}");

    $.ajax({
      url: "{{ route('delete.image.endpoint') }}", // เปลี่ยน URL ตรงนี้ให้ตรงกับฝั่ง Server
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      type: "POST",
      success: function(url) {
        console.log(url);
      },
      error: function(err) {
        alert("ลบไม่สำเร็จ");
      }
    });
  }
</script>
@endsection