<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CategoryType;
use App\Models\Categories;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\ImportRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ProductService;
use DB;
class ManagerProductController extends Controller
{

    public function index()
    {
        $data['OBJ_Products'] = Product::ProductJoin()->SelectProduct()->orderBy('products.id','desc')->get();
        $data['OBJ_CategoryTypes'] = CategoryType::all();
        return view('admin.product.index',$data);
    }

    public function show($id_product)
    {
        $data['OBJ_Products'] = Product::ProductJoin()->where('products.id',$id_product)->SelectProduct()->get();
        $data['OBJ_CategoryTypes'] = CategoryType::all();
        return view('admin.product.index',$data);
    }

    public function create()
    {
        $OBJ_Categorys = Categories::all();
        return view('admin.product.add-product',compact('OBJ_Categorys'));
    }

    public function store(AddProductRequest $request,ProductService $productService)
    {
        $createProduct = $productService->storeProduct($request);
        if ($createProduct) {
            alert()->success(__('custom.Notification'),__('custom.Add product successful'));
        }
        else {
            toast(__('custom.Add product failure'),'error');
        }
        return redirect()->back();
    }

    public function categoryByIDCategoryType($id_categorytype)
    {
        $data = Categories::where('categories.category_types_id',$id_categorytype)->get();
        return json_encode($data);
    }

    public function productByIDCategory($id_category)
    {
        $data = Product::where('category_id',$id_category)->get();
        return json_encode($data);
    }

    public function showProductByCategory($id_category)
    {
        $data['OBJ_Products'] = Product::ProductJoin()->SelectProductByCategory($id_category)->orderBy('products.id','desc')->get();
        $data['OBJ_CategoryTypes'] = CategoryType::all();
        return view('admin.product.index',$data);
    }

    public function showProductByCategoryType($id_categoryType)
    {
        $data['OBJ_Products'] = CategoryType::CategoryTypeJoin()->SelectProductByCategoryType()->whereCategoryType($id_categoryType)
        ->orderBy('products.id','desc')->get();
        $data['OBJ_CategoryTypes'] = CategoryType::all();
        return view('admin.product.index',$data);
    }

    public function edit($id_product)
    {
        $data['OBJ_Products'] = Product::find($id_product);
        $data['OBJ_Images'] = Image::where('product_id',$id_product)->get();
        return view('admin.product.edit-product',$data);
    }

    public function getProductByID($id_product)
    {
        return json_encode($id_product);
    }

    public function showOrHidden(Request $request, $id_product)
    {
        try{
            $getProductById = Product::find($id_product)->update($request->all());
            if($request->has('btn_show')){
                alert()->success(__('custom.Notification'), __('custom.Show successful product'));
                return redirect()->back();
            }
            alert()->success(__('custom.Notification'), __('custom.Hidden successful product'));
        }
        catch(Exception $ex){
            toast(__('custom.Update status product failure'),'error');
        }
        return redirect()->back();
    }

    public function update(UpdateProductRequest $request,ProductService $productService,$id_product)
    {
        $updateProduct = $productService->updateProduct($request,$id_product);
        if ($updateProduct) {
            alert()->success(__('custom.Notification'),__('custom.Update product successful'));
        }
        else {
            toast(__('custom.Update product failure'),'error');
        }
        return redirect('admin/product');
    }

    public function destroy($id_product)
    {
        DB::beginTransaction();
        try {
            Product::destroy($id_product);
            Image::where('product_id',$id_product)->delete();
            DB::commit();
            alert()->success(__('custom.Notification'),__('custom.Delete product successful'));
        }
        catch(Exception $ex){
            DB::rollBack();
            toast(__('custom.Delete product failure'),'error');
        }
        return redirect()->back();
    }

    public function export(){
        return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function import(ImportRequest $request,ProductService $productService) 
    {
        $importProduct = $productService->importProduct($request);
        if ($importProduct) {
            alert()->success(__('custom.Notification'),__('custom.Import excel successful'));
        }
        else {
            toast(__('custom.Import excel failed'),'error');
        }
        return redirect()->back();
    }
}
