@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Liệt Kê Thông Tin</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <a href="{{route('info.create')}}" class="btn btn-danger">Thêm Thông Tin</a>
                <table class="table table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">ID</th>
                            <th scope="col">Tiêu Đề Thông Tin Website</th>
                            
                            <th scope="col">Mô Tả</th>
                            <th scope="col">Copyright</th>
                            <th scope="col">Hình Ảnh Logo</th>

                            <th scope="col">Quản Lý</th>
                        </tr>
                      </thead>
                      <tbody class="position_info">
                        @foreach($list as $key => $inf)
                        <tr id="{{$inf->id}}">
                          <th scope="row">{{$key}}</th>
                          <td>{{$inf->id}}</td>
                          <td>{{$inf->title}}</td>
                          
                          <td>{{$inf->description}}</td>
                          <td>{{$inf->copyright}}</td>
                          <td>
                             <img width="100" src="{{asset('uploads/logo/'.$inf->logo)}}">
                          </td>
                          <td>
                              {!! Form::open(['method'=>'DELETE','route'=>['info.destroy',$inf->id],'onsubmit'=>'return confirm("Bạn Muốn Xóa Thông Tin Website Này?")']) !!}
                                {!! Form::submit('DELETE',['class'=>'btn btn-danger']) !!}
                              {!! Form::close() !!}
                              <a href="{{route('info.edit',$inf->id)}}" class="btn btn-warning">Update</a>
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
