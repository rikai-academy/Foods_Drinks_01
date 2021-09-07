@extends('layouts.admin')
@section('content')
    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col text-left">
                            <h4><i class="far fa-bell"></i> {{ __('custom.notify') }}</h4>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-dark" id="mark-all-notify">
                                {{ __('custom.mark_all_as_read') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="notify">
                    {!! displayNotifyAdmin() !!}
                </div>
            </div>
        </div>
    </div>
@include('admin.notify.inc-js')
@stop
