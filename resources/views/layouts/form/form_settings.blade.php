<form method="POST" action="{{route('update.order')}}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 divname">
        <label for="" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name_s">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Surname</label>
        <input type="text" class="form-control" name="surname" id="surname_s">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Phone</label>
        <input type="phone" class="form-control" name="phone" id="phone_s">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Order</label>
        <textarea class="form-control" name="order" rows="3" id="order_s"></textarea>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="" class="form-label">Time</label>
                    <input type="time" class="form-control" name="time" value="18:00" id="time_s">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="" class="form-label">N°</label>
                    <input type="number" class="form-control" name="qt_pizza" value="1" id="qt_pizza_s">
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="hidden_order_id" name="order_id">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i>
        </button>
    </div>
</form>
