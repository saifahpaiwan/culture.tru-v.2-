@extends('layouts.appbackend')
@section('style')
<style>
</style>
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box bg-light">
          <h4 class="page-title"> <i class="fe-home"></i> หน้าหลัก </h4>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-body text-center" style="min-height: 136.09px;">
                <img src="{{ asset('images/logo.png') }}" height="150">
                <div class="mt-2"> Culture TRU | สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี </div>

                <iframe width="600" height="450"
  src="https://lookerstudio.google.com/embed/reporting/xxxxxxx"
  frameborder="0" style="border:0" allowfullscreen></iframe>

  
              </div>
            </div>
          </div>

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