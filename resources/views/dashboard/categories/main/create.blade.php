@extends('layouts/contentNavbarLayout')

@section('title', 'Add Main Category')

@section('page-style')
<style>
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0">Add New Main Category</h5>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="return_url" value="http://127.0.0.1:8000/categories/main">
                    {{-- Name EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en">Category Name (EN)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-category"></i></span>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                    id="name_en" placeholder="e.g. Real Estate" value="{{ old('name.en') }}" required />
                            </div>
                            @error('name.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Name AR --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar">Category Name (AR)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control @error('name.ar') is-invalid @enderror" 
                                    placeholder="مثلاً: عقارات" value="{{ old('name.ar') }}" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            @error('name.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Icon --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="category_icon">Category Icon</label>
                        <div class="col-sm-10">
                            <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror" id="category_icon" accept="image/*" />
                            <small class="text-muted">Upload an icon for this category (PNG, SVG preferred).</small>
                            @error('icon') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Status Switch --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="isActive">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1">
                                <label class="form-check-label" for="isActive">Active (Visible in App)</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bx bx-check-circle me-1"></i> Save Category</button>
                            <a href="{{ route('categories.main.index') }}" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection