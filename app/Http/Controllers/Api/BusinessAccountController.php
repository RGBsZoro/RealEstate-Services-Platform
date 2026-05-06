<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBusinessAccountStep1Request;
use App\Http\Requests\Api\StoreBusinessAccountStep2Request;
use App\Http\Requests\Api\StoreBusinessAccountStep3Request;
use App\Http\Requests\Api\StoreBusinessAccountStep4Request;
use App\Http\Requests\Api\UpdateBusinessAccountRequest;
use App\Http\Resources\BusinessAccountDetailsResource;
use App\Http\Resources\BusinessAccountResource;
use App\Models\BusinessAccount;
use App\Services\Api\BusinessAccountService;
use Illuminate\Http\Request;

class BusinessAccountController extends Controller
{
    public function __construct(protected BusinessAccountService $businessAccount) {}

    public function step1(StoreBusinessAccountStep1Request $request)
    {
        $this->businessAccount->step1($request->validated());
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

    public function index()
    {
        $accounts = $this->businessAccount->getMyAccounts();
        return successResponse(BusinessAccountResource::collection($accounts)->response()->getData(true));
    }

    public function show(BusinessAccount $businessAccount)
    {
        $account = $this->businessAccount->getAccountDetails($businessAccount);
        return successResponse(BusinessAccountDetailsResource::make($account));
    }

    public function update(UpdateBusinessAccountRequest $request, BusinessAccount $businessAccount)
    {
        $updatedAccount = $this->businessAccount->updateAccount($businessAccount, $request->validated());
        return successResponse(BusinessAccountDetailsResource::make($updatedAccount));
    }

    public function deleteMedia(BusinessAccount $businessAccount, $mediaId)
    {
        $this->businessAccount->deleteMedia($businessAccount, $mediaId);

        return successResponse();
    }

    public function destroy(BusinessAccount $businessAccount)
    {
        $this->businessAccount->deleteAccount($businessAccount);
        return successResponse();
    }
}
