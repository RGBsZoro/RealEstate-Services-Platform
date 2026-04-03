<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBusinessAccountStep1Request;
use App\Http\Requests\Api\StoreBusinessAccountStep2Request;
use App\Http\Requests\Api\StoreBusinessAccountStep3Request;
use App\Http\Requests\Api\StoreBusinessAccountStep4Request;
use App\Models\BusinessAccount;
use App\Services\Api\BusinessAccountService;
use Illuminate\Http\Request;

class BusinessAccountController extends Controller
{
    public function __construct(protected BusinessAccountService $businessAccount) {}

    public function store()
    {
        $account = $this->businessAccount->store();
        return successResponse($account);
    }

    public function step1(StoreBusinessAccountStep1Request $request, BusinessAccount $businessAccount)
    {
        $this->businessAccount->step1($request->validated(), $businessAccount);
        return successResponse();
    }

    public function step2(StoreBusinessAccountStep2Request $request, BusinessAccount $businessAccount)
    {
        $this->businessAccount->step2($request->validated(), $businessAccount);
        return successResponse();
    }

    public function step3(StoreBusinessAccountStep3Request $request, BusinessAccount $businessAccount)
    {
        $this->businessAccount->step3($request->validated(), $businessAccount);
        return successResponse();
    }

    public function step4(StoreBusinessAccountStep4Request $request, BusinessAccount $businessAccount)
    {
        $this->businessAccount->step4($request->validated(), $businessAccount);
        return successResponse();
    }
}
