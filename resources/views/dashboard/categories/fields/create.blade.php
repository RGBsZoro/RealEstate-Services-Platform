@extends('layouts/contentNavbarLayout')

@section('title', 'Add Field to ' . $category->getTranslation('name', 'en'))

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
                <h5 class="mb-0">Create New Field</h5>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('categories.fields.store', $category->id) }}" method="POST">
                    @csrf
                    
                    {{-- Label EN --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Field Label (EN)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                <input type="text" name="label[en]" class="form-control" placeholder="e.g. Number of Rooms" required />
                            </div>
                        </div>
                    </div>

                    {{-- Label AR --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Field Label (AR)</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="label[ar]" class="form-control" placeholder="مثلاً: عدد الغرف" required />
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
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Options Wrapper --}}
                    <div class="row mb-6 d-none" id="optionsWrapper">
                        <label class="col-sm-2 col-form-label">Selection Options</label>
                        <div class="col-sm-10">
                            <textarea name="options_input" id="options_input" class="form-control" rows="2" placeholder="Red, Blue, Green (Comma separated)"></textarea>
                            <small class="text-muted">Enter options separated by a comma.</small>
                        </div>
                    </div>

                    {{-- Required Toggle --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Is Required?</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_required" value="1" id="reqCheck">
                                <label class="form-check-label" for="reqCheck">Mark as mandatory</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">Save Field</button>
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
    // نفس الـ JS للتحكم بالخيارات
    document.getElementById('typeSelect').addEventListener('change', function() {
        const wrapper = document.getElementById('optionsWrapper');
        this.value === 'select' ? wrapper.classList.remove('d-none') : wrapper.classList.add('d-none');
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        const type = document.getElementById('typeSelect').value;
        const input = document.getElementById('options_input').value;
        if (type === 'select' && input) {
            input.split(',').map(i => i.trim()).forEach(opt => {
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