@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản Lý Phim</div>
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
                    <a href="{{route('movie.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Phim</a>
                    @if(!isset($movie))
                         {!! Form::open(['route' => 'movie.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!} 
                    @else
                         {!! Form::open(['route' => ['movie.update',$movie->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!} 
                    @endif
                   
                   <!-- {!! Form::open(['route' => 'movie.store','method'=>'POST']) !!}  -->
                        <div class="form-group">
                            {!! Form::label('title','Tiêu Đề',[]) !!}
                            {!! Form::text('title', isset($movie) ? $movie->title : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug','Đường Dấn',[]) !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('english','Tên Tiếng Anh',[]) !!}
                            {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('sotap','Số Tập',[]) !!}
                            {!! Form::text('sotap', isset($movie) ? $movie->sotap : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags','Tags Phim',[]) !!}
                            {!! Form::textarea('tags', isset($movie) ? $movie->tags : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description','Mô Tả',[]) !!}
                            {!! Form::textarea('description', isset($movie) ? $movie->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...','id'=>'description']) !!}
                        </div>

                         <div class="form-group">
                            {!! Form::label('trailer','Trailer',[]) !!}
                            {!! Form::text('trailer', isset($movie) ? $movie->trailer : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('thoiluong','Thời Lượng Phim',[]) !!}
                            {!! Form::text('thoiluong', isset($movie) ? $movie->thoiluong : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('Active','Trạng Thái',[]) !!}
                            {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($movie) ?  $movie->status : '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('resolution','Định Dạng',[]) !!}
                            {!! Form::select('resolution', ['0'=>'HD','1'=>'SD','2'=>'HDCam', '3'=>'Cam','4'=>'Full HD','5'=>'Trailer' ], isset($movie) ?  $movie->resolution : '', ['class'=>'form-control']) !!}
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('thuocphim','Thuộc Phim',[]) !!}
                            {!! Form::select('thuocphim', ['phimle'=>'Phim Lẻ', 'phimbo'=>'Phim Bộ'], isset($movie) ?  $movie->thuocphim : '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Country','Quốc Gia',[]) !!}
                            {!! Form::select('country_id', $country, isset($movie) ?  $movie->country->id : '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Category','Danh Mục Phim',[]) !!}<br/>
                            @foreach($list_cate as $key => $cate)
                                @if(isset($movie))
                                    {!! Form::checkbox('category[]', $cate->id, isset($movie_category) && $movie_category->contains($cate->id) ? true : false)  !!}
                                @else
                                    {!! Form::checkbox('category[]', $cate->id, '')  !!}
                                @endif
                                    {!! Form::label('category', $cate->title) !!}
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('Genre','Thể Loại',[]) !!}<br/>
                            @foreach($list_genre as $key => $gen)
                                @if(isset($movie))
                                    {!! Form::checkbox('genre[]', $gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false)  !!}
                                @else
                                    {!! Form::checkbox('genre[]', $gen->id, '')  !!}
                                @endif
                                    {!! Form::label('genre', $gen->title) !!}
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('Hot','Phim Hot',[]) !!}
                            {!! Form::select('phim_hot', ['1'=>'Hot', '0'=>'Không Hot'], isset($movie) ?  $movie->phim_hot : '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phude','Phụ Đề',[]) !!}
                            {!! Form::select('phude', ['1'=>'Thuyết Minh', '0'=>'Phụ Đề'], isset($movie) ?  $movie->phude : '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Image','Hình Ảnh',[]) !!}
                            {!! Form::file('image', ['class'=>'form-control-file']) !!}
                            @if(isset($movie))
                                @php
                                    $image_check = substr($movie->image,0,5);
                                @endphp
                                @if($image_check=='https')
                                    <img width="20%" src="{{$movie->image}}">
                                    
                                @else
                                    <img width="20%" src="{{asset('uploads/movie/'.$movie->image)}}">
                                @endif
                            @endif
                        </div>
                        
                        @if(!isset($movie))
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
