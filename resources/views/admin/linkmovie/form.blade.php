@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quản Lý Server Phim</div>
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
                    <a href="{{route('linkmovie.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Server Phim</a>
                    @if(!isset($linkmovie))
                         {!! Form::open(['route' => 'linkmovie.store','method'=>'POST']) !!} 
                    @else
                         {!! Form::open(['route' => ['linkmovie.update',$linkmovie->id],'method'=>'PUT']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'linkmovie.store','method'=>'POST']) !!}  -->
                        <div class="form-group">
                            {!! Form::label('title','Tên Server',[]) !!}
                            {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
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
                        @if(!isset($linkmovie))
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
