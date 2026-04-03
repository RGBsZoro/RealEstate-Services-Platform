@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Fields - ' . $category->getTranslation('name', 'en'))

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Dynamic Fields for: <span class="text-primary">{{ $category->getTranslation('name', 'en') }}</span></h5>
            <div class="d-flex">  
                {{-- زر إضافة يفتح صفحة جديدة --}}
                <a href="{{ route('categories.fields.create', $category->id) }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Add New Field
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 35%">Field Label</th>
                    <th style="width: 20%">Type</th>
                    <th style="width: 15%">Required</th>
                    <th style="width: 20%">Options</th>
                    <th style="width: 10%">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($dynamicFields as $dynamicField)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-list-check"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading">{{ $dynamicField->getTranslation('label', 'en') }}</span>
                                <small class="text-muted">{{ $dynamicField->getTranslation('label', 'ar') }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-primary">{{ $dynamicField->type }}</span>
                    </td>
                    <td>
                        @if($dynamicField->is_required)
                            <span class="badge bg-label-danger">Required</span>
                        @else
                            <span class="badge bg-label-secondary">Optional</span>
                        @endif
                    </td>
                    <td>
                        @if($dynamicField->options)
                            @foreach($dynamicField->options as $option)
                                <span class="badge badge-dot bg-info me-1"></span>
                                <small>{{ $option }}</small><br>
                            @endforeach
                        @else
                            <span class="text-muted small">No options</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href={{ route('categories.fields.edit' , [$dynamicField->id, $category->id]) }}><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('categories.fields.destroy', [$dynamicField->id, $category->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bx bx-trash me-1"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-customize mb-2" style="font-size: 2rem;"></i>
                            <p>No dynamic fields defined for this category.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection