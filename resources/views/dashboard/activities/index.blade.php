@extends('layouts/contentNavbarLayout')

@section('title', 'Business Activities Management')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Business Activities</h5>
            <div class="d-flex">  
                <a href="{{ route('activities.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Add New Activity
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%">Activity Name</th>
                    <th style="width: 25%">Business Accounts</th>
                    <th style="width: 20%">Creation Date</th>
                    <th style="width: 15%">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($activities as $activity)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                @if($activity->hasMedia('activities'))
                                    <img src="{{ $activity->getFirstMediaUrl('activities') }}" alt="Icon" class="rounded">
                                @else
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-briefcase"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading">{{ $activity->getTranslation('name', 'en') }}</span>
                                <small class="text-muted" dir="rtl">{{ $activity->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-store-alt me-2 text-secondary"></i>
                            <span class="text-muted">{{ $activity->business_accounts_count ?? 0 }} Account(s)</span>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted">{{ $activity->created_at->format('M d, Y') }}</span>
                    </td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('activities.edit', $activity->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Attention: Are you sure you want to delete this activity?')">
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
                    <td colspan="4" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-folder-open mb-2" style="font-size: 2rem;"></i>
                            <p>No business activities found in the database.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection