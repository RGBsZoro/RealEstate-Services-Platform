<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SliderRequest;
use App\Models\Category;
use App\Models\Service;
use App\Models\Slider;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(protected SliderService $slider) {}

    public function index(Request $request)
    {
        $data = $this->slider->getAllSliders($request->all());

        return view('dashboard.sliders.index', [
            'sliders' => $data['sliders'],
            'stats' => $data['stats']
        ]);
    }

    public function create()
    {
        $data = $this->slider->create_edit();

        return view('dashboard.sliders.create_edit', [
            'categories' => $data['categories'],
            'services' => $data['services']
        ]);
    }

    public function store(SliderRequest $request)
    {
        $this->slider->storeOrUpdate($request->validated());
        return redirect()->route('sliders.index');
    }

    public function edit(Slider $slider)
    {
        $data = $this->slider->create_edit();

        return view('dashboard.sliders.create_edit', [
            'slider' => $slider,
            'categories' => $data['categories'],
            'services' => $data['services']
        ]);
    }

    public function update(SliderRequest $request, Slider $slider)
    {
        $this->slider->storeOrUpdate($request->validated(), $slider);
        return redirect()->route('sliders.index');
    }

    public function toggleStatus(Slider $slider)
    {
        $this->slider->toggleStatus($slider);
        return successResponse();
    }

    public function destroy(Slider $slider)
    {
        $this->slider->destroy($slider);
        return redirect()->route('sliders.index');
    }
}
