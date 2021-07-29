@extends('layouts.web')
@section('content')
<div class="container">
    <div class="row"></div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">
                    <h4>{{__('custom.register')}}</h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputAddress">{{__('custom.username')}}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" placeholder="{{__('custom.username')}}" required
                                autocomplete="name" autofocus style="height: 43px;">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputDienThoai">{{__('custom.email')}}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="{{__('custom.email')}}" required
                                autocomplete="email" style="height: 43px;">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">{{__('custom.password')}}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="{{__('custom.password')}}" required autocomplete="new-password"
                                style="height: 43px;">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputDienThoai">{{__('custom.confirm_password')}}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" placeholder="{{__('custom.confirm_password')}}" required
                                autocomplete="new-password" style="height: 43px;">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger"
                                style="width: 100%;margin-top: 20px;height: 43px;">{{__('custom.register')}}</button>
                        </div>
                        <a href="#">{{__('custom.forgot_password')}}</a>
                    </form>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0px;">
                                <button type="submit" class="btn btn-primary"
                                    style="width: 100%;margin-top: 20px;height: 43px;"><i class="fa fa-facebook"
                                        aria-hidden="true"></i> Facebook</button>
                            </div>
                            <div class="col-md-4" style="padding-right: 0px;">
                                <button type="submit" class="btn btn-danger"
                                    style="width: 100%;margin-top: 20px;height: 43px;"><i class="fa fa-google-plus"></i>
                                    Google</button>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"
                                    style="width: 100%;margin-top: 20px;height: 43px;"><i class="fa fa-twitter"
                                        aria-hidden="true"></i> Twitter</button>
                            </div>
                        </div>
                    </div>
                    <p style="text-align: center;">{{__('custom.Do you already have an account')}} <a
                            href="#">{{__('custom.login')}}</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row" style="margin-bottom: 200px;"></div>
</div>
@endsection