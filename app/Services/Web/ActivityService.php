<?php

namespace App\Services\Web;

use App\Models\Activity;

class ActivityService
{
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
