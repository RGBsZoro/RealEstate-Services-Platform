@extends('layouts/contentNavbarLayout')

@section('title', 'Services Requests')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Services Requests</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Service Title</th>
                    <th>Business Account</th>
                    <th>Category</th>
                    <th>Type & Price</th>
                    <th>Status</th>
                    <th>Date applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($services as $service)
                <tr>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-medium text-heading">{{ Str::limit($service->title, 30) }}</span>
                            <small class="text-muted">Quantity: {{ $service->quantity }}</small>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-store me-2 text-primary"></i>
                            <div class="d-flex flex-column">
                                <span>{{ $service->businessAccount->getTranslation('name', 'en') ?? $service->businessAccount->name ?? 'Unknown' }}</span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-heading"><i class="bx bx-category me-1 text-secondary"></i> {{ $service->category->name ?? 'N/A' }}</span>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex flex-column">
                            <span class="badge bg-label-{{ $service->type == 'sale' ? 'success' : 'info' }} mb-1 w-px-75">
                                {{ ucfirst($service->type) }}
                            </span>
                            <small class="text-muted">${{ number_format($service->price_usd, 2) }}</small>
                        </div>
                    </td>

                    <td>
                        <span class="badge {{ $service->status->badge() ?? 'bg-label-warning' }}">
                            {{ $service->status->label() ?? ucfirst($service->status) }}
                        </span>
                    </td>

                    <td>
                        <span class="text-muted">{{ $service->created_at->format('M d, Y') }}</span>
                    </td>

                    <td>
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-show me-1"></i> View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-folder-open mb-2" style="font-size: 2rem;"></i>
                            <p>No service requests found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection