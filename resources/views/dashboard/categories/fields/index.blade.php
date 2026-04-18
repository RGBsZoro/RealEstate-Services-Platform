@extends('layouts/contentNavbarLayout')

@section('title', __('fields.manage_fields_title', ['category' => $category->getTranslation('name', 'en')]))

@section('content')
<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                {{ __('fields.manage_fields_title', ['category' => '']) }} 
                <span class="text-primary">{{ $category->getTranslation('name', app()->getLocale()) }}</span>
            </h5>
            <div class="d-flex">  
                @can('create-dynamic-fields')
                    <a href="{{ route('categories.fields.create', $category->id) }}" class="btn btn-primary rounded-pill">
                        <i class="bx bx-plus-circle me-1"></i> {{ __('fields.add_new_field') }}
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 35%">{{ __('fields.th_label') }}</th>
                    <th style="width: 20%">{{ __('fields.th_type') }}</th>
                    <th style="width: 15%">{{ __('fields.th_required') }}</th>
                    <th style="width: 20%">{{ __('fields.th_options') }}</th>
                    @if(auth()->user()->can('edit-dynamic-fields') || auth()->user()->can('delete-dynamic-fields'))
                        <th style="width: 10%" class="text-center">{{ __('categories.th_actions') }}</th>
                    @endif
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
                                <small class="text-muted small">{{ $dynamicField->getTranslation('label', 'ar') }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-primary text-capitalize">{{ $dynamicField->type }}</span>
                    </td>
                    <td>
                        @if($dynamicField->is_required)
                            <span class="badge bg-label-danger">{{ __('fields.required') }}</span>
                        @else
                            <span class="badge bg-label-secondary">{{ __('fields.optional') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($dynamicField->options)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($dynamicField->options as $option)
                                    <span class="badge bg-label-info badge-sm">
                                        {{ is_array($option) ? ($option[app()->getLocale()] ?? '') : $option }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted small italic">{{ __('fields.no_options') }}</span>
                        @endif
                    </td>
                    @if(auth()->user()->can('edit-dynamic-fields') || auth()->user()->can('delete-dynamic-fields'))
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('edit-dynamic-fields')
                                        <a class="dropdown-item" href="{{ route('categories.fields.edit' , [$dynamicField->id, $category->id]) }}">
                                            <i class="bx bx-edit-alt me-1"></i> {{ __('categories.edit') }}
                                        </a>
                                    @endcan
                                    @can('delete-dynamic-fields')
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('categories.fields.destroy', [$dynamicField->id, $category->id]) }}" method="POST" onsubmit="return confirm('{{ __('categories.confirm_delete') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> {{ __('fields.remove') }}
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-customize mb-2" style="font-size: 2rem;"></i>
                            <p>{{ __('fields.no_fields_found') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection