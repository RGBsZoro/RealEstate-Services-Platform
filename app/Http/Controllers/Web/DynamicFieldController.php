<?php

namespace App\Http\Controllers\Web;

use App\Enum\FieldTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreDynamicFieldRequest;
use App\Http\Requests\Web\UpdateDynamicFieldRequest;
use App\Models\Category;
use App\Models\DynamicField;
use App\Services\Web\DynamicFieldService;
use Illuminate\Http\Request;

class DynamicFieldController extends Controller
{
    public function __construct(protected DynamicFieldService $dynamicField) {}

    public function index(Category $category)
    {
        $dynamicFields = $category->dynamicFields;
        $fieldTypes = FieldTypeEnum::labels();
        return view('dashboard.categories.fields.index', compact('category', 'dynamicFields', 'fieldTypes'));
    }

    public function create(Category $category)
    {
        $fieldTypes = FieldTypeEnum::labels();
        return view('dashboard.categories.fields.create', compact('category', 'fieldTypes'));
    }

    public function store(StoreDynamicFieldRequest $request, Category $category)
    {
        $this->dynamicField->store($request->validated(), $category);

        return redirect()->route('categories.fields.index', $category->id);
    }

    public function edit(DynamicField $dynamicField, Category $category)
    {
        $fieldTypes = FieldTypeEnum::labels();
        $optionsString = $dynamicField->options ? implode(', ', $dynamicField->options) : '';

        return view('dashboard.categories.fields.edit', compact('category', 'dynamicField', 'fieldTypes', 'optionsString'));
    }

    public function update(UpdateDynamicFieldRequest $request, DynamicField $dynamicField, Category $category)
    {
        $this->dynamicField->udpate($request->validated(), $dynamicField);

        return redirect()->route('categories.fields.index', $category->id);
    }

    public function destroy(DynamicField $dynamicField, Category $category)
    {
        $this->dynamicField->destroy($dynamicField);

        return redirect()->route('categories.fields.index', $category->id);
    }
}
