<?php

namespace App\Services;

use App\Enums\CategoryTypes;
use App\Models\Categories;
use App\Models\CategoryType;

class ManagerProductService
{
    public function getCategoriesSort($request)
    {
        if ($request->ajax()) {
            $categoryType = $request->categoryType;
            $typeSort = $request->typeSort;
            $categorySub = $request->categorySub;
            $categories = Categories::sortCategories('created_at', 'DESC');
            $categorySubs = CategoryType::getChildren();

            # Select Category Type
            if (($categoryType == CategoryTypes::FOOD || $categoryType == CategoryTypes::DRINK) && $categorySub == 0)
            {
                $categories = Categories::BySubCategories($categoryType);
                $categorySubs = CategoryType::findById($categoryType)->children();
            }
            # Select Category Type Sub
            else if ($categorySub != 0)
            {
                $categories = CategoryType::findById($categorySub)->categories();
                if ($categoryType != 0) $categorySubs = CategoryType::findById($categoryType)->children();
            }

            # Select Sort
            if ($typeSort == 1) $categories->sortCategories('name', 'ASC');
            if ($typeSort == 2) $categories->sortCategories('name', 'DESC');
            if ($typeSort == 3) $categories->sortCategories('created_at', 'DESC');
            if ($typeSort == 4) $categories->sortCategories('created_at', 'ASC');

            $data['categories'] = $categories->get();
            $data['categorySubs'] = $categorySubs->get();
            $data['categorySubId'] = $categorySub;

            return response()->json($data);
        }
        return response()->json(array());
    }
}
