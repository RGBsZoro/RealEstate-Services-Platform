@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Activity - ' . $activity->getTranslation('name', 'en'))

@section('page-style')
<style>
    /* تنسيق الحقول لتدعم الـ RTL في العربي */
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
    
    /* تنسيق معاينة الصورة ليكون متطابقاً مع الأقسام */
    .current-image-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; padding: 5px; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            {{-- الهيدر مع إضافة وقت التحديث ليعطي طابعاً احترافياً --}}
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0">Edit Business Activity</h5>
                <small class="text-muted float-end">Last updated: {{ $activity->updated_at->diffForHumans() }}</small>
            </div>
            
            <div class="card-body pt-5">
                <form action="{{ route('activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- Activity Name (EN) --}}
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

                    {{-- Activity Name (AR) --}}
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

                    {{-- Activity Image & Preview (نفس ستايل الكاتيجوري) --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Activity Image</label>
                        <div class="col-sm-10">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                @if($activity->hasMedia('Activities'))
                                    <img src="{{ $activity->getFirstMediaUrl('Activities') }}" alt="current-image" class="current-image-preview" id="uploadedAvatar">
                                @else
                                    <div class="current-image-preview d-flex align-items-center justify-content-center bg-label-secondary">
                                        <i class="bx bx-image-alt fs-2"></i>
                                    </div>
                                @endif
                                
                                <div class="button-wrapper">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="activity_image" accept="image/*" />
                                    <div class="text-muted small mt-2">Allowed JPG, PNG or SVG. Max size of 2MB.</div>
                                    @error('image') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    
                    {{-- Buttons --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
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