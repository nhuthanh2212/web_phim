@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Liệt Kê User</div>
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
                <div class="table-responsive">
                    <table class="table table-striped" >
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">ID</th>
                                <th scope="col">Tên User</th>
                                 <th scope="col">Email</th>
                                 <!-- <th scope="col">Password</th> -->
                                <th scope="col">Vai Trò Role</th>
                                <th scope="col">Quyền Permissions</th>
                                 <th scope="col">Quản Lý</th>
                            </tr>
                          </thead>
                          <tbody >
                            @foreach($user as $key => $u)
                            <tr >
                              <th scope="row">{{$key}}</th>
                              <td>{{$u->id}}</td>
                              <td>{{$u->name}}</td>
                              <td>{{$u->email}}</td>
                              <!-- <td>{{$u->password}}</td> -->
                              <td>
                                @foreach($u->roles as $key => $role)
                                    {{$role->name}}
                                @endforeach
                                </td>
                              <td>
                                @foreach($role->permissions as $key => $permis)
                                    <span class="badge badge-pill badge-dark">{{$permis->name}}</span>
                                @endforeach
                              </td>
                              <td>
                                @role('Admin')
                                    <a href="{{url('phan-vai-tro/'.$u->id)}}" class="btn btn-danger btn-sm">Phân Vai Trò</a>
                                    <a href="{{url('phan-quyen/'.$u->id)}}" class="btn btn-primary btn-sm">Phân Quyền</a>
                                    <a href="{{url('/impersonate/user/'.$u->id)}}" class="btn btn-warning btn-sm">Chuyển Quyền Nhanh</a>
                                
                                    <a href="{{route('user.edit',$u->id)}}" class="btn btn-success btn-sm">Update</a>
                                    {!! Form::open(['method'=>'DELETE','route'=>['user.destroy',$u->id],'onsubmit'=>'return confirm("Bạn Muốn Xóa User Này?")']) !!}
                                        {!! Form::submit('DELETE',['class'=>'btn btn-info btn-sm']) !!}
                                    {!! Form::close() !!}
                                @endrole
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
