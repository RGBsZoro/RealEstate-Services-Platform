@extends('layouts/contentNavbarLayout')

@section('title', 'Main Categories')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Main Categories</h5>
        <a href="{{ route('categories.main.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Add Main Category
        </a>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Category Name</th>
                    <th>Sub-Categories</th>
                    <th>Dynamic Fields</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($category->getFirstMediaUrl('Categories'))
                                <img src="{{ $category->getFirstMediaUrl('Categories') }}" alt="icon" class="rounded me-3" width="35" height="35" style="object-fit: cover;">
                            @else
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-category"></i></span>
                                </div>
                            @endif
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading">{{ $category->getTranslation('name', 'en') }}</span>
                                <small class="text-muted">{{ $category->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="text-heading"><i class="bx bx-git-repo-forked me-1 text-secondary"></i> {{ $category->children->count() ?? 0 }} Sub</span>
                    </td>

                    <td>
                        <span class="text-heading"><i class="bx bx-list-check me-1 text-info"></i> {{ $category->dynamicFields->count() ?? 0 }} Fields</span>
                    </td>

                    <td>
                        <span class="badge {{ $category->isActive ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $category->isActive ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td>
                        <span class="text-muted">{{ $category->created_at->format('M d, Y') }}</span>
                    </td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                {{-- Manage Fields --}}
                                <a class="dropdown-item" href={{ route('categories.fields.index' , $category->id) }}>
                                    <i class="bx bx-cog me-1 text-info"></i> Manage Fields
                                </a>
                                
                                {{-- Edit --}}
                                <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                
                                {{-- Delete --}}
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Attention: Deleting this main category will also delete all its sub-categories. Continue?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" title="Delete">
                                        <i class="bx bx-trash me-1"></i> Delete
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
                            <p>No main categories found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection