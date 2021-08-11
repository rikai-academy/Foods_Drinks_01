<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\SaveProfileRequest;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
class ProfileController extends Controller
{
    public function index(){
        return view('profile.index');
    }

    public function save_infor(SaveProfileRequest $request){
        try{
            User::find(Auth::user()->id)->update($request->all());
            toast(__('custom.save_profile_success'),'success');
        }
        catch(Exception $ex){
            toast(__('custom.save_profile_error'),'error');
        }
        return redirect()->back();
    }

}
