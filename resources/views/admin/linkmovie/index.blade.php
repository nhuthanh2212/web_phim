@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Liệt Kê Server phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <a href="{{route('linkmovie.create')}}" class="btn btn-danger">Thêm Server</a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#linkmovie">
                  Thêm Nhanh Server
                </button>

                <!-- Modal -->
                <div class="modal fade" id="linkmovie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    {!! Form::open(['route' => 'linkmovie.store','method'=>'POST']) !!} 
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm Server Phim</h5>
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
                                {!! Form::label('title','Tên Server',[]) !!}
                                {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                            </div>
                            
                            <div class="form-group">
                                {!! Form::label('description','Mô tả',[]) !!}
                                {!! Form::textarea('description', isset($linkmovie) ? $linkmovie->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'description']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Active','Trạng Thái',[]) !!}
                                {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($linkmovie) ?  $linkmovie->status : '', ['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('position','Thứ Tự',[]) !!}
                                {!! Form::text('position', isset($linkmovie) ? $linkmovie->position : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
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
                            <th scope="col">Tên Server</th>
                            
                            <th scope="col">Mô Tả</th>
                            <th scope="col">Trạng Thái</th>

                            <th scope="col">Quản Lý</th>
                        </tr>
                      </thead>
                      <tbody class="position_linkmovie">
                        @foreach($list as $key => $cate)
                        <tr id="{{$cate->id}}">
                          <th scope="row">{{$cate->position}}</th>
                          <td>{{$cate->id}}</td>
                          <td>{{$cate->title}}</td>
                         
                          <td>{{$cate->description}}</td>
                          <td>
                              @if($cate->status == 1)
                              Hiển Thị
                              @else
                              Không Hiển Thị
                              @endif
                          </td>
                          <td>
                              {!! Form::open(['method'=>'DELETE','route'=>['linkmovie.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn Muốn Xóa Link Phim Này?")']) !!}
                                {!! Form::submit('DELETE',['class'=>'btn btn-danger']) !!}
                              {!! Form::close() !!}
                              <a href="{{route('linkmovie.edit',$cate->id)}}" class="btn btn-warning">Update</a>
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
