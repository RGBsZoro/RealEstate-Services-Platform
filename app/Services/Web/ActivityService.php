<?php

namespace App\Services\Web;

use App\Models\Activity;

class ActivityService
{
    public function store(array $data)
    {
        $activity = Activity::create(['name' => $data['name']]);
        $activity->addMedia($data['image'])->toMediaCollection('activities');
    }

    public function update(Activity $activity, array $data)
    {
        $activity->update(['name' => $data['name']]);
        $activity->clearMediaCollection('activities');
        $activity->addMedia($data['image'])->toMediaCollection('activities');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
    }
}
