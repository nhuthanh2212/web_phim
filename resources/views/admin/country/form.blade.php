@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quản Lý Quốc Gia</div>
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
                    <a href="{{route('country.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Quốc Gia</a>
                    @if(!isset($country))
                         {!! Form::open(['route' => 'country.store','method'=>'POST']) !!} 
                    @else
                         {!! Form::open(['route' => ['country.update',$country->id],'method'=>'PUT']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'country.store','method'=>'POST']) !!}  -->
                        <div class="form-group">
                            {!! Form::label('title','Tên Quốc Gia',[]) !!}
                            {!! Form::text('title', isset($country) ? $country->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug','Đường Dẫn',[]) !!}
                            {!! Form::text('slug', isset($country) ? $country->slug : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description','Mô Tả',[]) !!}
                            {!! Form::textarea('description', isset($country) ? $country->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('position','Thứ Tự',[]) !!}
                            {!! Form::text('position', isset($country) ? $country->position : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active','Trạng Thái',[]) !!}
                            {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($country) ?  $country->status : '', ['class'=>'form-control']) !!}
                        </div>
                        @if(!isset($country))
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
