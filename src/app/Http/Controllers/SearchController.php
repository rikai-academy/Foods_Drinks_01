<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Categories;
use App\Models\Tag;
use App\Models\TagView;
use App\Services\SearchProductService;
use Illuminate\Http\Request;
use App\Models\CategoryType;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    protected $searchProduct;
    public function __construct(SearchProductService $searchProduct)
    {
        $this->searchProduct = $searchProduct;
    }

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
        $keyword        = $request->get('keyword');
        # Check keyword empty
        if (empty($keyword) && empty($request->get('slug'))) {
            return abort(404);
        }
        # Check using ajax
        if ($request->ajax()) {
            $param = $request->only('category', 'sortCategory', 'sortPrice',
                'minPrice', 'maxPrice', 'rating', 'slug', 'keyword');
            return $this->searchProduct->search($param, $numberPaginate);
        }
        # Search Product 
        # Note: where('status', Status::ACTIVE) is function constraint of Scout
        $products = Product::search($keyword)->where('status', Status::ACTIVE)->paginate($numberPaginate);

        # Search by Tag
        $firstKeyword = substr($keyword, 0, 1);
        $products = $this->searchProduct->getProductByTag($firstKeyword, $keyword);

        # Search Product
        if (!$products) $products = Product::searchName($keyword)->paginate($numberPaginate);

        return view('web.search-products.search-products', compact(['products', 'param']));
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
        $productsBackup = $this->getProductBySubCategory($slug);

        if ($products || $productsBackup)
        {
            // Set param
            $param = ['category' => $products->id, 'sortCategory' => 0, 'sortPrice' => 0,
                'minPrice' => 0, 'maxPrice' => 0, 'rating' => 0];

            // Get Products
            if ($productsBackup) {
                $products = $productsBackup->paginate(21);
            } else {
                $products = $products->products()->conditionProduct()->orderBy('products.updated_at', 'DESC')->paginate(21);
            }

            return view('web.search-products.search-products')->with([
                'products' => $products, 'param' => $param, 'keyword' => '',
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
            $products = $products->products()->conditionProduct()->orderBy('products.updated_at', 'DESC')->paginate(21);

            return view('web.search-products.search-products')->with([
                'products' => $products, 'param' => $param, 'keyword' => '',
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

    /**
     * Get Products by Category sub id.
     *
     * @param $slug
     * @return array
     */
    private function getProductBySubCategory($slug)
    {
        $categoryId = CategoryType::slug($slug)->first()->id;
        $products = Product::bySubCategory($categoryId);
        return $products;
    }
}
