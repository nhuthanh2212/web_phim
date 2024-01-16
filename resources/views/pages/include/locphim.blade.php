
<form action="{{route('loc-phim')}}" method="GET">
                           <style type="text/css">
                              .stylish_filter{
                                 border: 0;
                                 background: #12171b;
                                 color: #fff;
                              }
                              .btn-filter{
                                border: 0 #b2b7bb;
                                background: #12171b;
                                color: #fff;
                                padding: 9px;
                              }
                           </style>
                           <div class="col-md-2">
                              <div class="form-group">
                                  
                                  <select class="form-control stylish_filter" name="order" id="exampleFormControlSelect1">
                                    <option value="">-Sắp Xếp-</option>
                                    <option value="ngaytao">Ngày Đăng Mới Nhất</option>
                                    <option value="year">Năm Sản Xuất</option>
                                    <option value="title">Tên Phim</option>
                                    <option value="topview">Lượt Xem</option>
                                    
                                  </select>
                                </div>
                             </div>
                             <div class="col-md-3">
                              <div class="form-group">
                                  
                                  <select class="form-control stylish_filter" name="genre" id="exampleFormControlSelect1">
                                    <option value="">-Thể Loại-</option>
                                     @foreach($genre_home as $key => $gen_filter)
                                    <option {{ (isset($_GET['genre']) && $_GET['genre']==$gen_filter->id) ? 'selected' : '' }} value="{{$gen_filter->id}}">{{$gen_filter->title}}</option>
                                    @endforeach
                                  </select>
                                </div>
                             </div>
                             <div class="col-md-3">
                              <div class="form-group">
                                 
                                  <select class="form-control stylish_filter" name="country" id="exampleFormControlSelect1">
                                    <option value="">-Quốc Gia-</option>
                                    @foreach($country_home as $key => $coun_filter)
                                    <option {{ (isset($_GET['country']) && $_GET['country']==$coun_filter->id) ? 'selected' : '' }} value="{{$coun_filter->id}}">{{$coun_filter->title}}</option>
                                    @endforeach
                                  </select>
                                </div>
                             </div>
                             <div class="col-md-3">
                              <div class="form-group">
                                  @php 
                                    if(isset($_GET['year_locphim'])){
                                       $year = $_GET['year_locphim'];
                                    }
                                    else{
                                      $year = null;
                                    }

                                  @endphp
                                  {!! Form::selectYear('year_locphim',2010,2025,$year,['class'=>'form-control stylish_filter','placeholder'=>'--Năm Phim--']) !!}
                                </div>
                             </div>
                              <div class="col-md-1"> 
                                 <input type="submit" class="btn btn-sm btn-default btn-filter"  value="Lọc Phim">
                              </div>
</form>
