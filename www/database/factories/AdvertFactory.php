<?php

namespace Database\Factories;

use App\Models\AdvertCategory;
use App\Models\Regions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdvertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $region = Regions::inRandomOrder()->first();
        /** AdvertCategory $category */
        $category = AdvertCategory::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $time = Carbon::today()->subDays(rand(0, 50));
        $status = rand(1,4);
        if ($status == 3) {
            $expires_at = $time->copy()->addDays(30);
        } else {
            $expires_at = NULL;
        }
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'price' => rand(10,10000),
            'content' => fake()->paragraph(),
            'address' => $region->code . ' ' . $region->name,
            'status' => $status,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'region_id' => $region->id,
            'published_at' => $time,
            'expires_at' => $expires_at
        ];
    }
}
