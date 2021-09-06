@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<h1 class="mt-4">{{__('custom.list_tags')}}</h1>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <form action="{{ route('tag.filter_date') }}" method="post">
                    @csrf
                    <label>{{ __('custom.Created at') }}:</label>
                    <input type="date" name="findDayOne" value="<?php echo date('Y-m-d'); ?>">
                    <span>{{ __('custom.to') }}</span>
                    <input type="date" name="findDayTwo" value="<?php echo date('Y-m-d'); ?>">
                    <button type="submit" class="btn btn-primary" title="{{ __('custom.filter') }}">
                        {{ __('custom.filter') }}
                    </button>
                    <a href="{{ route('tag.index') }}" class="btn btn-warning" title="{{ __('custom.reload') }}">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </form>
            </div>
            <div class="col text-right">
                <div class="row">
                    <div class="col text-right">
                        <div class="btn-group dropleft">
                            <a href="javascript:void(0)" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> {{__('custom.Export Excel')}}
                            </a>
                            <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" 
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('tag.export_excel', ['type' => 'all']) }}">
                                    {{ __('custom.all') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('tag.export_excel', ['type' => 'year']) }}">
                                    {{ __('custom.this_year') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('tag.export_excel', ['type' => 'month']) }}">
                                    {{ __('custom.This month') }}
                                </a>
                            </div>
                        </div>
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
                        <th>{{__('custom.column_stt')}}</th>
                        <th>{{__('custom.tag_en_name')}}</th>
                        <th>{{__('custom.tag_vi_name')}}</th>
                        <th>{{__('custom.tag_count_tags')}}</th>
                        <th>{{__('custom.Created at')}}</th>
                        <th>{{__('custom.Update at')}}</th>
                        <th>{{__('custom.Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>#{{ $tag->en_name }}</td>
                            <td>#{{ $tag->vi_name }}</td>
                            <td>{{ $tag->product_tags()->count() }}</td>
                            <td>{{ checkLanguageWithDay($tag->created_at) }}</td>
                            <td>{{ checkLanguageWithDay($tag->updated_at) }}</td>
                            <td>
                                <div class="row">
                                    <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-primary mx-2">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tag.destroy', $tag->id) }}" id="formDeleteTag" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.tags.index-inc-js')
@endsection
