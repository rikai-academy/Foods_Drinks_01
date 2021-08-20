<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\CategoryType;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ImportRequest;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Exports\CategoryExport;
use App\imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
class ManagerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['OBJ_Categories'] = Categories::OrderBy('id', 'desc')->get();
        $data['OBJ_Category_Types'] = CategoryType::all();
        return view('admin.categories.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $OBJ_Category_Types = CategoryType::all();
        return view('admin.categories.add',compact('OBJ_Category_Types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        DB::beginTransaction();
        try{
            $OBJ_Categories = new Categories($request->all());
            $OBJ_Categories->slug = Str::slug($request->name);
            $OBJ_Categories->save();
            alert()->success(__('custom.Notification'),__('custom.Add category successful'));
            DB::commit();
        }
        catch(Exception $ex){
            toast(__('custom.Add category failed'),'error');
            DB::rollBack();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showCategoryTy($id_category_type)
    {
        $data['OBJ_Categories'] = Categories::WhereCategoryType($id_category_type)->OrderBy('id', 'desc')->get();
        $data['OBJ_Category_Types'] = CategoryType::all();
        return view('admin.categories.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_category)
    {
        $getCategoryById = Categories::find($id_category);
        return view('admin.categories.edit',compact('getCategoryById'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id_category)
    {
        DB::beginTransaction();
        try{
            $getCategoryById = Categories::find($id_category);
            $getCategoryById->update($request->all());
            $getCategoryById->slug = Str::slug($request->name);
            $getCategoryById->save();
            alert()->success(__('custom.Notification'),__('custom.Update category successful'));
            DB::commit();
        }
        catch(Exception $ex){
            toast(__('custom.Update category failed'),'error');
            DB::rollBack();
        }
        return redirect('/admin/category');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_category)
    {
        try{
            Categories::destroy($id_category);
            alert()->success(__('custom.Notification'),__('custom.Delete category successful'));
        }
        catch(Exception $ex){
            toast(__('custom.Delete category failed'),'error');
        }
        return redirect()->back();
    }

    public function export() 
    {
        return Excel::download(new CategoryExport, 'category.xlsx');
    }

    public function import(ImportRequest $request) 
    {
        DB::beginTransaction();
        try{
            Excel::import(new CategoryImport,$request->file('file'));
            alert()->success(__('custom.Notification'),__('custom.Import excel successful'));
            DB::commit();
        }
        catch(Exception $ex){
            toast(__('custom.Import excel failed'),'error');
            DB::rollBack();
        }
        return redirect()->back();
    }
}
