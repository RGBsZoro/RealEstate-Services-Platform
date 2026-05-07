<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        $categories = Category::all();

        if ($services->isEmpty() || $categories->isEmpty()) {
            $this->command->error('يرجى التأكد من وجود خدمات وتصنيفات أولاً!');
            return;
        }

        for ($i = 1; $i <= 60; $i++) {
            $isService = rand(0, 1);
            $target = $isService ? $services->random() : $categories->random();

            $slider = Slider::create([
                'title' => [
                    'ar' => "إعلان مميز رقم $i",
                    'en' => "Featured Ad No. $i"
                ],
                'description' => [
                    'ar' => "هذا العرض متاح لفترة محدودة على " . ($isService ? "هذه الخدمة" : "هذا القسم"),
                    'en' => "Limited time offer on this " . ($isService ? "service" : "category")
                ],
                'sliderable_id' => $target->id,
                'sliderable_type' => get_class($target),
                'start_date' => Carbon::now()->subDays(rand(1, 10)),
                'end_date' => Carbon::now()->addDays(rand(10, 30)),
                'is_active' => rand(0, 5) > 0, 
            ]);

            try {
                $slider->addMediaFromUrl('https://picsum.photos/1200/400?random=' . $i)
                    ->toMediaCollection('slider_images');
            } catch (\Exception $e) {
            }
        }
    }
}
