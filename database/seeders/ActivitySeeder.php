<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['ar' => 'مكتب عقاري', 'en' => 'Real Estate Agency'],
            ['ar' => 'إدارة أملاك وعقارات', 'en' => 'Property Management'],
            ['ar' => 'تثمين ومقايضة عقارية', 'en' => 'Real Estate Appraisal'],
            
            ['ar' => 'مورد لوازم بناء', 'en' => 'Construction Supplier'],
            ['ar' => 'تعهدات هندسية ومعمارية', 'en' => 'Engineering & Architectural Contracting'],
            ['ar' => 'إكساء وتطوير عقاري', 'en' => 'Finishing & Real Estate Development'],
            ['ar' => 'تصميم داخلي وديكور', 'en' => 'Interior Design & Decoration'],
            ['ar' => 'تنسيق حدائق ولاند سكيب', 'en' => 'Landscaping & Gardening'],
            
            ['ar' => 'صيانة عامة وترميم', 'en' => 'General Maintenance & Renovation'],
            ['ar' => 'تمديدات كهربائية وطاقة شمسية', 'en' => 'Electrical & Solar Energy Systems'],
            ['ar' => 'تمديدات صحية وعزل', 'en' => 'Plumbing & Insulation Services'],
            ['ar' => 'دهان وديكورات جدران', 'en' => 'Painting & Wall Decorations'],
            ['ar' => 'نجارة وأعمال خشبية', 'en' => 'Carpentry & Woodwork'],
            ['ar' => 'أعمال حدادة وألمنيوم', 'en' => 'Blacksmithing & Aluminum Work'],
            
            ['ar' => 'نقل وتغليف أثاث', 'en' => 'Furniture Moving & Packaging'],
            ['ar' => 'خدمات تنظيف وتعقيم', 'en' => 'Cleaning & Disinfection Services'],
            ['ar' => 'تركيب وصيانة مصاعد', 'en' => 'Elevator Installation & Maintenance'],
            ['ar' => 'أنظمة أمنية وكاميرات مراقبة', 'en' => 'Security Systems & CCTV'],
            ['ar' => 'تكييف وتبريد وتدفئة', 'en' => 'HVAC & Cooling Systems'],
            ['ar' => 'مكافحة حشرات وقوارض', 'en' => 'Pest Control Services'],
        ];

        foreach ($activities as $name) {
            $activity = Activity::create([
                'name' => $name,
            ]);

            try {
                $bgColor = substr(md5($name['en']), 0, 6); 
                $url = "https://ui-avatars.com/api/?name=" . urlencode($name['en']) . "&background=$bgColor&color=fff&size=128";
                
                $activity->addMediaFromUrl($url)
                    ->toMediaCollection('icons');
            } catch (\Exception $e) {
                dump("Could not add media for activity: " . $name['en']);
            }
        }
    }
}