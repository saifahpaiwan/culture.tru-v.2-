@extends('layouts.appbackend')
@section('style')      
  <link href="{{ asset('template-end/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />    
  <link href="{{ asset('template-end/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
  <style> 
    .select2-container--default .select2-selection--single { height: 42px;    border: 1px solid #dee2e6; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px;} 
  </style>
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
              <div class="page-title-box"> 
                <h4 class="page-title"> <i class="dripicons-web"></i> เว็บไซต์ที่เกี่ยวข้อง  </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> เพิ่มเว็บไซต์ที่เกี่ยวข้อง 
                    <a href="{{ route('relatedsites.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
                <form method="POST" action="{{ route('save.relatedsites') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">

                  <div class="row"> 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="relatedsites_title"> ชื่อเว็บไซต์ที่เกี่ยวข้อง </label>
                      <input id="relatedsites_title" type="text" class="form-control form-control-lg @error('relatedsites_title') invalid @enderror" name="relatedsites_title"  
                      value="{{ old('relatedsites_title') }}"
                      autocomplete="relatedsites_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('relatedsites_title')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>  
                    
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="relatedsites_link"> ลิงค์ <i class="fe-link"></i></label>
                      <input id="relatedsites_link" type="link" class="form-control form-control-lg @error('relatedsites_link') invalid @enderror" name="relatedsites_link"  
                      value="{{ old('relatedsites_link') }}"
                      autocomplete="relatedsites_link" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('relatedsites_link')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                      </div> 
                    </div>  
 
                    <div class="col-md-6 form-group"> 
                      <label for="file_upload_dektop"> รูปแสดงผลบน Web <span class="text-danger">*</span></label>
                      <div class="img-file-upload-2"> 
                        <img src="{{ asset('images/no-img.jpeg') }}" class="event-icon" style="width: 160px; height: 80px; border: 1px solid #ddd;"> 
                      </div>
                      <div class="mt-1 mb-1"> Size image 500x200  2MB. </div>
                      <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop"  
                      value="{{ old('file_upload_dektop') }}"
                      required autocomplete="file_upload_dektop" autofocus> 
                      <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="">
                      @error('file_upload_dektop') 
                        <span class="invalid-feedback" role="alert">
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                        </span>
                      @enderror
                    </div>  
                  </div>
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('relatedsites.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
  $('#relatedsites_type').select2();
   

  $(document).on('change', '#file_upload_dektop', function(event) { 
      var img="{{ asset('images/no-img.jpeg') }}";
      html='<img src="'+img+'" class="event-icon" style="width: 160px; height: 80px; border: 1px solid #ddd;">';      
      var Images = $('#file_upload_dektop'); 
      if ( Images[0].files[0] ){ 
        url=window.URL.createObjectURL(Images[0].files[0]);
        html='<img src="'+url+'" class="event-icon" style="width: 160px; height: 80px; border: 1px solid #ddd;">'; 
      }
      $('.img-file-upload-2').html(html);
  });

  
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $( "form" ).submit(function( event ) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
</script>
@endsection

