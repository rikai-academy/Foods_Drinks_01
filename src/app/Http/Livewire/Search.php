<?php

namespace App\Http\Livewire;

use App\Enums\Status;
use App\Models\Product;
use Livewire\Component;
use App\Models\User;

class Search extends Component
{
    public $keywordSearch = '';
    public $products ;
    
    public function render()
    {
        if ($this->keywordSearch) 
        {
            # Search Product 
            # Note: where('status', Status::ACTIVE) is function constraint of Scout
            $this->products = Product::search($this->keywordSearch)
                ->where('status', Status::ACTIVE)->take(5)->get();
        }
        else  $this->products = [];
        
        return view('livewire.search');
    }
}
