@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quản Lý Danh Mục</div>
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
                    <a href="{{route('category.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Danh Mục</a>
                    @if(!isset($category))
                         {!! Form::open(['route' => 'category.store','method'=>'POST']) !!} 
                    @else
                         {!! Form::open(['route' => ['category.update',$category->id],'method'=>'PUT']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'category.store','method'=>'POST']) !!}  -->
                        <div class="form-group">
                            {!! Form::label('title','Tên Danh Mục',[]) !!}
                            {!! Form::text('title', isset($category) ? $category->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug','Đường Dẫn',[]) !!}
                            {!! Form::text('slug', isset($category) ? $category->slug : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description','Mô tả',[]) !!}
                            {!! Form::textarea('description', isset($category) ? $category->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active','Trạng Thái',[]) !!}
                            {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($category) ?  $category->status : '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('position','Thứ Tự',[]) !!}
                            {!! Form::text('position', isset($category) ? $category->position : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        @if(!isset($category))
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
