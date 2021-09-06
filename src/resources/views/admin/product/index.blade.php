@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<h1 class="mt-4">{{__('custom.list_products')}}</h1>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{__('custom.Category group')}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('product.index')}}">{{__('custom.Show all')}}</a>
                                @foreach($OBJ_CategoryTypes as $OBJ_CategoryType)
                                  <li {!! !getChildrenCategories($OBJ_CategoryType->id) ?: "class='dropdown-submenu'"  !!}>
                                    <a class="dropdown-item" href="{{route('show_product_by_CategoryType',['id' =>$OBJ_CategoryType->id ])}}"
                                       tabindex="-1">
                                      {{ checkLanguage($OBJ_CategoryType->name, $OBJ_CategoryType->name_vietnamese) }}
                                    </a>
                                    <ul class="dropdown-menu">
                                      @foreach(getChildrenCategories($OBJ_CategoryType->id) as $row)
                                        <li class="dropdown-item">
                                          <a tabindex="-1" class="text-dark text-decoration-none"
                                             href="{{route('show_product_by_CategoryType',['id' =>$row->id ])}}">
                                            {{ checkLanguage($row->name, $row->name_vietnamese) }}
                                          </a>
                                        </li>
                                      @endforeach
                                    </ul>
                                  </li>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sortCategories">
                                <i class="fas fa-filter"></i> {{__('custom.Category')}}
                            </button>
                            @include('admin.product.index-inc-sort-categories')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <a href="{{route('export_product')}}" class="btn btn-success">{{__('custom.Export Excel')}} <i
                        class="fas fa-file-excel"></i></a>
                <form id="import_product_excel" method="POST" action="{{route('import_product')}}"
                    accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="file" name="file" placeholder="Choose file">
                            </div>
                            @error('file')
                            <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success" id="submit">{{__('custom.Import Excel')}} <i
                                    class="fas fa-file-excel"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <a href="{{route('product.create')}}" class="btn btn-primary"
                    id="btn_add_product">{{__('custom.add_product')}} <i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>{{__('custom.Number In Order')}}</th>
                        <th>{{__('custom.Product Name')}}</th>
                        <th>{{__('custom.Image')}}</th>
                        <th>{{__('custom.Category')}}</th>
                        <th>{{__('custom.Amount Of')}}</th>
                        <th>{{__('custom.Price')}}</th>
                        <th>{{__('custom.Status')}}</th>
                        <th>{{__('custom.Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($OBJ_Products as $OBJ_Product)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$OBJ_Product->name_product ?: $OBJ_Product->name}}</td>
                        <td>
                            <img src="{{asset('/storage/products')}}/{{$OBJ_Product->image ?: $OBJ_Product->images()->first()->image}}" id="img_product">
                        </td>
                        <td>{{$OBJ_Product->name_category ?: $OBJ_Product->categories()->first()->name}}</td>
                        <td>{{$OBJ_Product->amount_of}}</td>
                        <td>{{ formatPrice($OBJ_Product->price) }}</td>
                        <td>
                            {!!statusProduct($OBJ_Product->status_product)!!}
                        </td>
                        <td>
                            {!!checkStatusProduct($OBJ_Product->status_product,$OBJ_Product->id_product)!!}
                            <a href="{{route('product.edit',$OBJ_Product->id_product ?: $OBJ_Product->id)}}" class="btn btn-primary">
                                <i class="fa fa-edit "></i>
                            </a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteProduct">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('product.destroy',$OBJ_Product->id_product ?: $OBJ_Product->id) }}" method="post"
                                id="delete">
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
@include('includes.admin.product.modal-show')
@include('includes.admin.product.modal-hidden')
@include('includes.admin.product.modal-delete')
@include('admin.product.index-inc-js')
@endsection
