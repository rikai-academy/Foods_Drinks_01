<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SuggestProductController;
use App\Http\Requests\SuggestProductRequest;
use App\Models\User;
use App\Services\SuggestService;
use Mockery;
use Tests\TestCase;
use Validator;

class SuggestProductTest extends TestCase
{

    public $mockConsoleOutput = false;
    
    public function setUp(): void
    {
        parent::setUp();
        Mockery::close();
        $this->suggestService = Mockery::mock(SuggestService::class);
        $this->suggestController = new SuggestProductController($this->suggestService);
    }
    
    public function test_create_return_view()
    {
        $view = $this->suggestController->create();
        $this->assertEquals('web.products.suggest-product', $view->name());
    }

    /**
     * @dataProvider provideInvalidData
     */
    function test_store_invalid_data(array $data)
    {
        $request = new SuggestProductRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    function makeInvalidData($invalidInputs)
    {
        $validInputs = [
            'name' => 'Nuoc dong chai',
            'category_id' => 3,
            'amount_of' => 5,
            'price' => 10000,
            'content' => 'Nuoc dong chai Nuoc dong chai Nuoc dong chai',
            'images' => 'foodanddrink.jpg',
        ];

        return array_merge($validInputs, $invalidInputs);
    }

    function provideInvalidData()
    {
        return [
            [$this->makeInvalidData(['name' => ''])],
            [$this->makeInvalidData(['category_id' => ''])],
            [$this->makeInvalidData(['amount_of' => ''])],
            [$this->makeInvalidData(['amount_of' => 'string'])],
            [$this->makeInvalidData(['price' => ''])],
            [$this->makeInvalidData(['price' => 'string'])],
            [$this->makeInvalidData(['content' => ''])],
            [$this->makeInvalidData(['images' => ''])],
        ];
    }
}
