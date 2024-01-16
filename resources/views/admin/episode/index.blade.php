@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Liệt Kê Tập Phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('episode.create')}}" class="btn btn-danger">Thêm Tập Phim</a>
                    <a href="{{route('movie.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Phim</a>
                    <table class="table table-responsive" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">ID</th>
                                <th scope="col">Tên Phim</th>
                                <th scope="col">Hình Ảnh Phim</th>
                                <th scope="col">Link Phim</th>
                                <th scope="col">Tập Phim</th>
                                <th scope="col">Ngày Tạo</th>
                                <th scope="col">Ngày Cập Nhật</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Quản Lý</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($list as $key => $episode)
                               
                        <tr >
                          <th scope="row">{{$key}}</th>
                          <td>{{$episode->id}}</td>
                          <td>{{$episode->movie->title}}</td>
                          <td>
                                @php
                                        $image_check = substr($episode->movie->image,0,5);
                                    @endphp
                                    @if($image_check=='https')
                                        <img width="100%" src="{{$episode->movie->image}}">
                                    
                                    @else
                                         <img width="100" src="{{asset('uploads/movie/'.$episode->movie->image)}}">
                                       
                                    @endif
                                </td>
                          <td style="width: 20%">  {{$episode->linkphim}}</td>
                          <td>{{$episode->episode}}</td>
                          
                          <td>{{$episode->created_at}}</td>
                          <td>{{$episode->updated_at}}</td>
                          <td>
                              @if($episode->status == 1)
                              Hiển Thị
                              @else
                              Không Hiển Thị
                              @endif
                          </td>
                          <td>
                              {!! Form::open(['method'=>'DELETE','route'=>['episode.destroy',$episode->id],'onsubmit'=>'return confirm("Bạn Muốn Xóa Tập Phim Này?")']) !!}
                                {!! Form::submit('DELETE',['class'=>'btn btn-danger']) !!}
                              {!! Form::close() !!}
                              <a href="{{route('episode.edit',$episode->id)}}" class="btn btn-warning">Update</a>
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
