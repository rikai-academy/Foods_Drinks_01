<?php

namespace Tests\Unit\Views;

use Tests\TestCase;
use App\Models\Categories;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_route_view_category()
    {
        $categories = Categories::factory()->create();
        $this->get('/admin/category')->assertStatus(302);
    }
}
