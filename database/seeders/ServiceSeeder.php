<?php

namespace Database\Seeders;

use App\Enum\StatusEnum;
use App\Models\BusinessAccount;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessAccounts = BusinessAccount::where('status', StatusEnum::APPROVED)->get();

        $categories = Category::whereNotNull('parent_id')->orWhereDoesntHave('children')->get();

        if ($businessAccounts->isEmpty() || $categories->isEmpty()) {
            $this->command->error('يرجى التأكد من وجود حسابات أعمال مقبولة وتصنيفات أولاً!');
            return;
        }

        foreach ($businessAccounts as $account) {
            $servicesCount = rand(1, 2);

            for ($i = 1; $i <= $servicesCount; $i++) {
                $category = $categories->random();
                $isSale = rand(0, 1);

                $service = Service::create([
                    'business_account_id' => $account->id,
                    'category_id' => $category->id,
                    'title' => "خدمة " . $category->getTranslation('name', 'ar') . " رقم " . $i,
                    'description' => "وصف تفصيلي للخدمة العقارية المقدمة من قبل " . $account->getTranslation('name', 'ar') . ". هذا النص هو نص تجريبي لاختبار نظام الخدمات.",
                    'quantity' => rand(1, 3),
                    'type' => $isSale ? 'sale' : 'rent',
                    'price_syp' => $isSale ? rand(500, 3000) * 1000000 : rand(1, 10) * 1000000,
                    'price_usd' => $isSale ? rand(50000, 250000) : rand(200, 1500),
                    'latitude' => $account->latitude + (rand(-100, 100) / 20000),
                    'longitude' => $account->longitude + (rand(-100, 100) / 20000),
                    'status' => rand(1, 10) > 2 ? StatusEnum::APPROVED : StatusEnum::PENDING,
                ]);

                $this->addServiceMedia($service);

                $this->seedDynamicFieldValues($service, $category);
            }
        }
    }

    private function generateArabicTitle($catName, $index)
    {
        $adjectives = ['مميز', 'فاخر', 'للبيع فوري', 'لقطة', 'مطل على الشارع', 'جاهز للتسليم'];
        return $catName . " " . collect($adjectives)->random() . " (#$index)";
    }

    private function seedDynamicFieldValues($service, $category)
    {
        $fields = $category->allDynamicFields();

        foreach ($fields as $field) {
            $value = '';
            $labelEn = $field->getTranslation('label', 'en');

            switch ($field->type) {
                case 'number':
                    if (Str::contains($labelEn, ['Year', 'Construction'])) $value = rand(2010, 2024);
                    elseif (Str::contains($labelEn, ['Rooms', 'Floors'])) $value = rand(1, 6);
                    else $value = rand(50, 500);
                    break;
                case 'select':
                    $value = collect($field->options)->random();
                    break;
                case 'text':
                    $value = "قيمة تجريبية لـ " . $field->getTranslation('label', 'ar');
                    break;
            }

            $service->fieldValues()->create([
                'dynamic_field_id' => $field->id,
                'value' => $value
            ]);
        }
    }

    private function addServiceMedia($service)
    {
        try {
            $service->addMediaFromUrl('https://picsum.photos/seed/service_main_' . $service->id . '/800/600')
                ->toMediaCollection('main_image_service');

            for ($j = 1; $j <= 3; $j++) {
                $service->addMediaFromUrl('https://picsum.photos/seed/service_gal_' . $service->id . '_' . $j . '/800/600')
                    ->toMediaCollection('gallery_services');
            }
        } catch (\Exception $e) {
        }
    }
}
