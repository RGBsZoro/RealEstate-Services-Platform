<?php

namespace App\Services\Web;

use App\Models\City;

class CityService
{
  public function store(array $data)
  {
    City::create([
      'name' => $data['name'],
      'longitude' => $data['longitude'],
      'latitude' => $data['latitude'],
      'radius' => $data['radius']
    ]);
  }

  public function update(array $data, City $city)
  {
    $city->update([
      'name' => $data['name'],
      'longitude' => $data['longitude'],
      'latitude' => $data['latitude'],
      'radius' => $data['radius']
    ]);
  }

  public function destroy(City $city)
  {
    $city->delete();
  }
}
