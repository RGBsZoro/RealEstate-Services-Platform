<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Services\Web\BusinessAccountService;
use Illuminate\Http\Request;

class BusinessAccountController extends Controller
{
    public function __construct(protected BusinessAccountService $businessAccount) {}
    public function index(Request $request)
    {
        $result = $this->businessAccount->index($request->all());

        return view('dashboard.business-accounts.index', [
            'business_accounts' => $result['business_accounts']->appends($request->query()),
            'stats'             => $result['stats'],
            'cities'            => $result['cities'],
        ]);
    }

    public function show(BusinessAccount $businessAccount)
    {
        return view('dashboard.business-accounts.show', compact('businessAccount'));
    }

    public function approve(BusinessAccount $businessAccount)
    {
        $this->businessAccount->actions($businessAccount, 'approved');
        return redirect()->route('business-accounts.index');
    }

    public function reject(BusinessAccount $businessAccount)
    {
        $this->businessAccount->actions($businessAccount, 'rejected');
        return redirect()->route('business-accounts.index');
    }
}
