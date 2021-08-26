<?php
use App\Models\Categories;
use App\Enums\CategoryTypes;
use App\Models\CategoryType;

    if (!function_exists('getCategoriesByType')) {
          function getCategoriesByType($type)
        {
            if ($type === CategoryTypes::FOOD)
            {
                return Categories::CategoryType(CategoryTypes::FOOD)->get();
            }
            return Categories::CategoryType(CategoryTypes::DRINK)->get();
        }
    }

    if (!function_exists('getChildrenCategories')) {
        function getChildrenCategories($type)
        {
            if ($type == CategoryTypes::FOOD)
            {
                return CategoryType::findById(CategoryTypes::FOOD)->children()->get();
            }
            return CategoryType::findById(CategoryTypes::DRINK)->children()->get();
        }
    }
