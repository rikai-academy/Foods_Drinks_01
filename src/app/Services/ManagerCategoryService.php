<?php

namespace App\Services;

use App\Models\Categories;
use DB;

class ManagerCategoryService
{
    public function sortIndexCategories ($request) {
        $typeSort = $request->typeSort;
        $categories = Categories::getActive();

        # Select Sort
        if ($typeSort == 1) $categories->sortCategories('name', 'ASC');
        if ($typeSort == 2) $categories->sortCategories('name', 'DESC');
        if ($typeSort == 3) $categories->sortCategories('created_at', 'DESC');
        if ($typeSort == 4) $categories->sortCategories('created_at', 'ASC');
        
        $categories = $categories->get();

        DB::beginTransaction();
        try{
            foreach ($categories as $key => $category) {
                $data = Categories::find($category->id);
                $data->cardinal_numbers = $key + 1;
                $data->save();
            }

            DB::commit();
            return true;
        }
        catch(Exception $ex){
            DB::rollBack();
            return false;
        }
    }
}
