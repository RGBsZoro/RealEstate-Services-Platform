<?php

namespace Database\Seeders;

use App\Enum\ReportStatusEnum;
use App\Models\Service;
use App\Models\ServiceReport;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $services = Service::all();

        if ($users->isEmpty() || $services->isEmpty()) {
            $this->command->error('يرجى التأكد من وجود مستخدمين وخدمات أولاً!');
            return;
        }

        $reasons = [
            'محتوى غير لائق أو مخالف للشروط',
            'معلومات مضللة أو خاطئة عن العقار',
            'السعر المذكور غير حقيقي',
            'الخدمة وهمية أو تم بيع العقار مسبقاً',
            'تكرار الإعلان بشكل مزعج',
            'صورة الإعلان لا تطابق الواقع',
        ];

        for ($i = 1; $i <= 80; $i++) {
            ServiceReport::create([
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'reason' => collect($reasons)->random(),
                'status' => collect([
                    ReportStatusEnum::PENDING,
                    ReportStatusEnum::RESOLVED,
                ])->random(),
            ]);
        }
    }
}
