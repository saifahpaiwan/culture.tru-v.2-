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
            <h5 class="text-uppercase mb-0">ทำการเปลี่ยนรหัสผ่าน</h5>
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

            <form class="form-horizontal" action="{{ route('reset.password.post') }}" method="POST">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">

              <div class="form-group row">
                <div class="col-12">
                  <input class="form-control form-control-lg" type="email" id="email" name="email" required="" placeholder="โปรดระบุอีเมลของท่าน" required value="{{ old('email') }}">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" required="" placeholder="ระบุรหัสผ่านของท่าน" required>
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" type="password" id="passwordConfirm" name="password_confirmation" required="" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required>
                  @error('password_confirmation')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row text-center">
                <div class="col-12">
                  <button class="btn btn-md btn-block btn-primary waves-effect waves-light btn-lg" type="submit">
                    <span class="text-submit"> Reset Password </span>
                  </button>
                </div>
              </div>
            </form>
            <div class="row pt-2">
              <div class="col-sm-12 text-center">
                <p class="text-muted mb-0">หากคุณมีบัญชีผู้ใช้งานอยู่แล้ว.<a href="{{ route('login') }}" class="text-dark ml-1"><b>ล็อกอิน</b></a></p>
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