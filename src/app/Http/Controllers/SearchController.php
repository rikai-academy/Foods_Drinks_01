<?php

namespace App\Http\Controllers;

use App\Enums\CategoryTypes;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\CategoryType;
use App\Models\Evaluates;
use App\Models\Product;

class SearchController extends Controller
{
    /**
     * Display page and Search Products.
     *
     * @param Request $request
     * @return Response
     */
    public function getSearchProducts(Request $request)
    {
        $param          = [];
        $numberPaginate = 21;
        $keyword        = $request->get('q');
        $products       = Product::searchName($keyword);
        // Check using ajax
        if ($request->ajax()) {
            $param['category']      = $request->get('category');
            $param['sortCategory']  = $request->get('sortCategory');
            $param['sortPrice']     = $request->get('sortPrice');
            $param['minPrice']      = $request->get('minPrice');
            $param['maxPrice']      = $request->get('maxPrice');
            $param['rating']        = $request->get('rating');
            $categorySlug           = $request->get('slug');
            # Filter by Category Type
            if ($categorySlug != "") {
                $products = $this->getProductByCategorySlug($categorySlug);
            } else if ($param['category'] == CategoryTypes::FOOD || $param['category'] == CategoryTypes::DRINK) {
                $products = $this->getProductByCategory($param['category']);
            }
            # Sort Price is the value
            if (($param['minPrice'] != 0 || $param['maxPrice'] != 0) && ($param['minPrice'] < $param['maxPrice'])) {
                $products = $this->getProductByPrice($keyword, $param['category'],
                    $param['minPrice'], $param['maxPrice'], $categorySlug);
            }
            # Sort Alphabet Category Type
            if ($param['sortCategory'] != 0) {
                $products = $this->getProductBySortCategory($products, $param['sortCategory']);
            }
            # Sort Price
            if ($param['sortPrice'] != 0) {
                $products = $this->getProductBySortPrice($products, $param['sortPrice']);
            }
            # Filter Rating
            if ($param['rating'] != 0) {
                $this->getProductByRating($products, $param['rating']);
            }
            # Paginate page
            $products = $products->paginate($numberPaginate);
            if ($categorySlug != "") {
              $param['category'] = $this->getCategoryTypeId($categorySlug);
            }
            return view('web.search-products.search-products', compact('products'))->with('param', $param);
        }
        $products = $products->paginate($numberPaginate); // Paginate page

        return view('web.search-products.search-products')->with([
            'products' => $products,
            'param'     => $param,
        ]);
    }

    /**
     * Get Product by Category Type.
     */
    private function getProductByCategory($categoryId) {
        return CategoryType::find($categoryId)->products()->orderBy('products.created_at', 'DESC');
    }

    /**
     * Get Product by 2 Price.
     */
    private function getProductByPrice($keyword, $category, $minPrice, $maxPrice, $slug){
        if ($slug != "") {
            $product = $this->getProductByCategorySlug($slug);
            return $product->whereBetween('price', [$minPrice, $maxPrice]);
        }
        if ($category) { // Filter by Category
            return CategoryType::find($category)->products()
                ->where('products.name', 'like', '%' . $keyword . '%')
                ->whereBetween('price', [$minPrice, $maxPrice]);
        }
        // Sort Price
        return Product::searchName($keyword)->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Get Product by sort alphabet Category Type.
     */
    private function getProductBySortCategory($products, $sortCategory) {
        if ($sortCategory == CategoryTypes::FOOD) {
            return $products->orderBy('name');
        }
        if ($sortCategory == CategoryTypes::DRINK) {
            return $products->orderBy('name', 'DESC');
        }
        return $products;
    }

    /**
     * Get Product by sort price.
     */
    private function getProductBySortPrice($products, $sortPrice) {
        if ($sortPrice == 1) {
            return $products->orderBy('price');
        }
        if ($sortPrice == 2) {
            return $products->orderBy('price', 'DESC');
        }
        return $products;
    }

    /**
     * Get Product by rating.
     */
    private function getProductByRating($products, $rating) {
        $arrProductId = Evaluates::selectRaw('product_id')->groupBy('product_id')
            ->havingRaw("AVG(rating) >= " . $rating)->get();
        return $products->whereIn('products.id', $arrProductId)->orderBy('price', 'DESC');
    }

    /**
     * Get Product by Category Slug.
     */
    private function getProductByCategorySlug($slug) {
        $products = $this->getProductBySlug($slug);
        return $products->products()->orderBy('products.updated_at', 'DESC');
    }

    /**
     * Display Products in Category Type.
     *
     * @param $slug
     * @return Response
     */
    public function getCategoryType($slug)
    {
        // Find Category Type by slug
        $products = $this->getProductBySlug($slug);
        if ($products)
        {
            // Set param
            $param = ['category' => $products->id, 'sortCategory' => 0, 'sortPrice' => 0,
                'minPrice' => 0, 'maxPrice' => 0, 'rating' => 0];
            // Get Products
            $products = $products->products()->orderBy('products.updated_at', 'DESC')->paginate(21);

            return view('web.search-products.search-products')->with([
                'products' => $products, 'param' => $param, 'q' => '',
            ]);
        }
        return abort(404);
    }

    /**
     * Display Products in Category.
     *
     * @param $slug
     * @return Response
     */
    public function getCategory($slug)
    {
        // Find Category Type by slug
        $products = $this->getProductBySlug($slug);
        if ($products)
        {
            // Set param
            $param = ['category' => $products->category_types_id, 'sortCategory' => 0, 'sortPrice' => 0,
                'minPrice' => 0, 'maxPrice' => 0, 'rating' => 0];
            // Get Products
            $products = $products->products()->orderBy('products.updated_at', 'DESC')->paginate(21);

            return view('web.search-products.search-products')->with([
                'products' => $products, 'param' => $param, 'q' => '',
            ]);
        }
        return abort(404);
    }

    /**
     * Get Products by Category Types or Categories
     *
     * @param $slug
     * @return array
     */
    private function getProductBySlug($slug)
    {
        $products = CategoryType::slug($slug)->first();
        if (!$products)
        {
            $products = Categories::slug($slug)->first();
        }
        return $products;
    }

    # Get Category Type Id
    private function getCategoryTypeId($slug) {
        if ($slug === CategoryTypes::getKey(1)){
            return CategoryTypes::FOOD;
        }
        if ($slug === CategoryTypes::getKey(2)){
            return CategoryTypes::FOOD;
        }
        return Categories::slug($slug)->first()->category_types_id;
    }
}
