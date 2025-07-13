@if (session()->has('alert_status'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
        <div id="alertToast" class="toast align-items-center border-0 {{ session('alert_status') ? 'bg-success text-white' : 'bg-danger text-white' }} shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="width: 250px">
            <div class="toast-header text-white {{ session('alert_status') ? 'bg-success' : 'bg-danger' }}">
                <strong class="me-auto">{{ session('alert_title') }}</strong>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('alert_message') }}
            </div>
        </div>
    </div>
@endif
