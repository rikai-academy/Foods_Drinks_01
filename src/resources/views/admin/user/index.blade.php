@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<h1 class="mt-4">{{__('custom.list_users')}}</h1>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col text-right">
                <div class="btn-group dropleft">
                    <a href="javascript:void(0)" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> {{__('custom.Export Excel')}}
                    </a>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('user.export_excel', ['type' => 'all']) }}">
                            {{ __('custom.all') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('user.export_excel', ['type' => 'year']) }}">
                            {{ __('custom.this_year') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('user.export_excel', ['type' => 'month']) }}">
                            {{ __('custom.This month') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>{{__('custom.Number In Order')}}</th>
                        <th>{{__('custom.ID User')}}</th>
                        <th>{{__('custom.User Name')}}</th>
                        <th>{{__('custom.Image')}}</th>
                        <th>{{__('custom.Status')}}</th>
                        <th>{{__('custom.Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($OBJ_Users as $OBJ_User)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$OBJ_User->id}}</td>
                            <td>{{$OBJ_User->name}}</td>
                            <td>
                                <img src="/storage/photos/{{$OBJ_User->id}}/avatar/thumbs/user.jpg" alt="" style="width:60px;height: 60px;">
                            </td>
                            <td>
                                {!!checkStatusUser($OBJ_User->status)!!}
                            </td>
                            <td>
                                <a href="{{route('user.show',$OBJ_User->id)}}" class="btn btn-warning"><i class="fa fa-eye "></i></a>
                                <a href="{{route('user.edit',$OBJ_User->id)}}" class="btn btn-primary"><i class="fa fa-edit "></i></a>
                                @if($OBJ_User->status == 1)
                                <button class="btn btn-danger" onclick="getUserById('{{$OBJ_User->id}}')" data-toggle="modal" data-target="#modalBlockUser">
                                    <i class="fa fa-lock"></i>
                                </button>
                                @else
                                <button class="btn btn-success" onclick="getUserById('{{$OBJ_User->id}}')" data-toggle="modal" data-target="#modalActiveUser">
                                    <i class="fa fa-unlock"></i>
                                </button>
                                @endif
                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteUser">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <form action="{{route('user.destroy',$OBJ_User->id)}}" method="post" id="delete">
                                @csrf
                                @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('includes.admin.user.modal-delete')
@include('includes.admin.user.modal-active-block')
@endsection
