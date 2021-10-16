<form method="POST" action="{{route('save.total')}}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 qt_pasta">
        <label for="" class="form-label">Qt Pasta</label>
        <input type="text" class="form-control" name="qt_total_pasta" id="qt_pasta">
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i>
        </button>
    </div>
</form>
