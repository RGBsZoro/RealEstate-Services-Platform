<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\Web\ServiceManagementService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(protected ServiceManagementService $service) {}
    public function index()
    {
        $services = Service::where('status', '!=', 'draft')->get();
        return view('dashboard.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('dashboard.services.show', compact('service'));
    }

    public function approve(Service $service)
    {
        $this->service->actions($service, 'approved');
        return redirect()->route('services.index');
    }

    public function reject(Service $service)
    {
        $this->service->actions($service, 'rejected');
        return redirect()->route('services.index');
    }
}
