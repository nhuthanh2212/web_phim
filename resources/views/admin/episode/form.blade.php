@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản Lý Tập Phim</div>
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
                    <a href="{{route('episode.index')}}" class="btn btn-danger">Liệt Kê Danh Sách Tập Phim</a>
                    @if(!isset($episode))
                         {!! Form::open(['route' => 'episode.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!} 
                    @else
                         {!! Form::open(['route' => ['episode.update',$episode->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!} 
                    @endif
                   
                        <div class="form-group">
                            {!! Form::label('movie','Chọn Phim',[]) !!}
                            {!! Form::select('movie_id', ['0'=>'Chọn Phim', 'Tất Cả Các Phim'=>$list_movie], isset($episode) ?  $episode->movie_id : '', ['class'=>'form-control select-episode']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('link','Link Phim',[]) !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...']) !!}
                        </div>
                        
                        @if(isset($episode))
                            <div class="form-group">
                                {!! Form::label('episode','Tập Phim',[]) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control','placeholder'=>'Nhập Dữ Liệu...',isset($episode) ? 'readonly' : '']) !!}
                            </div>
                        @else
                            <div class="form-group">
                            {!! Form::label('episode','Tập Phim',[]) !!}
                                <select name="episode" class="form-control" id="show_movie">
                                   
                                    
                                </select>

                            </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('linkserver','Link Server',[]) !!}
                            {!! Form::select('linkserver', $linkmovie, isset($episode) ? 'selected' : '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active','Trang Thai',[]) !!}
                            {!! Form::select('status', ['1'=>'Hiển Thị', '0'=>'Không Hiển Thị'], isset($episode) ?  $episode->status : '', ['class'=>'form-control']) !!}
                        </div>

                        @if(!isset($episode))
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
