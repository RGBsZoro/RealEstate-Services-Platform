<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DynamicField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => ['ar' => 'عقارات سكنية', 'en' => 'Residential Real Estate'],
                'icon' => 'https://cdn-icons-png.flaticon.com/512/2544/2544101.png',
                'fields' => [
                    ['label' => ['ar' => 'سنة البناء', 'en' => 'Construction Year'], 'type' => 'number', 'required' => false],
                    ['label' => ['ar' => 'حالة البناء', 'en' => 'Building Status'], 'type' => 'select', 'required' => true, 'options' => ['جديد', 'مستعمل', 'قيد الإنشاء']],
                ],
                'children' => [
                    ['name' => ['ar' => 'شقق', 'en' => 'Apartments'], 'fields' => [
                        ['label' => ['ar' => 'عدد الغرف', 'en' => 'Rooms Count'], 'type' => 'number', 'required' => true],
                        ['label' => ['ar' => 'الطابق', 'en' => 'Floor'], 'type' => 'number', 'required' => true],
                        ['label' => ['ar' => 'يوجد مصعد؟', 'en' => 'Has Elevator?'], 'type' => 'select', 'required' => true, 'options' => ['نعم', 'لا']],
                    ]],
                    ['name' => ['ar' => 'فيلات', 'en' => 'Villas'], 'fields' => [
                        ['label' => ['ar' => 'مساحة الحديقة', 'en' => 'Garden Area'], 'type' => 'text', 'required' => false],
                        ['label' => ['ar' => 'عدد الطوابق', 'en' => 'Floors Count'], 'type' => 'number', 'required' => true],
                        ['label' => ['ar' => 'مسبح خاص؟', 'en' => 'Private Pool?'], 'type' => 'select', 'required' => false, 'options' => ['نعم', 'لا']],
                    ]],
                    ['name' => ['ar' => 'بيوت عربية', 'en' => 'Traditional Houses'], 'fields' => [
                        ['label' => ['ar' => 'عدد الفسحات', 'en' => 'Courtyards Count'], 'type' => 'number', 'required' => false],
                    ]],
                ]
            ],
            [
                'name' => ['ar' => 'عقارات تجارية', 'en' => 'Commercial Real Estate'],
                'icon' => 'https://cdn-icons-png.flaticon.com/512/3592/3592539.png',
                'fields' => [
                    ['label' => ['ar' => 'نوع الملكية', 'en' => 'Ownership Type'], 'type' => 'select', 'required' => true, 'options' => ['طابو أخضر', 'فراغ أسهم', 'حكم محكمة']],
                ],
                'children' => [
                    ['name' => ['ar' => 'مكاتب', 'en' => 'Offices'], 'fields' => [
                        ['label' => ['ar' => 'عدد الحمامات', 'en' => 'Bathrooms'], 'type' => 'number', 'required' => false],
                        ['label' => ['ar' => 'تكييف مركزي؟', 'en' => 'Central AC?'], 'type' => 'select', 'required' => false, 'options' => ['نعم', 'لا']],
                    ]],
                    ['name' => ['ar' => 'محلات ومعارض', 'en' => 'Shops & Showrooms'], 'fields' => [
                        ['label' => ['ar' => 'طول الواجهة', 'en' => 'Frontage Length'], 'type' => 'text', 'required' => true],
                        ['label' => ['ar' => 'يوجد مستودع؟', 'en' => 'Has Warehouse?'], 'type' => 'select', 'required' => false, 'options' => ['نعم', 'لا']],
                    ]],
                ]
            ],
            [
                'name' => ['ar' => 'أراضي', 'en' => 'Lands'],
                'icon' => 'https://cdn-icons-png.flaticon.com/512/2521/2521151.png',
                'fields' => [
                    ['label' => ['ar' => 'الاستخدام', 'en' => 'Usage'], 'type' => 'select', 'required' => true, 'options' => ['زراعي', 'سكني', 'تجاري', 'صناعي']],
                ],
                'children' => [
                    ['name' => ['ar' => 'أراضي زراعية', 'en' => 'Agricultural Lands'], 'fields' => [
                        ['label' => ['ar' => 'نوع الري', 'en' => 'Irrigation Type'], 'type' => 'select', 'required' => false, 'options' => ['بعل', 'بئر', 'نهر']],
                        ['label' => ['ar' => 'يوجد أشجار؟', 'en' => 'Contains Trees?'], 'type' => 'text', 'required' => false],
                    ]],
                ]
            ],
            [
                'name' => ['ar' => 'عقارات صناعية', 'en' => 'Industrial Real Estate'],
                'icon' => 'https://cdn-icons-png.flaticon.com/512/2897/2897780.png',
                'fields' => [],
                'children' => [
                    ['name' => ['ar' => 'مستودعات', 'en' => 'Warehouses'], 'fields' => [
                        ['label' => ['ar' => 'ارتفاع السقف', 'en' => 'Ceiling Height'], 'type' => 'number', 'required' => false],
                        ['label' => ['ar' => 'دخول شاحنات؟', 'en' => 'Truck Entry?'], 'type' => 'select', 'required' => true, 'options' => ['نعم', 'لا']],
                    ]],
                    ['name' => ['ar' => 'مصانع', 'en' => 'Factories'], 'fields' => [
                        ['label' => ['ar' => 'شدة التيار الكهربائي', 'en' => 'Power Capacity'], 'type' => 'text', 'required' => false],
                    ]],
                ]
            ],
            [
                'name' => ['ar' => 'خدمات سياحية', 'en' => 'Tourism Services'],
                'icon' => 'https://cdn-icons-png.flaticon.com/512/2038/2038167.png',
                'fields' => [],
                'children' => [
                    ['name' => ['ar' => 'شاليهات', 'en' => 'Chalets'], 'fields' => [
                        ['label' => ['ar' => 'القرب من البحر', 'en' => 'Distance to Sea'], 'type' => 'text', 'required' => false],
                    ]],
                    ['name' => ['ar' => 'مزارع للاستجمام', 'en' => 'Resort Farms'], 'fields' => [
                        ['label' => ['ar' => 'يوجد ملعب؟', 'en' => 'Has Playground?'], 'type' => 'select', 'required' => false, 'options' => ['نعم', 'لا']],
                    ]],
                ]
            ],
        ];

        foreach ($data as $item) {
            $parent = Category::create([
                'name' => $item['name'],
                'isActive' => true,
                'parent_id' => null
            ]);

            $this->addIcon($parent, $item['icon']);
            $this->createFields($parent, $item['fields']);

            foreach ($item['children'] as $childData) {
                $child = Category::create([
                    'name' => $childData['name'],
                    'isActive' => true,
                    'parent_id' => $parent->id
                ]);
                $this->createFields($child, $childData['fields']);
            }
        }
    }

    private function createFields($category, $fields)
    {
        foreach ($fields as $field) {
            DynamicField::create([
                'category_id' => $category->id,
                'label' => $field['label'],
                'type' => $field['type'],
                'is_required' => $field['is_required'] ?? $field['required'],
                'options' => $field['options'] ?? null,
            ]);
        }
    }

    private function addIcon($model, $url)
    {
        try {
            $model->addMediaFromUrl($url)->toMediaCollection('icons');
        } catch (\Exception $e) {
        }
    }
}