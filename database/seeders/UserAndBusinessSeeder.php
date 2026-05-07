<?php

namespace Database\Seeders;

use App\Enum\StatusEnum;
use App\Models\Activity;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAndBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['phone' => '+963994801706'],
            [
                'name' => 'wasem',
                'password' => 'fcbayern'
            ]
        );

        User::firstOrCreate(
            ['phone' => '+963994801708'],
            [
                'name' => 'zoro',
                'password' => 'fcbayern'
            ]
        );

        $activities = Activity::all();
        $cities = City::all();

        if ($activities->isEmpty() || $cities->isEmpty()) {
            $this->command->error('يرجى تشغيل CitySeeder و ActivitySeeder أولاً!');
            return;
        }

        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name' => "المستخدم التجريبي $i",
                'phone' => "09" . rand(11111111, 99999999),
                'password' => 'fcbayern',
            ]);

            $numberOfAccounts = rand(0, 4);

            if ($numberOfAccounts > 0) {
                $userActivities = $activities->random(min($numberOfAccounts, $activities->count()));

                foreach ($userActivities as $activity) {
                    $randomCity = $cities->random();

                    $businessAccount = BusinessAccount::create([
                        'user_id' => $user->id,
                        'activity_id' => $activity->id,
                        'city_id' => $randomCity->id,
                        'license_number' => "LIC-" . strtoupper(bin2hex(random_bytes(4))),
                        'name' => [
                            'ar' => $this->getArabicBusinessName($user->name, $activity->getTranslation('name', 'ar')),
                            'en' => $user->name . " " . $activity->getTranslation('name', 'en') . " Services",
                        ],
                        'details' => "خدمات احترافية مقدمة من قبل " . $user->name . " في مجال " . $activity->getTranslation('name', 'ar') . ". خبرة طويلة ومصداقية عالية في السوق السوري.",

                        'latitude' => $randomCity->latitude + (rand(-100, 100) / 1000),
                        'longitude' => $randomCity->longitude + (rand(-100, 100) / 1000),

                        'status' => collect([StatusEnum::PENDING, StatusEnum::APPROVED, StatusEnum::REJECTED])->random(),
                        'current_step' => null,
                    ]);

                    $this->addBusinessMedia($businessAccount, $i);
                }
            }
        }
    }

    private function getArabicBusinessName($userName, $activityName)
    {
        $prefixes = ['مؤسسة', 'شركة', 'مكتب', 'مجموعة'];
        $prefix = collect($prefixes)->random();
        return "$prefix $userName لـ $activityName";
    }

    private function addBusinessMedia($account, $index)
    {
        try {
            $account->addMediaFromUrl("https://picsum.photos/seed/business_{$account->id}/400/400")
                ->toMediaCollection('images');

            $account->addMediaFromUrl('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf')
                ->toMediaCollection('documents');
        } catch (\Exception $e) {
        }
    }
}
