<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreActivityRequest;
use App\Http\Requests\Web\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\Web\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(protected ActivityService $activity) {}

    public function index()
    {
        $activities = Activity::all();
        return view('dashboard.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('dashboard.activities.create');
    }

    public function store(StoreActivityRequest $request)
    {
        $this->activity->store($request->validated());
        return redirect()->route('activities.index');
    }

    public function edit(Activity $activity)
    {
        return view('dashboard.activities.edit', compact('activity'));
    }

    public function update(Activity $activity, UpdateActivityRequest $request)
    {
        $this->activity->update($activity, $request->validated());
        return redirect()->route('activities.index');
    }

    public function destroy(Activity $activity)
    {
        $this->activity->destroy($activity);
        return redirect()->route('activities.index');
    }
}
