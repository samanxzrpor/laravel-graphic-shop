@extends('layouts.admin.master')

@section('content-admin')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 mt-4">
          <div class="col-12">
            <h1 class="m-0 text-dark">
                <a class="nav-link drawer" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                کاربران / بروز رسانی  {{$user->name}}
                <a class="btn btn-primary float-left text-white py-2 px-4" href="{{ route('users.showAll') }}">بازگشت به صفحه کاربران</a>
            </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <div class="row mt-5">
              <div class="col-md-12">
                  @include('errors.msg')
                  <div class="card card-defualt">
                      <!-- form start -->
                      <form action="{{ route('users.updateUser' , $user->id) }}" method="post">
                          @csrf
                          @method('put')
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>نام و نام خانوادگی</label>
                                          <input type="text" class="form-control" name="name" value="{{ $user['name'] }}">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>ایمیل</label>
                                          <input type="email" class="form-control" name="email" value="{{ $user['email'] }}">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>موبایل</label>
                                          <input type="number" class="form-control" name="number" value="{{ $user['number'] }}">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>نقش کاربری</label>
                                          <select class="form-control" name="role">
                                              @foreach($roles as $role)
                                              <option value="{{ $role }}" {{ $role == $user['role'] ? 'selected' : '' }}>{{ $role }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>رمز عبور</label>
                                        <input type="password" class="form-control" name="password" placeholder="رمز جدید را وارد کنید">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تکرار رمز عبور</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="رمز را تکرار کنید">
                                    </div>
                                  </div>
                              </div>




                          </div>
                          <!-- /.card-body -->

                          <div class="card-footer">
                              <button type="submit" class="btn btn-primary float-left">ذخیره کردن</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection