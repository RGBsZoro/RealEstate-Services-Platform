<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBusinessAccountRequest;
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


    public function store(StoreBusinessAccountRequest $request)
    {
        $this->businessAccount->store($request->validated());

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
