@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản Lý Tập Phim</div>
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
                    <a href="{{route('episode.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Tập Phim</a>
                    @if(!isset($episode))
                         {!! Form::open(['route' => 'episode.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!} 
                    @else
                         {!! Form::open(['route' => ['episode.update',$episode->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!} 
                    @endif
                   
                        <div class="form-group">
                             {!! Form::label('movie_title','Tên Phim',[]) !!}
                            {!! Form::text('movie_title', isset($movie) ? $movie->title : '', ['class'=>'form-control','readonly']) !!}
                            {!! Form::hidden('movie_id', isset($movie) ? $movie->id : '') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('link','Link Phim',[]) !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        
                        @if(isset($episode))
                            <div class="form-group">
                                {!! Form::label('episode','Tập Phim',[]) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...',isset($episode) ? 'readonly' : '']) !!}

                            </div>
                        @else
                            <div class="form-group">
                            {!! Form::label('episode','Tập Phim',[]) !!}
                             {!! Form::selectRange('episode',1,$movie->sotap,$movie->sotap,['class'=>'form-control']) !!}

                            </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('linkserver','Link Server',[]) !!}
                            {!! Form::select('linkserver', $linkmovie,'', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active','Trang Thai',[]) !!}
                            {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($episode) ?  $episode->status : '', ['class'=>'form-control']) !!}
                        </div>

                        @if(!isset($episode))
                            {!! Form::submit('ADD', ['class'=>'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update', ['class'=>'btn btn-success']) !!}
                        @endif
                   {!! Form::close() !!} 
                </div>
            </div>
            
        </div>
        <!-----------liet ke tap phim------------->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Liệt Kê Phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- <a href="{{route('episode.create')}}" class="btn btn-danger">Thêm Tập Phim</a> -->
                    <div class="table-responsive">
                    <table class="table table-responsive" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">ID</th>
                                <th scope="col">Tên Phim</th>
                                <th scope="col">Hình Ảnh Phim</th>
                                <th scope="col">Link Phim</th>
                                <th scope="col">Tập Phim</th>
                                <th scope="col">Link Server</th>
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
                                        $image_check = substr($movie->image,0,5);
                                    @endphp
                                    @if($image_check=='https')
                                        <img width="100%" src="{{$episode->movie->image}}">
                                    
                                    @else
                                         <img width="100" src="{{asset('uploads/movie/'.$episode->movie->image)}}">
                                       
                                    @endif
                            </td>
                          <td style="width: 20%">  {{$episode->linkphim}}</td>
                          <td>{{$episode->episode}}</td>
                          <td>
                            @foreach($list_server as $key => $server_link)
                                @if($episode->server == $server_link->id)
                                    {{$server_link->title}}
                                @endif
                            @endforeach
                          </td>

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
</div>
@endsection
