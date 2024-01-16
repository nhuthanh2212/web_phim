@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cấp Quyền User: {{$user->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <style type="text/css">
                        .check{
                                margin-right: 50px;
                                display: contents;
                        }
                    </style>
                <form action="{{url('insert-permission',[$user->id])}}" method="POST">
                    @csrf
                    @if(isset($name_roles))
                    <p>Vai Trò Hiện Tại (Role):
                        @foreach($name_roles as $key => $r)
                            {{$r->name}}
                        @endforeach
                    </p>
                    @else
                        <p>Chưa Có Vai Trò</p>
                    @endif
                    <br>
                    @foreach($permission as $key => $per)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                            @foreach($get_permission_viarole as $key => $get)
                                @if($get->id == $per->id)
                                    checked
                                @endif
                            @endforeach

                             name="permission[]" multiple value="{{$per->id}}" id="{{$per->id}}">
                            <label class="form-check-label" for="{{$per->id}}">
                            {{$per->name}}
                          </label>
                        </div>
                    @endforeach
                    @if(isset($all_column_roles))
                        <input type="submit" name="updateroles" value="Cập Nhật Thêm Quyền Cho User" class="btn btn-warning btn-sm">
                    @else
                         <input type="submit" name="insertroles" value="Cấp Quyền Cho User" class="btn btn-danger btn-sm">
                    @endif
                    <a href="{{route('user.index')}}" class="btn btn-success btn-sm">Quay Lại</a>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <form action="{{url('insert-per')}}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="exampleModalLabel">Tên Quyền</label>
                        <input type="text" class="form-control" name="permission" value="{{old('permission')}}" placeholder="Tên Quyền....">
                    </div>
                
                <input type="submit" class="btn btn-primary btn-sm" name="insertper" value="Thêm Quyền">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
