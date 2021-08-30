@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<h1 class="mt-4">{{__('custom.statistic_order_products')}}</h1>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <form action="{{ route('statistic.filter_products') }}" method="post">
                    @csrf
                    <label>{{ __('custom.Created at') }}:</label>
                    <input type="date" name="findDayOne" value="<?php echo date('Y-m-d'); ?>">
                    <span>{{ __('custom.to') }}</span>
                    <input type="date" name="findDayTwo" value="<?php echo date('Y-m-d'); ?>">
                    <button type="submit" class="btn btn-primary" title="{{ __('custom.filter') }}">
                        {{ __('custom.filter') }}
                    </button>
                    <a href="{{ route('statistic.index') }}" class="btn btn-warning" title="{{ __('custom.reload') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </form>
            </div>
            <div class="col text-right">
              <button type="submit" class="btn btn-success" id="submit">
                <i class="fas fa-file-excel"></i> {{__('custom.Import Excel')}}
              </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>{{__('custom.column_stt')}}</th>
                        <th>{{__('custom.Product Name')}}</th>
                        <th>{{__('custom.Image')}}</th>
                        <th>{{__('custom.Category')}}</th>
                        <th>{{__('custom.Price')}}</th>
                        <th>{{__('custom.total_quantity')}}</th>
                        <th>{{__('custom.Order Date')}}</th>
                        <th>{{__('custom.Status')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_products as $row)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->products()->first()->name}}</td>
                        <td>
                            <img src="/storage/products/{{ $row->products()->first()->images()->first()->image }}"
                                id="img_product" alt="{{ $row->products()->first()->images()->first()->name }}">
                        </td>
                        <td>{{ $row->products()->first()->categories()->first()->name }}</td>
                        <td>{{ formatPrice($row->products()->first()->price) }}</td>
                        <td>{{ $row->count_products }}</td>
                        <td>{{ checkLanguageWithDay($row->created_at) }}</td>
                        <td>
                            {!! statusProduct($row->products()->first()->status) !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
