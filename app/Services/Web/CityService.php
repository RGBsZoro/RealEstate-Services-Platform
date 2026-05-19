<?php

namespace App\Services\Web;

use App\Models\BusinessAccount;
use App\Models\City;

class CityService
{
  public function index(array $data)
  {
    $query = City::withCount('businessAccounts');


    if (!empty($data['search'])) {
      $search = $data['search'];
      $query->where(function ($q) use ($search) {
        $q->where('name->en', 'like', "%{$search}%")
          ->orWhere('name->ar', 'like', "%{$search}%");
      });
    }

    $stats = [
      'total_cities' => (clone $query)->count(),
      'total_radius' => (clone $query)->sum('radius'),
      'total_accounts' => cache()->remember('business-accounts', 3600, fn() => BusinessAccount::count()),
    ];

    $cities = $query->latest()->paginate(10);

    return ['cities' => $cities, 'stats' => $stats];
  }

  public function store(array $data)
  {
    City::create([
      'name' => $data['name'],
      'longitude' => $data['longitude'],
      'latitude' => $data['latitude'],
      'radius' => $data['radius'],
      'is_active' => $data['is_active'] ?? true,
    ]);
  }

  public function update(array $data, City $city)
  {
    $city->update([
      'name' => $data['name'],
      'longitude' => $data['longitude'],
      'latitude' => $data['latitude'],
      'radius' => $data['radius'],
      'is_active' => $data['is_active'],
    ]);
  }

  public function destroy(City $city)
  {
    $city->delete();
  }
}
