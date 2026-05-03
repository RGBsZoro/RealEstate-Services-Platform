@extends('layouts/contentNavbarLayout')

@section('title', isset($slider) ? __('sliders.edit') : __('sliders.add_new'))

@section('content')
<div class="row">
  <div class="col-xl">
    <div class="card mb-4 rounded-4 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center border-bottom">
        <h5 class="mb-0">{{ isset($slider) ? __('sliders.edit') : __('sliders.add_new') }}</h5>
        <a href="{{ route('sliders.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('sliders.back') }}</a>
      </div>
      <div class="card-body pt-4">
        <form action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($slider)) @method('PUT') @endif

          <div class="row">
            {{-- رفع الصورة --}}
            <div class="col-md-12 mb-4">
              <label class="form-label fw-bold">{{ __('sliders.upload_image') }}</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              @if(isset($slider) && $slider->hasMedia('slider_images'))
              <div class="mt-2 text-muted small">{{ __('sliders.current_image') }}:</div>
              <img src="{{ $slider->getFirstMediaUrl('slider_images') }}" class="rounded-3 mt-1" style="height: 100px;">
              @endif
              @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- العنوان (عربي وإنكليزي) --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('sliders.title_ar') ?? 'العنوان (عربي)' }}</label>
              <input type="text" name="title[ar]" class="form-control @error('title.ar') is-invalid @enderror" value="{{ old('title.ar', isset($slider) ? $slider->getTranslation('title', 'ar') : '') }}">
              @error('title.ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('sliders.title_en') ?? 'العنوان (إنكليزي)' }}</label>
              <input type="text" name="title[en]" class="form-control @error('title.en') is-invalid @enderror" value="{{ old('title.en', isset($slider) ? $slider->getTranslation('title', 'en') : '') }}">
              @error('title.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- حالة التفعيل (تم نقله هنا لترتيب الشكل) --}}
            <div class="col-12 mb-3">
              <label class="form-label">{{ __('sliders.is_active') }}</label>
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ (isset($slider) && $slider->is_active) || old('is_active') ? 'checked' : '' }}>
                <label class="form-check-label">{{ __('sliders.active_desc') }}</label>
              </div>
            </div>

            {{-- الوصف (عربي وإنكليزي) --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('sliders.description_ar') ?? 'الوصف (عربي)' }}</label>
              <textarea name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror" rows="3">{{ old('description.ar', isset($slider) ? $slider->getTranslation('description', 'ar') : '') }}</textarea>
              @error('description.ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('sliders.description_en') ?? 'الوصف (إنكليزي)' }}</label>
              <textarea name="description[en]" class="form-control @error('description.en') is-invalid @enderror" rows="3">{{ old('description.en', isset($slider) ? $slider->getTranslation('description', 'en') : '') }}</textarea>
              @error('description.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- تواريخ العرض --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('sliders.start_date') }}</label>
              <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ isset($slider) ? $slider->start_date->format('Y-m-d') : old('start_date') }}">
              @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('sliders.end_date') }}</label>
              <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ isset($slider) ? $slider->end_date->format('Y-m-d') : old('end_date') }}">
              @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- الروابط الديناميكية (Morph) --}}
            <div class="col-12 mt-3 p-3 bg-lighter rounded-3">
              <h6 class="fw-bold mb-3"><i class="bx bx-link me-1"></i> {{ __('sliders.link_to') }}</h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('sliders.link_type') }}</label>
                  <select id="sliderable_type" name="sliderable_type" class="form-select">
                    <option value="">{{ __('sliders.no_link') }}</option>
                    <option value="App\Models\Category" {{ (isset($slider) && $slider->sliderable_type == 'App\Models\Category') ? 'selected' : '' }}>{{ __('sliders.category') }}</option>
                    <option value="App\Models\Service" {{ (isset($slider) && $slider->sliderable_type == 'App\Models\Service') ? 'selected' : '' }}>{{ __('sliders.service') }}</option>
                  </select>
                </div>

                <div id="target_id_container" class="col-md-6 mb-3 {{ (isset($slider) && $slider->sliderable_id) ? '' : 'd-none' }}">
                  <label class="form-label">{{ __('sliders.target_item') }}</label>
                  <select id="sliderable_id" name="sliderable_id" class="form-select">
                    {{-- سيتم تعبئتها بواسطة JS --}}
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2 px-4">{{ __('sliders.save') }}</button>
            <a href="{{ route('sliders.index') }}" class="btn btn-label-secondary">{{ __('sliders.cancel') }}</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  const sliderableType = document.getElementById('sliderable_type');
  const sliderableIdContainer = document.getElementById('target_id_container');
  const sliderableId = document.getElementById('sliderable_id');

  // البيانات من الـ Backend
  const dataSources = {
    'App\\Models\\Category': @json($categories),
    'App\\Models\\Service': @json($services)
  };

  const currentId = "{{ $slider->sliderable_id ?? '' }}";

  sliderableType.addEventListener('change', function() {
    const type = this.value;
    sliderableId.innerHTML = '';
    
    if (type && dataSources[type]) {
        sliderableIdContainer.classList.remove('d-none');
        
        // إضافة خيار فارغ أولاً
        const defaultOption = new Option("{{ __('sliders.select_item') }}", "");
        sliderableId.add(defaultOption);

        dataSources[type].forEach(item => {
            // هنا نستخدم display_name الذي جهزناه في الـ Controller
            const option = new Option(item.display_name, item.id);
            
            if (item.id == currentId) option.selected = true;
            sliderableId.add(option);
        });
    } else {
        sliderableIdContainer.classList.add('d-none');
    }
});

  // تشغيل الـ Script مرة عند التحميل في حالة الـ Edit
  if (sliderableType.value) {
    sliderableType.dispatchEvent(new Event('change'));
  }
</script>
@endsection