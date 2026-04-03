<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BusinessAccount;
use App\Services\Web\BusinessAccountService;
use Illuminate\Http\Request;

class BusinessAccountController extends Controller
{
    public function __construct(protected BusinessAccountService $businessAccount) {}
    public function index()
    {
        $business_accounts = BusinessAccount::where('status', '!=', 'draft')->get();
        return view('dashboard.business-accounts.index', compact('business_accounts'));
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
