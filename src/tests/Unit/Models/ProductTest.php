<?php

namespace Tests\Unit\Models;

use App\Models\Evaluates;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Categories;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    public $mockConsoleOutput = false;
    
    public function test_product_be_longs_to_categories()
    {
        $categories = Categories::factory()->create();
        $product = Product::factory()->create(['category_id' => $categories->id]);

        # Check Foreign Key is the same
        $this->assertEquals('category_id', $product->categories()->getForeignKeyName());

        # Check BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $product->categories());
    }
    
    public function test_product_has_many_evaluates()
    {
        $product = Product::factory()->create();
        $evaluates = Evaluates::factory()->create(['product_id' => $product->id]);

        # Check Foreign Key is the same
        $this->assertEquals('product_id', $product->evaluates()->getForeignKeyName());

        # Check HasMany
        $this->assertInstanceOf(HasMany::class, $product->evaluates());
    } 
    
    public function test_product_has_many_images()
    {
        $product = Product::factory()->create();
        $image = Evaluates::factory()->create(['product_id' => $product->id]);

        # Check Foreign Key is the same
        $this->assertEquals('product_id', $product->images()->getForeignKeyName());

        # Check HasMany
        $this->assertInstanceOf(HasMany::class, $product->images());
    }
}
