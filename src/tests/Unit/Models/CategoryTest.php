<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Categories;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_categories_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('categories', [
                'name', 'category_types_id', 'slug', 'status',
            ])
        );
    }

    public function test_foreign_key_categories()
    {
        $categories = Categories::factory()->create();
        $this->assertEquals('category_types_id',$categories->category_type()->getForeignKeyName());
    }

    public function test_categories_has_many_products()
    {
        $categories = Categories::factory()->create();
        $this->assertInstanceOf(HasMany::class, $categories->products());
    }

    public function test_categories_belongs_to_category_type()
    {
        $categories = Categories::factory()->create();
        $this->assertInstanceOf(BelongsTo::class, $categories->category_type());
    }
}
