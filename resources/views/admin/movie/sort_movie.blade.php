@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sắp Xêp Phim</div>
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
                    <style >
                        .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
                        .tieude_phim{
                            font-weight: bold;
                            color: blue;
                            font-size: 18px;
                            text-transform: uppercase;
                        }
                        .box_phim{
                            height: 200px;
                            border: 1px solid #d1d1d1;
                            margin: 3px;
                            font-size: 12px;
                            padding: 5px;
                            text-align: center;
                            background-color: blanchedalmond;
                        }
                        ul#sortable_navbar li{
                            margin: 0 10px;
                        }
                    </style>
                    <nav class="navbar navbar-default">
                      <div class="container-fluid">
                        
                        <ul class="nav navbar-nav cate_position" id="sortable_navbar">
                         
                          @foreach($category as $key => $cate)
                          <li id="{{$cate->id}}" class="ui-state-default"><a title="{{$cate->title}}" href="{{route('category',$cate->slug)}}">{{$cate->title}}</a></li>
                          @endforeach
                        </ul>
                      </div>
                    </nav>

                    @foreach($category_home as $key => $cate_home)
                    <p class="tieude_phim"> {{$cate_home->title}}</p>
                    <div class="row mov_position sortable_movie">
                        @foreach($cate_home->movie->sortBy('position')->take(25) as $key => $mov)
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 box_phim" id="{{$mov->id}}">
                                <figure>
                                    @php
                                        $image_check = substr($mov->image,0,5);
                                    @endphp
                                    @if($image_check=='https')
                                        <img width="100" src="{{$mov->image}}">
                                    
                                    @else
                                        <img width="100" src="{{asset('uploads/movie/'.$mov->image)}}">   
                                    
                                    @endif
                                    </figure>
                                <p class="entry-title">{{$mov->title}}</p>
                            </div>
                         @endforeach
                    </div>
                    @endforeach

                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
