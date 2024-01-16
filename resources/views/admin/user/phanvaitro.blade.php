@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Cấp Vai Trò User: {{$user->name}}</div>

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
                <form action="{{url('insert-roles',[$user->id])}}" method="POST">
                    @csrf
                    @if(isset($name_roles))
                        <p>Vai Trò Hiện Tại (Role): 
                                @foreach($name_roles as $key => $name_rol)
                                {{$name_rol->name}}
                                @endforeach
                        </p>
                    @else
                    <p>Chưa Có Vai Trò</p>
                    @endif
                   
                    @foreach($role as $key => $r)
                        @if(isset($all_column_roles))
                                <div class="check">
                                <input class="form-check-input"  type="checkbox" name="role[]" id="{{$r->id}}" value="{{$r->name}}" 
                                    @foreach($user->roles as $rol)
                                        @if($rol->id == $r->id)
                                            checked
                                        @endif
                                    @endforeach
                                 >
                                <label class="form-check-label" for="{{$r->id}}">
                                    {{$r->name}}
                                </label>
                                
                        </div>
                        @else
                            <div class="check">
                            <input class="form-check-input"type="checkbox" name="role[]" id="{{$r->id}}" value="{{$r->name}}">
                            <label class="form-check-label" for="{{$r->id}}">
                                {{$r->name}}
                            </label>
                        
                            </div>
                        @endif
                    @endforeach
                    <br>
                    
                    @if(isset($all_column_roles))
                        <input type="submit" name="updateroles" value="Cập Nhật Thêm Vai Trò Cho User" class="btn btn-warning btn-sm">
                    @else
                         <input type="submit" name="insertroles" value="Cấp Vai Trò Cho User" class="btn btn-danger btn-sm">
                    @endif
                    <a href="{{route('user.index')}}" class="btn btn-success btn-sm">Quay Lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
