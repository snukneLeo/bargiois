{{-- notify with toast (added order) --}}
<div class="toast align-items-center text-white bg-primary border-0" id="added" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="d-flex">
        <form action="{{ route('home') }}" method="get" enctype="multipart/form-data" class="form-group">
            @csrf
            <div class="toast-body">
                Wait, new order is added! Please refresh the page to show new orders.
                <button type="submit" class="btn btn-primary" aria-label="save">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- notify with toast (deleted order) --}}
<div class="toast align-items-center text-white bg-danger border-0" id="deleted" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="d-flex">
        <form action="{{ route('home') }}" method="get" enctype="multipart/form-data" class="form-group">
            @csrf
            <div class="toast-body">
                Wait, an order is deleted! Please refresh the page to show orders.
                <button type="submit" class="btn btn-danger" aria-label="save">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
