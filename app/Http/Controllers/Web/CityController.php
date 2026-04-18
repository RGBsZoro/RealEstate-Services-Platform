<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCityRequest;
use App\Http\Requests\Web\UpdateCityRequest;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Services\Web\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityService $city) {}

    public function index(Request $request)
    {
        $result = $this->city->index($request->all());

        return view('dashboard.cities.index', [
            'cities' => $result['cities']->appends($request->query()),
            'stats' => $result['stats']
        ]);
    }

    public function create()
    {
        return view('dashboard.cities.create');
    }

    public function store(StoreCityRequest $request)
    {
        $this->city->store($request->validated());
        return redirect()->route('cities.index');
    }
    public function edit(City $city)
    {
        return view('dashboard.cities.edit', compact('city'));
    }

    public function update(City $city, UpdateCityRequest $request)
    {
        $this->city->update($request->validated(), $city);
        return redirect()->route('cities.index');
    }

    public function destroy(City $city)
    {
        $this->city->destroy($city);
        return redirect()->route('cities.index');
    }
}
