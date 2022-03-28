<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand=rand(8, 40);
        $rand2=rand(1, 20);
        $user=User::find($rand);
        return [
            'name'=>$user->name,
            'email'=>$user->email,
            'subject'=>$this->faker->sentence(10),
            'message'=>$this->faker->paragraph(5),
            'created_at'=>Carbon::now()->subDays($rand2)->subHours($rand2)->addMinutes($rand),
            'updated_at'=>Carbon::now()->subDays($rand2)->subHours($rand2)->addMinutes($rand),
        ];
    }
}
