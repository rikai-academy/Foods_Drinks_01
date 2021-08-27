<?php
use App\Models\Categories;
use App\Enums\CategoryTypes;
use App\Models\CategoryType;

    if (!function_exists('getCategoriesByType')) {
          function getCategoriesByType($type)
        {
            if ($type === CategoryTypes::FOOD)
            {
                return Categories::bySubCategories(CategoryTypes::FOOD)->get()->sortBy('cardinal_numbers');
            }
            return Categories::bySubCategories(CategoryTypes::DRINK)->get()->sortBy('cardinal_numbers');
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
