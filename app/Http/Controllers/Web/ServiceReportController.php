<?php

namespace App\Http\Controllers\Web;

use App\Enum\ReportStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\ServiceReport;
use App\ServiceReportService;
use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
    public function __construct(protected ServiceReportService $report) {}

    public function index(Request $request)
    {
        $data = $this->report->index($request->only(['search', 'status']));

        return view('dashboard.reports.index', [
            'reports' => $data['reports'],
            'stats' => $data['stats'],
        ]);
    }

    public function resolve(ServiceReport $report)
    {
        $report->update(['status' => ReportStatusEnum::Resolved]);
        return back();
    }

    public function destroy(ServiceReport $report)
    {
        $report->delete();
        return back();
    }
}
