@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quản Lý Thông Tin</div>
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
                    <a href="{{route('info.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Thông Tin</a>
                    @if(!isset($infor))
                         {!! Form::open(['route' => 'info.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!} 
                    @else
                         {!! Form::open(['route' => ['info.update',$info->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'info.store','method'=>'POST']) !!}  -->
                        <div class="form-group">
                            {!! Form::label('title','Tiêu Đề Website',[]) !!}
                            {!! Form::text('title', isset($infor) ? $info->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                
                        <div class="form-group">
                            {!! Form::label('description','Mô Tả Website',[]) !!}
                            {!! Form::textarea('description', isset($infor) ? $info->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('logo','Hình Ảnh LoGo',[]) !!}
                            {!! Form::file('logo', ['class'=>'form-control-file']) !!}
                            @if(isset($infor))
                                <img width="20%" src="{{asset('uploads/logo/'.$info->logo)}}">
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('copyright','Copyright',[]) !!}
                            {!! Form::text('copyright', isset($infor) ? $info->copyright : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('position','Thứ Tự',[]) !!}
                            {!! Form::text('position', isset($infor) ? $info->position : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        @if(!isset($infor))
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
