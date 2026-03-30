@extends('layouts/contentNavbarLayout')

@section('title', 'Cities Management')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">City Management</h5>
            <div class="d-flex">
                <a href="{{ route('cities.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Add New City
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 25%">City Name</th>
                    <th style="width: 25%">Coordinates (Lat/Lng)</th>
                    <th style="width: 15%">Coverage Area</th>
                    <th style="width: 15%">User Statistics</th>
                    <th style="width: 10%">Creation Date</th>
                    <th style="width: 10%">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($cities as $city)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-buildings"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading">{{ $city->getTranslation('name', 'en') }}</span>
                                <small class="text-muted" dir="rtl">{{ $city->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-muted" style="font-size: 0.85rem;">
                                <i class="bx bx-target-lock text-primary me-1"></i>{{ number_format($city->latitude, 7) }}
                            </span>
                            <span class="text-muted" style="font-size: 0.85rem;">
                                <i class="bx bx-target-lock text-primary me-1"></i>{{ number_format($city->longitude, 7) }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <span class="badge bg-label-info rounded-pill px-3">
                            <i class="bx bx-radar me-1"></i> {{ $city->radius }} KM
                        </span>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-group me-2 text-secondary"></i>
                            <span class="text-muted">{{ $city->users_count ?? 0 }} Users</span>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted">{{ $city->created_at->format('M d, Y') }}</span>
                    </td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('cities.edit', $city->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit City
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" onsubmit="return confirm('Attention: Are you sure you want to delete this city?')">
                                    @csrf
                                    @method('DELETE')
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
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-folder-open mb-2" style="font-size: 2rem;"></i>
                            <p>No city records found in the database.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection