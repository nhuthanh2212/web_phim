@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Liệt Kê Thể Loại</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('genre.create')}}" class="btn btn-danger">Thêm Thể Loại</a>
                    <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#category">
                  Thêm Nhanh Thể Loại
                </button>

                <!-- Modal -->
                <div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    {!! Form::open(['route' => 'genre.store','method'=>'POST']) !!} 
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm Thể Loại Phim</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <div class="card">
                   
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                       <div class="form-group">
                            {!! Form::label('title','Tên Thể Loại',[]) !!}
                            {!! Form::text('title', isset($genre) ? $genre->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug','Đường Dẫn',[]) !!}
                            {!! Form::text('slug', isset($genre) ? $genre->slug : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description','Mô tả',[]) !!}
                            {!! Form::textarea('description', isset($genre) ? $genre->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('position','Thứ Tự',[]) !!}
                            {!! Form::text('position', isset($genre) ? $genre->position : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active','Trạng Thái',[]) !!}
                            {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($genre) ?  $genre->status : '', ['class'=>'form-control']) !!}
                        </div>
                            
                                  
                                </div>
                            </div>
                          </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <!-- <button type="button" class="btn btn-primary">Thêm</button> -->
                        {!! Form::submit('ADD', ['class'=>'btn btn-primary']) !!}
                      </div>
                    </div>
                     {!! Form::close() !!} 
                  </div>
                </div>
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">ID</th>
                                <th scope="col">Tên Thể Loại</th>
                                <th scope="col">Đường Dẫn </th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Quản Lý</th>
                            </tr>
                          </thead>
                          <tbody class="position_genre">
                            @foreach($list as $key => $cate)
                            <tr id="{{$cate->id}}">
                                <th scope="row">{{$cate->position}}</th>
                                <td>{{$cate->id}}</td>
                                <td>{{$cate->title}}</td>
                                <td>{{$cate->slug}}</td>
                                <td>{{$cate->description}}</td>
                                <td>
                                    @if($cate->status == 1)
                                      Hiển Thị
                                    @else
                                      Không Hiển Thị
                                    @endif
                                </td>
                              <td>
                                  {!! Form::open(['method'=>'DELETE','route'=>['genre.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn Muốn Xóa Thể Loại Này?")']) !!}
                                    {!! Form::submit('DELETE',['class'=>'btn btn-danger']) !!}
                                  {!! Form::close() !!}
                                  <a href="{{route('genre.edit',$cate->id)}}" class="btn btn-warning">Update</a>
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
@endsection
