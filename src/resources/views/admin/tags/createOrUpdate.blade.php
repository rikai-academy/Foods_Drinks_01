@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<h1 class="mt-4">{{ checkAction($action) ? __('custom.tag_add') : __('custom.tag_update') }}</h1>
<div class="row mt-4">
    <div class="col-md-6">
        <form {{ checkActionForm($action, $tag->id)}}>
            @csrf
            {{ checkAction($action) ? '' : method_field('PUT') }}
            <input type="hidden" />
            <div class="form-group">
                <label for="inputName">{{__('custom.tag_en_name')}}</label>
                <input type="text" class="form-control" name="en_name" placeholder="{{__('custom.tag_en_name')}}"
                    value="{{ old('en_name', $tag->en_name) }}">
                @error('en_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputName">{{__('custom.tag_vi_name')}}</label>
                <input type="text" class="form-control" name="vi_name" placeholder="{{__('custom.tag_vi_name')}}"
                    value="{{ old('vi_name', $tag->vi_name) }}">
                @error('vi_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    {!! checkAction($action) ? "<i class='far fa-save'></i> " . __('custom.Save') :
                        "<i class='far fa-edit'></i> " . __('custom.Update') !!}
                </button>
                <a href="{{ route('tag.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> {{__('custom.Exit')}}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
