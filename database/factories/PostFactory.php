<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->words(3, true);
        $userId = User::all()->random()->id;
        $slug = Str::slug($title.'-'.$userId, '-');
        return [
            'title'=> $title,
            'slug'=> $slug,
            'body'=>fake()->paragraph,
            'user_id'=> $userId,
            'image'=>'image'
        ];
    }
}
