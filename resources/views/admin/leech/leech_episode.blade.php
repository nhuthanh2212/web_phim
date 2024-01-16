@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Liệt Kê Tập Phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
               
                
                <table class="table table-striped" >
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên Phim</th>

                            <th scope="col">Đường Dẫn</th>
                            <th scope="col">Số Tập</th>
                            <th scope="col">Tập Phim</th>
                            <th scope="col">Link Embed</th>
                            <th scope="col">Link M3u8</th>
                            
                            <th scope="col">Quản Lý</th>
                        </tr>
                      </thead>
                      <tbody >
                        @foreach($resp['episodes'] as $key => $res)
                        <tr >
                            <th scope="row">{{$key}}</th>
                           
                            <td>{{$resp['movie']['name']}}</td>
                            <td>{{$resp['movie']['slug']}}</td>
                            <td>{{$resp['movie']['episode_total']}}</td>
                            <td>
                                 @foreach($res['server_data'] as $key => $epis)
                                    <ul>
                                        <li>Tập {{$epis['name']}}
                                            
                                        </li>
                                        
                                    </ul>

                                @endforeach
                            </td>
                            <td>
                                @foreach($res['server_data'] as $key => $server_1)
                                    <ul>
                                        <li>
                                            <input type="text" class="form-control"  value="{{$server_1['link_embed']}}">
                                        </li>
                                        
                                    </ul>

                                @endforeach

                            </td>
                          
                            <td>
                                @foreach($res['server_data'] as $key => $server_2)
                                    <ul>
                                        <li>
                                            <input type="text" class="form-control"  value="{{$server_2['link_m3u8']}}">
                                        </li>
                                        
                                    </ul>

                                @endforeach
                            </td>
                            <td>
                                <form method="POST" action="{{route('leech-episode-store',[$resp['movie']['slug']])}}">
                                    @csrf
                                    <input type="submit" name="" value="Thêm Tập Phim" class="btn btn-success btn-sm">
                                </form>
                                <form method="POST" action="">
                                    @csrf
                                    <input type="submit" name="" value="Xóa Tập Phim" class="btn btn-danger btn-sm">
                                </form>
                                <a href="{{route('leech-movie')}}" class="btn btn-warning btn-sm">Quay Lại</a>
                            </td>
                          
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
