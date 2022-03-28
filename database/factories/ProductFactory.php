<?php

namespace Database\Factories;

use App\Models\Product;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name=ucfirst($this->faker->words(4, true));
        $name_count=Product::where('name', $name)->count();
        $rand=rand(1,500);
        if($name_count==0){
            $slug=Str::slug($name);
        }else {
            $slug = Str::slug($name) . '-' . $name_count;
        }
        $price=rand(100,2500)*1000;
        return [
            'category_id'=>rand(1,9),
            'name'=>$name,
            'slug'=>$slug,
            'acc_code'=>$this->faker->ean13(),
            'short_desc'=>$this->faker->sentence(15),
            'description'=>"<p>".$this->faker->sentence(80)."</p>",
            'regular_price'=>$price,
            'action_price'=>$this->faker->randomElement([0, $price*.9]),
            'stock'=>$this->faker->randomElement([0, rand(1, 100)]),
            'published'=>$this->faker->randomElement([true, false]),
            'image'=>null,
            'created_at'=>now()->subMinutes($rand)
        ];
    }
}
