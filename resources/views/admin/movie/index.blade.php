@extends('layouts.app')

@section('content')

<div class="modal" id="videoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="video_title"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="video_desc"></p>
        <p id="video_link"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Liệt Kê Phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('movie.create')}}" class="btn btn-danger">Thêm Phim</a>
                    <a href="{{route('leech-movie')}}" class="btn btn-warning">Leech Phim</a>
                    <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">ID</th>
                                <th scope="col">Tiêu Đề</th>
                                
                                <th scope="col">Tên Tiếng Anh</th>
                                <th scope="col">Từ Khóa</th>
                                <th scope="col">Thời Lượng Phim</th>
                                <!-- <th scope="col">Description</th> -->
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Thuộc Phim</th>

                                <th scope="col">Danh Mục</th>
                                <th scope="col">Quốc Gia</th>
                                <th scope="col">Thể Loại</th>

                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Phim Hot</th>
                                <th scope="col">Phụ Đề</th>
                                <th scope="col">Định Dạng</th>
                                <th scope="col">Ngày Tạo</th>
                                <th scope="col">Ngày Cập Nhật</th>
                                <th scope="col">Năm Phim</th>
                                <th scope="col">Top Views</th>
                                <th scope="col">Season</th>
                                <th scope="col">Số Tập</th>
                                <th scope="col">Tập Phim</th>
                                <th scope="col">Quản Lý</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($list as $key => $cate)
                            <tr>
                                <th scope="row">{{$key}}</th>
                                <td>{{$cate->id}}</td>
                                <td>{{$cate->title}}</td>
                                
                                <td>{{$cate->name_eng}}</td>
                                <td>
                                    @if($cate->tags!=NULL)
                                        @if(strlen($cate->tags)>150)
                                            @php
                                                $tags = substr($cate->tags,0,100);
                                                echo $tags.'......'
                                            @endphp
                                            {{substr($cate->tags,0,50)}}...
                                        @endif
                                    @else
                                        Chưa có Từ Khóa
                                    @endif

                                </td>
                                 <td>{{$cate->thoiluong}}</td>
                                <!-- <td>{{$cate->description}}</td> -->
                                <td>
                                    @php
                                        $image_check = substr($cate->image,0,5);
                                    @endphp
                                    @if($image_check=='https')
                                        <img width="100" src="{{$cate->image}}">
                                    
                                    @else
                                         <img width="100" src="{{asset('uploads/movie/'.$cate->image)}}">
                                        <input type="file" id="file-{{$cate->id}}" data-movie_id="{{$cate->id}}" class="form-control-file file_image" accept="image/*" >
                                        <span id="success_image" ></span>   
                                    
                                    @endif
                                </td>
                                
                                <td>
                                    <!-- @if($cate->thuocphim=='phimle')
                                        Phim Lẻ
                                    @else
                                        Phim Bộ
                                    @endif -->
                                    <select id="{{$cate->id}}" class="thuocphim_choose">
                                        @if($cate->thuocphim=='phimle')
                                            <option value="phimbo">Phim Bộ</option>
                                            <option selected value="phimle">Phim Lẻ</option>
                                        @else
                                            <option selected value="phimbo">Phim Bộ</option>
                                            <option value="phimle">Phim Lẻ</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <!-- {{$cate->category->title}} -->
                                    <!-- {!! Form::select('category_id', $category, isset($cate) ?  $cate->category->id : '', ['class'=>'category_choose', 'id'=>$cate->id]) !!} -->
                                    @foreach($cate->movie_category as $catego)
                                    <span class="badge badge-dark">{{$catego->title}}</span>
                                    @endforeach
                                    
                                </td>
                                 <td>
                                    <!-- {{$cate->country->title}} -->
                                    {!! Form::select('country_id', $country, isset($cate) ?  $cate->country->id : '', ['class'=>'country_choose', 'id'=>$cate->id]) !!}


                                </td>
                                
                                <td>
                                    @foreach($cate->movie_genre as $gen)
                                    <span class="badge badge-dark">{{$gen->title}}</span>
                                    @endforeach
                                </td>
                                    
                                <td>
                                    <!-- @if($cate->status == 1)
                                      Hiển Thị
                                    @else
                                      Không Hiển Thị
                                    @endif -->
                                    <select id="{{$cate->id}}" class="trangthai_choose">
                                        @if($cate->status==0)
                                            <option value="1">Hiển Thị</option>
                                            <option selected value="0">Không Hiển Thị</option>
                                        @else
                                            <option selected value="1">Hiển Thị</option>
                                            <option value="0">Không Hiển Thị</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                   <!--  @if($cate->phim_hot == 1)
                                      Hot
                                    @else
                                      Không Hot
                                    @endif -->
                                    <select id="{{$cate->id}}" class="phimhot_choose ">
                                        @if($cate->phim_hot==0)
                                            <option value="1">Hot</option>
                                            <option selected value="0"> Không Hot</option>
                                        @else
                                            <option selected value="1">Hot</option>
                                            <option value="0"> Không Hot</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <!-- @if($cate->phude == 0)
                                        Phụ Đề
                                    @else
                                        Thuyết Minh
                                    @endif -->
                                    <select id="{{$cate->id}}" class="phude_choose">
                                        @if($cate->phude==0)
                                            <option value="1">Thuyết Minh</option>
                                            <option selected value="0">Phụ Đề</option>
                                        @else
                                            <option selected value="1">Thuyết Minh</option>
                                            <option value="0">Phụ Đề</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <!-- @if($cate->resolution == 0)
                                        HD
                                    @elseif($cate->resolution == 1)
                                        SD
                                    @elseif($cate->resolution == 2)
                                        HDCam
                                    @elseif($cate->resolution == 3)
                                        Cam
                                    @elseif($cate->resolution == 4)
                                        Full HD
                                    
                                    @else
                                        Trailer
                                    @endif -->
                                    @php 
                                        $options = array('0'=>'HD','1'=>'SD','2'=>'HDCam','3'=>'Cam','4'=>'FullHD','5'=>'Trailer');
                                    @endphp
                                    <select id="{{$cate->id}}" class="dinhdang_choose">
                                        @foreach($options as $key => $resolution)

                                            <option {{$cate->resolution==$key ? 'selected' : '' }} value="{{$key}}">{{$resolution}}</option>
                                        @endforeach
                                    </select>

                                </td>
                                <td>{{$cate->ngaytao}}</td>
                                <td>{{$cate->ngaycapnhat}}</td>
                                <td>
                                    <form method="POST">
                                        @csrf
                                    {!! Form::selectYear('year',2000,2023, isset($cate->year) ? $cate->year : '',['class'=>'select-year','id'=>$cate->id,'placeholder'=>"--Năm Phim--"]) !!}
                                    </form>
                                </td>
                                <td>
                                    {!! Form::select('topview', ['0'=>'Ngày', '1'=>'Tuần', '2'=>'Tháng'], isset($cate->topview) ? $cate->topview : '', ['class'=>'select-topview', 'id'=>$cate->id,'placeholder'=>"--- View ---"]) !!}
                                </td>
                                <td>
                                    <form method="POST">
                                        @csrf
                                        

                                    {!! Form::selectRange('season', 0, 20,  isset($cate->season) ? $cate->season : '', ['class'=>'select-season','id'=>$cate->id]) !!}
                                </form>
                                </td>
                                <td>{{$cate->episode_count}}/{{$cate->sotap}}</td>
                                <td><a href="{{route('add-episode',[$cate->id])}}" class="btn btn-primary btn-sm">Thêm Tập Phim</a>
                                    @foreach($cate->episode as $key => $epis)
                                        <a class="show_video" data-movie_video_id="{{$epis->movie_id}}" data-video_episode="{{$epis->episode}}"  style="color: #fff; cursor: pointer;">
                                            <span class="badge badge-dark">{{$epis->episode}}</span>
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                      {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn Muốn Xóa Phim Này?")']) !!}
                                        {!! Form::submit('DELETE',['class'=>'btn btn-danger']) !!}
                                      {!! Form::close() !!}
                                      <a href="{{route('movie.edit',$cate->id)}}" class="btn btn-warning">Update</a>
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
@endsection
