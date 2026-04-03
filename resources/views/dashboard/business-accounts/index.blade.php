@extends('layouts/contentNavbarLayout')

@section('title', 'Business Accounts Requests')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-0">Business Accounts Requests</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Account Name</th>
                    <th>User / Owner</th>
                    <th>Activity & City</th>
                    <th>Status</th>
                    <th>Date applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($business_accounts as $account)
                <tr>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-medium text-heading">{{ $account->getTranslation('name', 'en')}}</span>
                            <small class="text-muted">{{ $account->getTranslation('name', 'ar')}}</small>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-user me-2 text-primary"></i>
                            {{ $account->user->name ?? 'Unknown' }}
                        </div>
                    </td>

                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-heading"><i class="bx bx-briefcase me-1 text-secondary"></i> {{ $account->activity->name ?? 'N/A' }}</span>
                            <small class="text-muted"><i class="bx bx-map me-1"></i> {{ $account->city->name ?? 'N/A' }}</small>
                        </div>
                    </td>

                    <td>
                        <span class="badge {{ $account->status->badge() }}">
                            {{ $account->status->label() }}
                        </span>
                    </td>

                    <td>
                        <span class="text-muted">{{ $account->created_at->format('M d, Y') }}</span>
                    </td>

                    <td>
                        <a href="{{ route('business-accounts.show', $account->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-show me-1"></i> View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-folder-open mb-2" style="font-size: 2rem;"></i>
                            <p>No account requests found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection