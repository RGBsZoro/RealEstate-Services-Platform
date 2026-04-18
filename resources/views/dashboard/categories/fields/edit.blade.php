@extends('layouts/contentNavbarLayout')

@section('title', __('fields.edit_field', ['label' => $dynamicField->getTranslation('label', 'en')]))

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
                <h5 class="mb-0">{{ __('fields.edit_field', ['label' => '']) }} <span class="text-primary">{{ $dynamicField->getTranslation('label', app()->getLocale()) }}</span></h5>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.fields.update', [$dynamicField->id, $category->id]) }}" method="POST" id="editFieldForm">
                    @csrf
                    @method('PUT')
                    
                    {{-- Label EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('fields.field_label_en') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                <input type="text" name="label[en]" class="form-control @error('label.en') is-invalid @enderror" 
                                    value="{{ old('label.en', $dynamicField->getTranslation('label', 'en')) }}" required />
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
                                    value="{{ old('label.ar', $dynamicField->getTranslation('label', 'ar')) }}" required />
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
                                        <option value="{{ $value }}" {{ old('type', $dynamicField->type) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Options Wrapper --}}
                    <div class="row mb-6 {{ old('type', $dynamicField->type) !== 'select' ? 'd-none' : '' }}" id="optionsWrapper">
                        <label class="col-sm-2 col-form-label">{{ __('fields.selection_options') }}</label>
                        <div class="col-sm-10">
                            <textarea name="options_input" id="options_input" class="form-control" rows="2" 
                                placeholder="{{ __('fields.options_help') }}">{{ old('options_input', $optionsString) }}</textarea>
                            <small class="text-muted">{{ __('fields.options_help') }}</small>
                        </div>
                    </div>

                    {{-- Required Toggle --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('fields.is_required') }}</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_required" value="1" 
                                    id="reqCheck" {{ old('is_required', $dynamicField->is_required) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reqCheck">{{ __('fields.mark_as_mandatory') }}</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-refresh me-1"></i> {{ __('categories.update_category') }}
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

    typeSelect.addEventListener('change', function() {
        this.value === 'select' ? optionsWrapper.classList.remove('d-none') : optionsWrapper.classList.add('d-none');
    });

    document.getElementById('editFieldForm').addEventListener('submit', function(e) {
        const type = typeSelect.value;
        const input = document.getElementById('options_input').value;
        
        // تنظيف أي Inputs مخفية قديمة قبل الإرسال الجديد
        this.querySelectorAll('input[name="options[]"]').forEach(el => el.remove());

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