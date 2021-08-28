@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<h1 class="mt-4">{{__('custom.Category list')}}</h1>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <div class="row">
                  <div class="dropdown mr-2">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{__('custom.Category group')}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('category.index')}}">{{__('custom.Show all')}}</a>
                        @foreach($OBJ_Category_Types as $OBJ_Category_Type)
                          <li {!! !getChildrenCategories($OBJ_Category_Type->id) ?: "class='dropdown-submenu'" !!}>
                            <a class="dropdown-item" href="{{route('showCategoryTy',['id' =>$OBJ_Category_Type->id ])}}" tabindex="-1">
                              {{$OBJ_Category_Type->name}}
                            </a>
                            <ul class="dropdown-menu">
                              @foreach(getChildrenCategories($OBJ_Category_Type->id) as $row)
                                <li class="dropdown-item">
                                  <a tabindex="-1" class="text-dark text-decoration-none" href="{{route('showCategoryTy',['id' =>$row->id ])}}">
                                    {{ $row->name }}
                                  </a>
                                </li>
                              @endforeach
                            </ul>
                          </li>
                        @endforeach
                    </div>
                  </div>
                  <a href="{{route('category.create')}}" class="btn btn-primary mr-2" id="btn_add_category">
                    <i class="fa fa-plus"></i> {{__('custom.Add category')}}
                  </a>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showSortCategories">
                    <i class="fas fa-sort"></i> {{ __('custom.sort_display_categories') }}
                  </button>
                  @include('admin.categories.index-inc-show-sort')
                </div>
            </div>
            <div class="col text-right">
                <a href="{{route('export_category')}}" class="btn btn-success">
                  <i class="fas fa-file-excel"></i> {{__('custom.Export Excel')}}
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>{{__('custom.Number In Order')}}</th>
                        <th>{{__('custom.Category Name')}}</th>
                        <th>{{__('custom.Category group')}}</th>
                        <th>{{__('custom.order_of_display')}}</th>
                        <th>{{__('custom.Status')}}</th>
                        <th>{{__('custom.Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($OBJ_Categories as $OBJ_Categorie)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$OBJ_Categorie->name}}</td>
                            <td>{{$OBJ_Categorie->category_type->name}}</td>
                            <td>{{$OBJ_Categorie->cardinal_numbers}}</td>
                            <td>
                                @if($OBJ_Categorie->status == 1)
                                <p class="text-primary">{{__('custom.Show')}}</p>
                                @else
                                <p class="text-danger">{{__('custom.Hidden')}}</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('category.edit',$OBJ_Categorie->id)}}" class="btn btn-primary">
                                    <i class="fa fa-edit "></i>
                                </a>
                                {!!checkStatusCategory($OBJ_Categorie->status,$OBJ_Categorie->id)!!}
                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteCategory">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <form action="{{route('category.destroy',$OBJ_Categorie->id)}}" method="post" id="delete">
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
@include('includes.admin.category.modal-hidden')
@include('includes.admin.category.modal-show')
@include('includes.admin.category.modal-delete')
@endsection
