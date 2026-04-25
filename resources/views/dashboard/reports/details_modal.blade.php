<div class="modal fade" id="reportModal{{ $report->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('reports.details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary">{{ __('reports.service') }}:</label>
                    <p class="mb-0">{{ $report->service->title ?? __('reports.unknown') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary">{{ __('reports.reason') }}:</label>
                    <p class="text-break mb-0">{{ $report->reason }}</p>
                </div>
                
                @if($report->description)
                <div class="mb-3 p-3 bg-lighter rounded">
                    <label class="form-label fw-bold text-primary">{{ __('reports.description') }}:</label>
                    <p class="text-break mb-0">{{ $report->description }}</p>
                </div>
                @endif
                
                <hr>
                <div class="d-flex justify-content-between text-muted small">
                    <span><strong>{{ __('reports.reporter') }}:</strong> {{ $report->user->name ?? __('reports.unknown') }}</span>
                    <span><strong>{{ __('reports.date') }}:</strong> {{ $report->created_at->format('Y-m-d') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('reports.close') }}</button>
            </div>
        </div>
    </div>
</div>