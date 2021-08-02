<?php
    // Calculator Rating of Products.
    if (!function_exists('getRatingProduct')) {
        function getRatingProduct($product_id)
        {
            return round(\App\Models\Evaluates::where('product_id', $product_id)->avg('rating'), 1);
        }
    }
