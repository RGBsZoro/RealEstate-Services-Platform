@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Field - ' . $dynamicField->getTranslation('label', 'en'))

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
                <h5 class="mb-0">Edit Field: <span class="text-primary">{{ $dynamicField->getTranslation('label', 'en') }}</span></h5>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.fields.update', [$dynamicField->id, $category->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Label EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Field Label (EN)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                <input type="text" name="label[en]" class="form-control" 
                                    value="{{ old('label.en', $dynamicField->getTranslation('label', 'en')) }}" required />
                            </div>
                        </div>
                    </div>

                    {{-- Label AR --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Field Label (AR)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="label[ar]" class="form-control" 
                                    value="{{ old('label.ar', $dynamicField->getTranslation('label', 'ar')) }}" required />
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                            </div>
                        </div>
                    </div>

                    {{-- Type Selection --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Input Type</label>
                        <div class="col-sm-10">
                            <select name="type" id="typeSelect" class="form-select" required>
                                @foreach($fieldTypes as $value => $label)
                                    <option value="{{ $value }}" {{ $dynamicField->type == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Options Wrapper - يظهر إذا كان النوع select --}}
                    <div class="row mb-6 {{ $dynamicField->type !== 'select' ? 'd-none' : '' }}" id="optionsWrapper">
                        <label class="col-sm-2 col-form-label">Selection Options</label>
                        <div class="col-sm-10">
                            <textarea name="options_input" id="options_input" class="form-control" rows="2" 
                                placeholder="Red, Blue, Green (Comma separated)">{{ old('options_input', $optionsString) }}</textarea>
                            <small class="text-muted">Edit options separated by a comma.</small>
                        </div>
                    </div>

                    {{-- Required Toggle --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Is Required?</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_required" value="1" 
                                    id="reqCheck" {{ $dynamicField->is_required ? 'checked' : '' }}>
                                <label class="form-check-label" for="reqCheck">Mark as mandatory</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">Update Field</button>
                            <a href="{{ route('categories.fields.index', $category->id) }}" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
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
    // التحكم بالظهور عند التغيير
    document.getElementById('typeSelect').addEventListener('change', function() {
        const wrapper = document.getElementById('optionsWrapper');
        this.value === 'select' ? wrapper.classList.remove('d-none') : wrapper.classList.add('d-none');
    });

    // تحويل النص إلى Array قبل الإرسال
    document.querySelector('form').addEventListener('submit', function(e) {
        const type = document.getElementById('typeSelect').value;
        const input = document.getElementById('options_input').value;
        
        // نحذف أي خيارات قديمة تم توليدها برمجياً لنتجنب التكرار
        this.querySelectorAll('input[name="options[]"]').forEach(el => el.remove());

        if (type === 'select' && input) {
            input.split(',').map(i => i.trim()).filter(i => i !== "").forEach(opt => {
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