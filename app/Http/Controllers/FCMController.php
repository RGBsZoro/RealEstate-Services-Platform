<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFCMRequest;
use App\Services\FCMService;
use Illuminate\Http\Request;

class FCMController extends Controller
{
  public function __construct(protected FCMService $fcm) {}

  public function store(StoreFCMRequest $request, string $guardName)
  {
    $this->fcm->store($request->validated(), $guardName);

    return successResponse();
  }
}
