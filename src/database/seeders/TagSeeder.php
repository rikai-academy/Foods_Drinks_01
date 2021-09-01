<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'name' => 'Nước uống có gas',
            'slug' => Str::slug('Nước uống có gas'),
            'number_of_search' => 0,
            'status' => 1
        ]);

        Tag::create([
            'name' => 'Đồ ăn nhanh',
            'slug' => Str::slug('Đồ ăn nhanh'),
            'number_of_search' => 0,
            'status' => 1
        ]);

        Tag::create([
            'name' => 'Bổ sung chất dinh dưỡng',
            'slug' => Str::slug('Bổ sung chất dinh dưỡng'),
            'number_of_search' => 0,
            'status' => 1
        ]);

        Tag::create([
            'name' => 'Đẹp da',
            'slug' => Str::slug('Đẹp da'),
            'number_of_search' => 0,
            'status' => 1
        ]);

        Tag::create([
            'name' => 'Thương hiệu cà phê',
            'slug' => Str::slug('Thương hiệu cà phê'),
            'number_of_search' => 0,
            'status' => 1
        ]);
    }
}
