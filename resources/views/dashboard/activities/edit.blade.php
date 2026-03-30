@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Activity')

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
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Business Activity</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en">Activity Name (EN)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                    id="name_en" value="{{ old('name.en', $activity->getTranslation('name', 'en')) }}" required />
                            </div>
                            @error('name.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar">Activity Name (AR)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control @error('name.ar') is-invalid @enderror" 
                                    value="{{ old('name.ar', $activity->getTranslation('name', 'ar')) }}" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            @error('name.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Activity Image</label>
                        <div class="col-sm-10">
                            @if($activity->getFirstMediaUrl('activities'))
                                <div class="mb-3">
                                    <img src="{{ $activity->getFirstMediaUrl('activities') }}" alt="Current Icon" class="rounded" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                                    <p class="small text-muted mt-1">Current Icon</p>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" />
                            @error('image') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bx bx-save me-1"></i> Update Activity</button>
                            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection