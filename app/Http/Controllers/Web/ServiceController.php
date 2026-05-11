<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateStatusRequest;
use App\Models\Service;
use App\Services\Web\ServiceManagementService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(protected ServiceManagementService $service) {}
    public function index(Request $request)
    {
        $result = $this->service->index($request->all());

        return view('dashboard.services.index', [
            'services' => $result['services']->appends($request->query()),
            'stats'    => $result['stats']
        ]);
    }

    public function show(Service $service)
    {
        return view('dashboard.services.show', compact('service'));
    }

    public function updateStatus(UpdateStatusRequest $request, Service $service)
    {
        $this->service->actions($service, $request->status);

        return redirect()->route('services.index');
    }
}
