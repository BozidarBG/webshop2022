<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=['Accessories', 'Gifts', 'Beauty', 'Decor', 'Electronics', 'Luxury', 'Books', 'Magazines', 'Entertainment'];
        foreach($categories as $cat){
            $category=new Category();
            $category->name=$cat;
            $category->slug=Str::slug($cat);
            $category->save();
        }
    }
}
