@extends('layouts.appbackend')
@section('style')
@endsection
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box">
          <h4 class="page-title"> <i class="fa fa-comments"></i> ร้องเรียนร้องทุกข์ </h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <p> <b>ชื่อ-นามสกุล</b> : {{ $data['appeals_find']->name }}</p>
            <p> <b>อีเมล</b> : {{ $data['appeals_find']->email }}</p>
            <p> <b>หัวข้อร้องเรียนร้องทุกข์</b> : {{ $data['appeals_find']->topic }}</p>
            <p> <b>คำร้องเรียนร้องทุกข์</b> : {{ $data['appeals_find']->description }}</p>
            <p> <b>วันที่ส่ง</b> : {{ $data['appeals_find']->created_at }}</p>
            <hr>
            <a href="{{ route('appeals.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@endsection