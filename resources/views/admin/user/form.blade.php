@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quản Lý User</div>
                @if (session('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            
                                <li>{{ session('errors') }}</li>
                            
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('user.index')}}" class="btn btn-danger">Liệt Kê User</a>
                    @if(!isset($user))
                         {!! Form::open(['route' => 'user.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!} 
                    @else
                         {!! Form::open(['route' => ['user.update',$user->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'info.store','method'=>'POST']) !!}  -->
                        <div class="form-group">
                            {!! Form::label('name','Tên User',[]) !!}
                            {!! Form::text('name', isset($user) ? $user->name : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email','Email',[]) !!}
                            {!! Form::text('email', isset($user) ? $user->email : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                       
                    @if(!isset($user))
                        <div class="form-group">
                            {!! Form::label('password','Password',[]) !!}
                            {!! Form::text('password', isset($user) ? $user->password : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                    @else
                        <div class="form-group">
                            {!! Form::label('password','Old password',[]) !!}
                            {!! Form::text('password','',['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('newpassword','New Password',[]) !!}
                            {!! Form::text('newpassword','', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('confirm','Confirm password',[]) !!}
                            {!! Form::text('confirm','', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                    @endif 
                        @if(!isset($user))
                            {!! Form::submit('ADD', ['class'=>'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update', ['class'=>'btn btn-success']) !!}
                        @endif
                   {!! Form::close() !!} 
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
