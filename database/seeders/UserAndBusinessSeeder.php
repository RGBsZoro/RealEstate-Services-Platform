<?php

namespace Database\Seeders;

use App\Enum\StatusEnum;
use App\Models\Activity;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserAndBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حسابات المطورين الأساسية الثابتة
        User::firstOrCreate(
            ['phone' => '+963994801706'],
            ['name' => 'Wasem Alhariri', 'password' => 'fcbayern']
        );

        User::firstOrCreate(
            ['phone' => '+963994801708'],
            ['name' => 'Zoro', 'password' => 'fcbayern']
        );

        $activities = Activity::all();
        $cities = City::all();

        if ($activities->isEmpty() || $cities->isEmpty()) {
            $this->command->error('يرجى تشغيل CitySeeder و ActivitySeeder أولاً!');
            return;
        }

        // مصفوفات توليد أسماء أشخاص حقيقية (السوق السوري)
        $firstNames = ['أحمد', 'محمود', 'فادي', 'سامر', 'علي', 'خالد', 'باسل', 'طارق', 'عمر', 'رشا', 'ديما', 'نور', 'ياسر', 'ماهر', 'زين'];
        $lastNames = ['الخطيب', 'العلبي', 'النابلسي', 'الحمصي', 'المصري', 'الراعي', 'الشيخ', 'المنصور', 'الحسين', 'حداد', 'نجار', 'خليل'];

        $detailsTemplates = [
            "نقدم خدمات متكاملة ومتميزة في مجال :activity مع ضمان الجودة والالتزام بالوقت والمواصفات المطلوبة.",
            "خبرة تفوق الـ 10 سنوات في السوق السوري لتقديم كافة حلول :activity بأيدي خبراء ومتخصصين.",
            "مكتب متخصص في :activity، نسعى دائماً لتقديم أفضل الخدمات بأسعار تنافسية تناسب جميع العملاء.",
            "الخيار الأول لك في :activity، خدماتنا تغطي كافة الاحتياجات وبأعلى معايير الكفاءة والمصداقية."
        ];

        $slogans = [
            'جودة وثقة لا حدود لها.',
            'نبتكر الحلول لتسهيل أعمالكم.',
            'خبرتنا في خدمتكم دائماً.',
            'خيارات ذكية لنتائج أفضل.',
            'التميز والسرعة في الأداء.'
        ];

        for ($i = 1; $i <= 30; $i++) { 
            $randomName = collect($firstNames)->random() . ' ' . collect($lastNames)->random();

            $phonePrefix = collect(['094', '095', '096', '093', '098', '099'])->random();
            $phoneNumber = $phonePrefix . rand(1000000, 9999999);

            if (User::where('phone', $phoneNumber)->exists()) {
                continue;
            }

            $user = User::create([
                'name' => $randomName,
                'phone' => $phoneNumber,
                'password' => 'fcbayern',
            ]);

            $numberOfAccounts = rand(0, 3); 

            if ($numberOfAccounts > 0) {
                $userActivities = $activities->random(min($numberOfAccounts, $activities->count()));

                foreach ($userActivities as $activity) {
                    $randomCity = $cities->random();
                    $arActivityName = $activity->getTranslation('name', 'ar');
                    $enActivityName = $activity->getTranslation('name', 'en');

                    $randomDetail = str_replace(':activity', $arActivityName, collect($detailsTemplates)->random());

                    $businessAccount = BusinessAccount::create([
                        'user_id' => $user->id,
                        'activity_id' => $activity->id,
                        'city_id' => $randomCity->id,
                        'license_number' => "LIC-" . strtoupper(bin2hex(random_bytes(4))),
                        'name' => [
                            'ar' => $this->getArabicBusinessName($randomName, $arActivityName),
                            'en' => Str::slug($randomName) . " for " . $enActivityName,
                        ],
                        'details' => $randomDetail,
                        'activities' => collect($slogans)->random(),
                        'latitude' => $randomCity->latitude + (rand(-50, 50) / 1000), 
                        'longitude' => $randomCity->longitude + (rand(-50, 50) / 1000),
                        'status' => collect([StatusEnum::PENDING, StatusEnum::APPROVED, StatusEnum::REJECTED])->random(),
                    ]);

                    $this->addBusinessMedia($businessAccount);
                }
            }
        }
    }

    private function getArabicBusinessName($userName, $activityName)
    {
        $prefixes = ['مؤسسة', 'شركة', 'مكتب', 'مركز', 'مجموعة'];
        $suffixes = ['الحديثة', 'العالمية', 'المتطورة', 'المتخصصة'];

        $prefix = collect($prefixes)->random();

        $style = rand(1, 3);
        if ($style === 1) {
            return "$prefix $userName لخدمات $activityName";
        } elseif ($style === 2) {
            $family = explode(' ', $userName)[1] ?? 'السورية';
            return "$prefix $family لـ $activityName";
        } else {
            $suffix = collect($suffixes)->random();
            return "$prefix $userName ($activityName $suffix)";
        }
    }

    private function addBusinessMedia($account)
    {
        try {
            // نصيحة أداء: الاستدعاء الخارجي في الـ Seeder قد يفشل أو يبطئ العملية.
            // إذا واجهت بطء شديد، يفضل تحميل صورتين وملف pdf يدوياً ووضعهم بمجلد وتكرار نسخهم برمجياً.
            $account->addMediaFromUrl("https://picsum.photos/seed/business_{$account->id}/500/500")
                ->toMediaCollection('images');

            $account->addMediaFromUrl('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf')
                ->toMediaCollection('documents');
        } catch (\Exception $e) {
            // تخطي أخطاء الشبكة في حال انقطاع الاتصال بـ Picsum لتجنب انهيار الـ Seeder كاملأً
        }
    }
}
