<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_role_customer');
    }
    
    public function index(){
        return view('admin.index');
    }
}