<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Categories;
use App\Models\CategoryType;
use App\Http\Controllers\admin\ManagerCategoryController;
use Illuminate\Validation\Rule;
use App\Http\Requests\CategoryRequest;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryController = new ManagerCategoryController();
    }

    public function test_controller_function_index()
    {
        $index = $this->categoryController->index();

        // test get list category and category type not null
        $categorys = Categories::OrderBy('id', 'desc')->get();
        $category_types = CategoryType::all();
        $this->assertNotNull($categorys,$category_types);

        //test return view index
        $this->assertEquals('admin.categories.index', $index->name());
    }

    public function test_controller_function_create()
    {
        $create = $this->categoryController->create();
        //test return view create
        $this->assertEquals('admin.categories.add', $create->name());
    }

    public function test_controller_validate_category_request()
    {
        $this->requestCategory = new CategoryRequest();
        $this->assertEquals([
            'name' => ['required', 'string', 'max:255',Rule::unique('categories')->ignore($this->requestCategory->category)],
        ],
            $this->requestCategory->rules()
        );
    }

    public function test_controller_function_show_categoryType()
    {
        $categories = Categories::factory()->create();

        $category_types = CategoryType::all();
        $this->assertNotNull($category_types);

        $showCategoryTy = $this->categoryController->showCategoryTy($categories->category_types_id);
        $this->assertEquals('admin.categories.index', $showCategoryTy->name());
    }

    public function test_controller_function_edit()
    {
        $categories = Categories::factory()->create();

        $getCategoryById = Categories::find($categories->id);
        $this->assertNotNull($getCategoryById);

        $edit = $this->categoryController->edit($categories->id);
        $this->assertEquals('admin.categories.edit', $edit->name());
    }
}
