@extends('layouts/contentNavbarLayout')

@section('title', __('fields.add_field_to', ['category' => $category->getTranslation('name', 'en')]))

@section('page-style')
<style>
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6 rounded-4 shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0">{{ __('fields.create_new_field') }}</h5>
                <small class="text-muted">{{ __('fields.add_field_to', ['category' => $category->getTranslation('name', app()->getLocale())]) }}</small>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.fields.store', $category->id) }}" method="POST" id="dynamicFieldForm">
                    @csrf
                    
                    {{-- Label EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('fields.field_label_en') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                <input type="text" name="label[en]" class="form-control @error('label.en') is-invalid @enderror" 
                                    placeholder="e.g. Number of Rooms" value="{{ old('label.en') }}" required />
                            </div>
                            @error('label.en') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Label AR --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('fields.field_label_ar') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="label[ar]" class="form-control @error('label.ar') is-invalid @enderror" 
                                    placeholder="مثلاً: عدد الغرف" value="{{ old('label.ar') }}" required />
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                            </div>
                            @error('label.ar') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Type Selection --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('fields.input_type') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-category"></i></span>
                                <select name="type" id="typeSelect" class="form-select @error('type') is-invalid @enderror" required>
                                    @foreach($fieldTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Options Wrapper (Select Only) --}}
                    <div class="row mb-6 {{ old('type') === 'select' ? '' : 'd-none' }}" id="optionsWrapper">
                        <label class="col-sm-2 col-form-label">{{ __('fields.selection_options') }}</label>
                        <div class="col-sm-10">
                            <textarea name="options_input" id="options_input" class="form-control" rows="2" 
                                placeholder="{{ __('fields.options_help') }}">{{ is_array(old('options')) ? implode(', ', old('options')) : '' }}</textarea>
                            <small class="text-muted">{{ __('fields.options_help') }}</small>
                        </div>
                    </div>

                    {{-- Required Toggle --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('fields.is_required') }}</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_required" value="1" id="reqCheck" {{ old('is_required') ? 'checked' : '' }}>
                                <label class="form-check-label" for="reqCheck">{{ __('fields.mark_as_mandatory') }}</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> {{ __('fields.save_field') }}
                            </button>
                            <a href="{{ route('categories.fields.index', $category->id) }}" class="btn btn-outline-secondary btn-lg ms-2">
                                {{ __('categories.cancel') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
    const typeSelect = document.getElementById('typeSelect');
    const optionsWrapper = document.getElementById('optionsWrapper');

    // تبديل ظهور مربع الخيارات بناءً على النوع
    typeSelect.addEventListener('change', function() {
        if (this.value === 'select') {
            optionsWrapper.classList.remove('d-none');
        } else {
            optionsWrapper.classList.add('d-none');
        }
    });

    // تحويل النص المدخل في التيكست أريا إلى مصفوفة قبل الإرسال
    document.getElementById('dynamicFieldForm').addEventListener('submit', function(e) {
        const type = typeSelect.value;
        const input = document.getElementById('options_input').value;
        
        if (type === 'select' && input.trim() !== '') {
            const options = input.split(',').map(i => i.trim()).filter(i => i !== "");
            
            options.forEach(opt => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'options[]';
                hidden.value = opt;
                this.appendChild(hidden);
            });
        }
    });
</script>
@endsection