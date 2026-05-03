<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Service;
use App\Models\Slider;

class SliderService
{
    public function getAllSlidersForApi()
    {
        $today = now()->toDateString();
        $sliders = Slider::where('is_active', true)
            ->where(function ($query) use ($today) {
                $query->WhereDate('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query->WhereDate('end_date', '>=', $today);
            })
            ->latest()
            ->get();
        return $sliders;
    }
    public function getAllSliders($filters = [])
    {
        $today = now()->toDateString();

        $sliders = Slider::query()
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($filters['status'] ?? null, function ($q, $status) use ($today) {
                match ($status) {
                    'active' => $q->where('is_active', true)
                        ->whereDate('start_date', '<=', $today)
                        ->whereDate('end_date', '>=', $today),
                    'scheduled' => $q->whereDate('start_date', '>', $today),
                    'expired' => $q->whereDate('end_date', '<', $today),
                    default => null
                };
            })
            ->latest()
            ->paginate(6);

        $stats = [
            'total' => Slider::count(),
            'live' => Slider::where('is_active', true)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count(),
            'expired' => Slider::whereDate('end_date', '<', $today)->count(),
        ];

        return [
            'sliders' => $sliders,
            'stats' => $stats
        ];
    }

    public function create_edit()
    {
        $categories = Category::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'display_name' => $category->name
            ];
        });
        $services = Service::all()->map(function ($service) {
            return [
                'id' => $service->id,
                'display_name' => $service->title
            ];
        });

        return [
            'categories' => $categories,
            'services' => $services
        ];
    }

    public function storeOrUpdate(array $data, $slider = null)
    {
        $payload = [
            'title'           => $data['title'] ?? null,
            'description'     => $data['description'] ?? null,
            'sliderable_id'   => $data['sliderable_id'] ?? null,
            'sliderable_type' => $data['sliderable_type'] ?? null,
            'start_date'      => $data['start_date'],
            'end_date'        => $data['end_date'],
            'is_active'       => isset($data['is_active']) ? (bool)$data['is_active'] : false,
        ];

        if (!$slider) {
            $slider = Slider::create($payload);
        } else {
            $slider->update($payload);
        }

        if (isset($data['image'])) {
            $slider->clearMediaCollection('slider_images');
            $slider->addMedia($data['image'])->toMediaCollection('slider_images');
        }

        return $slider;
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
    }

    public function destroy(Slider $slider)
    {
        $slider->clearMediaCollection('slider_images');
        $slider->delete();
    }
}
