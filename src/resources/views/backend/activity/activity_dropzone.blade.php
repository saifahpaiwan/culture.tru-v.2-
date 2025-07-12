@extends('layouts.appbackend')
@section('style')
<link href="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template-end/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<style>
  .box-img-gallery {
    width: 150px;
    height: 150px;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin: 0 0.25rem;
  }
</style>
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box">
          <h4 class="page-title"> <i class="fe-grid"></i> โครงการ/กิจกรรม </h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background: #ddd;">
            <div class="row align-items-center">
              <div class="col-md-6">
                <a href="{{ route('activity.list') }}" class="btn btn-xs btn-icon waves-effect btn-secondary mิ-1"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
              </div>
              <div class="col-md-6 text-right">
                <a href="{{ route('activity.dropzone', $data['get_id']) }}" class="btn btn-xs btn-icon waves-effect btn-dark mิ-1"><i class="fe-rotate-cw"></i> รีเซ็ต </a>
                <button type="button" class="btn btn-xs btn-icon waves-effect btn-danger mิ-1 delete-all" data-id="{{ $data['get_id'] }}"><i class="mdi mdi-delete"></i> ลบทั้งหมด </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <h5>ประมวณภาพ : {{ $data['activity_find']->activity_title }} </h5>
            <p> {{ $data['activity_find']->activity_intro }} </p>
            <div>
              <form action="{{ route('save.activity.dropzone') }}" method="POST" class="dropzone dz-clickable" id="myAwesomeDropzone" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data['get_id'] }}">
                <div class="dz-message needsclick">
                  <i class="h1 text-muted dripicons-cloud-upload"></i>
                  <h4 class="mt-3">วางไฟล์ที่นี่หรือคลิกเพื่ออัปโหลด.</h4>
                  <span class="text-muted font-13">(โปรดกำหนดขนาดรูปภาพไม่เกิน 5 MB และสัดส่วนภาพที่เท่ากันเพื่อความสวยงาม)</span>
                </div>
              </form>
            </div>
            <div class="preview mt-2">
              <h4> Preview Image</h4>
              <div class="d-flex flex-wrap">
                @if(isset($data['gallerys']) && count($data['gallerys'])>0)
                @foreach($data['gallerys'] as $row)
                <div class="mb-2">
                  <a href="javascript:void(0)" class="preview-images" data-img="{{ asset('images/activity/gallery').'/'.$row->image_desktop }}">
                    <div class="box-img-gallery" style="background: url(<?php echo asset('images/activity/gallery') . '/' . $row->image_desktop; ?>); background-size: cover; background-position: center;"></div>
                  </a>
                  <div class="text-center"> <a href="javascript:void(0)" class="remove" data-id="{{ $row->id }}"> <i class="fas fa-times-circle"></i> Remove Image</a> </div>
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
</div>

<!-- Modal -->
<div class="modal fade" id="ModalGallery" tabindex="-1" role="dialog" aria-labelledby="ModalGalleryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times-circle"></i>
        </button>
        <div class="modalgallery-add"></div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('template-end/libs/dropzone/dropzone.min.js') }}"></script>
<script>
  $("div#myAwesomeDropzoned").dropzone({
    url: "{{ route('save.activity.dropzone') }}",
    acceptedFiles: ".jpeg,.jpg,.png",
    maxFilesize: 5, // MB
paramName: "file",
    addRemoveLinks: true,
  });

  $(document).on('click', '.remove', function(event) {
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
        $.post("{{ route('close.activity.gallery') }}", {
            _token: "{{ csrf_token() }}",
            id: id,
          })
          .done(function(data, status, error) {
            if (error.status == 200) {
              location.href = "{{ route('activity.dropzone', [$data['get_id']]) }}";
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

  $(document).on('click', '.preview-images', function(event) {
    var img = $(this)[0].dataset.img;
    var html = '<div style="background: url(' + img + '); background-size: cover; background-position: center; width: 100%; height: 350px;"></div>';
    $('.modalgallery-add').html(html);
    $('#ModalGallery').modal('show');
  });

  $(document).on('click', '.delete-all', function(event) {
    var id = $(this)[0].dataset.id;
    var vthis = $(this);
    vthis[0].innerHTML = '<i class="mdi mdi-spin mdi-loading"></i>';
    Swal.fire({
      title: 'ยืนยันการลบข้อมูลทั้งหมด หรือไม่?',
      text: "ระบบจะทำการลบข้อมูลทั้งหมด และจะไม่สามารถนำกลับได้ !",
      type: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      confirmButtonClass: "btn btn-primary btn-lg",
      cancelButtonClass: "btn btn-secondary btn-lg ml-1",
      buttonsStyling: !1
    }).then((result) => {
      if (result.value) {
        $.post("{{ route('close.activity.dropzone.all') }}", {
            _token: "{{ csrf_token() }}",
            id: id,
          })
          .done(function(data, status, error) {
            location.reload();
          });
      } else {
        vthis[0].innerHTML = '<i class="mdi mdi-delete"></i> ลบทั้งหมด';
      }
    });
  });
</script>
@endsection