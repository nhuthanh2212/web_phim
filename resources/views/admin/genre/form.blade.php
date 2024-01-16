@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
                <div class="card-header">Quản Lý Thể Loại</div>
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
                    <a href="{{route('genre.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Thể Loại</a>
                    @if(!isset($genre))
                         {!! Form::open(['route' => 'genre.store','method'=>'POST']) !!} 
                    @else
                         {!! Form::open(['route' => ['genre.update',$genre->id],'method'=>'PUT']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'genre.store','method'=>'POST']) !!}  -->
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
                       
                        @if(!isset($genre))
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
