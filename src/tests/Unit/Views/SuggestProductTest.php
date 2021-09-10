<?php

namespace Tests\Unit\Views;

use Tests\TestCase;

class SuggestProductTest extends TestCase
{
    public function test_create_view()
    {
        $view = $this->withViewErrors([])->view('web.products.suggest-product');
        $view->assertSee('Suggest more food or drink to Admin');
    }
}
