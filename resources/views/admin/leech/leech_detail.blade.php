@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Chi Tiết Phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <a href="{{route('leech-movie')}}" class="btn btn-danger">Quay Lại</a>
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">ID</th>
                                <th scope="col">Tên Phim</th>
                                <th scope="col">Tên Chính Thức</th>
                                <th scope="col">Content</th>
                                <th scope="col">Loại</th>
                                <th scope="col">Status</th>
                                <th scope="col">Hình Ảnh Phim</th>
                                <th scope="col">is_copyright</th>
                                <th scope="col">trailer_url</th>
                                <th scope="col">Thời Gian</th>
                                <th scope="col">Episode_current</th>
                                <th scope="col">Episode_total</th>
                                <th scope="col">Quality</th>
                                <th scope="col">Lang</th>
                                <th scope="col">Notify</th>
                                <th scope="col">Showtimes</th>
                                <th scope="col">Slug</th>
                                <th scope="col">year</th>
                                <th scope="col">view</th>
                                <th scope="col">actor</th>
                                <th scope="col">Đạo Diễn</th>
                                <th scope="col">Category</th>
                                <th scope="col">Country</th>
                                <th scope="col">Chiếu Rap</th>
                                <th scope="col">poster_url</th>
                                <th scope="col">sub_docquyen</th> 
                                

                               
                            </tr>
                          </thead>
                          <tbody >
                            @foreach($resp_movie as $key => $resp)
                            <tr >
                              <th scope="row">{{$key}}</th>
                              <td>{{$resp['_id']}}</td>
                              <td>{{$resp['name']}}</td>
                              <td>{{$resp['origin_name']}}</td>
                              <td>{!! $resp['content'] !!}</td>
                              <td>{{$resp['type']}}</td>
                              <td>{{$resp['status']}}</td>
                              <td><img src="{{$resp['thumb_url']}}" height="80" width="80"></td>
                              <td>
                                     @if($resp['is_copyright']==true)
                                        <span class="badge badge-success">Có</span>
                                    @else
                                        <span class="badge badge-danger">Không</span>
                                    @endif
                              </td>
                              <td>{{$resp['trailer_url']}}</td>
                              <td>{{$resp['time']}}</td>
                              <td>{{$resp['episode_current']}}</td>
                              <td>{{$resp['episode_total']}}</td>
                              <td>{{$resp['quality']}}</td>
                              <td>{{$resp['lang']}}</td>
                              <td>{{$resp['notify']}}</td>
                              <td>{{$resp['showtimes']}}</td>
                              <td>{{$resp['slug']}}</td>
                              <td>{{$resp['year']}}</td>
                              <td>{{$resp['view']}}</td>
                              <td>  
                                @foreach($resp['actor'] as $actor)
                                    <span class="badge badge-info">{{$actor}}</span>
                                @endforeach
                                </td>
                                <td>  
                                @foreach($resp['director'] as $director)
                                    <span class="badge badge-info">{{$director}}</span>
                                @endforeach
                                </td>
                                <td>  
                                @foreach($resp['category'] as $category)
                                    <span class="badge badge-info">{{$category['name']}}</span>
                                @endforeach
                                </td>
                                 <td>  
                                @foreach($resp['country'] as $country)
                                    <span class="badge badge-info">{{$country['name']}}</span>
                                @endforeach
                              </td>
                              
                                <td>
                                    
                                    @if($resp['chieurap']==true)
                                        <span class="badge badge-success">Có</span>
                                    @else
                                        <span class="badge badge-danger">Không</span>
                                    @endif

                                </td>
                              <td><img src="{{$resp['poster_url']}}" height="80" width="80"></td>
                                <td>
                                   
                                    @if($resp['sub_docquyen']==true)
                                        <span class="badge badge-success">Có</span>
                                    @else
                                        <span class="badge badge-danger">Không</span>
                                    @endif
                                    
                                </td>
                              
                              
                             
                             
                              
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
