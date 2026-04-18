<?php

namespace App\Services\Web;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityService
{
    public function index(array $data)
    {
        $query = Activity::withCount('businessAccounts');

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name->en', 'like', "%{$search}%")
                ->orWhere('name->ar', 'like', "%{$search}%");
            });
        }

        $stats = [
            'total_activities'  => (clone $query)->count(),           
            'active_usage'      => (clone $query)->has('businessAccounts')->count(),
            'total_assignments' => cache()->remember('total_business_assignments', 3600, function() {
                return DB::table('business_accounts')->count();
            }),
        ];

        $activities = $query->orderBy('name->en')->paginate(10);

        return [
            'activities' => $activities,
            'stats'      => $stats
        ];
    }

    public function store(array $data)
    {
        $activity = Activity::create(['name' => $data['name']]);
        $activity->addMedia($data['image'])->toMediaCollection('Activities');
    }

    public function update(Activity $activity, array $data)
    {
        $activity->update(['name' => $data['name']]);

        if (isset($data['image'])) {
            $activity->clearMediaCollection('Activities');
            $activity->addMedia($data['image'])->toMediaCollection('Activities');
        }
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
    }
}
