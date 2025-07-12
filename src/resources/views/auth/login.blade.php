@extends('layouts.appauth')
@section('style')
<style>
</style>
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6 col-xl-4">
    <div class="card mb-0">
      <div class="card-body p-4">
        <div class="account-box">
          <div class="account-logo-box">
            <h5 class="text-uppercase mb-0">ทำการล็อกอินเข้าสู่ระบบ</h5>
          </div>
          @if(session("error"))
          <div class="alert alert-danger text-danger mt-2" role="alert" style="background: #fff2f1;">
            {{session("error")}}
          </div>
          @endif
          @if(session("success"))
          <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;">
            <i class="icon-check"></i> {{session("success")}}
          </div>
          @endif
          <div class="account-content mt-2">
            <form class="form-horizontal" action="{{ route('login-check') }}" method="POST">
              @csrf
              <div class="form-group row">
                <div class="col-12">
                  <label for="email">อีเมล</label>
                  <input class="form-control form-control-lg" type="email" id="email" name="email" required="" placeholder="โปรดระบุอีเมลของท่าน" required value="{{ old('email') }}">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <div class="col-12">
                  <a href="{{ route('forget.password.get') }}" class="text-muted float-right"><small>ลืมรหัสผ่าน ?</small></a>
                  <label for="password">รหัสผ่าน</label>
                  <input class="form-control form-control-lg" type="password" required="" id="password" name="password" placeholder="โปรดระบุรหัสผ่านของท่าน" required>
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              
              <div class="form-group row text-center">
                <div class="col-12">
                  <button class="btn btn-md btn-block btn-primary waves-effect waves-light btn-lg" type="submit">
                    <span class="text-submit">ล็อกอิน</span>
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
<script>

</script>
@endsection