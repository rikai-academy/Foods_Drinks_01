@extends('layouts.admin')
@section('content')
    <div class="my-4" id="highChart"></div>
    <div class="row text-center my-5">
      <div class="col">
        <h5 class="font-weight-lighter">{{ __('custom.registered_person') . ' ' . date('Y') }}</h5>
        <div>
          <canvas id="barChart"></canvas>
        </div>
      </div>
    </div>
@include('includes.admin.charts.admin-home-inc-js')
@stop
