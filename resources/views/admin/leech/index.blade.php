@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Liệt Kê Danh Mục</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
               
                
                <table class="table table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">ID</th>

                            <th scope="col">Tên Phim</th>
                            <th scope="col">Tên Chính Thức</th>
                            <th scope="col">Hình Ảnh Phim</th>
                            <th scope="col">Hình Ảnh Poster</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Year</th>

                            
                            <th scope="col">Quản Lý</th>
                        </tr>
                      </thead>
                      <tbody >
                        @foreach($resp['items'] as $key => $res)
                        <tr >
                          <th scope="row">{{$key}}</th>
                          <td>{{$res['_id']}}</td>
                          <td>{{$res['name']}}</td>
                          <td>{{$res['origin_name']}}</td>
                          <td><img src="{{$resp['pathImage'].$res['thumb_url']}}" height="80" width="80"></td>
                          <td><img src="{{$resp['pathImage'].$res['poster_url']}}" height="80" width="80"></td>
                          <td>{{$res['slug']}}</td>
                          <td>{{$res['year']}}</td>
                          <td>
                                <a href="{{route('leech-detail',$res['slug'])}}" class="btn btn-primary btn-sm">Chi Tiết Phim
                                </a>
                                <a href="{{route('leech-episodes',$res['slug'])}}" class="btn btn-warning btn-sm">Tập Phim
                                </a>
                                @php
                                    $moviee = \App\Models\Movie::where('slug',$res['slug'])->first();
                                @endphp
                                @if(!$moviee)
                                <form method="POST" action="{{route('leech-store',$res['slug'])}}">
                                    @csrf
                                    <input type="submit" class="btn btn-success btn-sm" value="Thêm Phim">
                                </form>
                                @else
                                <form method="POST" action="{{route('movie.destroy',$moviee->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger btn-sm" value="Xóa Phim">
                                </form>
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
@endsection
