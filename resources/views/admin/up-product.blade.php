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
                محصولات / بروزرسانی {{$product->title}}
                <a class="btn btn-primary float-left text-white py-2 px-4" href="{{route('admin.products.showAll')}}">بازگشت به صفحه محصولات</a>
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
                      <form action="{{route('product.update' , $product->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>عنوان</label>
                                          <input type="text" class="form-control" name="title" value="{{$product->title}}">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label>دسته بندی</label>
                                          <select class="form-control" name="category_id">
                                              @foreach ($listOfCat as $cat)
                                              <option value="{{$cat->id}}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{$cat->title}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label>قیمت</label>
                                          <input type="text" class="form-control" name="price" value="{{$product->price}}">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>تصویر شاخص</label>
                                          <input class="form-control" type="file" name="thumbnail_url">
                                      </div>
                                      <div class="form-group">
                                        <img src="/uploads/{{$product->thumbnail_url}}" alt="" style="width: 22em;border-radius: 13px;">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>تصویر محصول</label>
                                          <input class="form-control" type="file" name="demo_url">
                                      </div>
                                      <div class="form-group">
                                        <img src="/uploads/{{$product->demo_url}}" alt="" style="width: 22em;border-radius: 13px;">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>سورس اصلی محصول</label>
                                          <input class="form-control" type="file" name="source_url">
                                      </div>
                                      <div class="form-group" style="text-align:center">
                                        <a href="{{ route('product.download.source' , $product->id) }}" class="btn btn-default btn-icons" title="لینک دانلود"><i class="fa fa-link"></i></a>
                                      </div>
                                  </div>

                              </div>
                              <div class="form-group">
                                  <label>توضیحات</label>
                                  <textarea name="description" id="editor">{{$product->description}}</textarea>
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