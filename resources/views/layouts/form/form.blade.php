<form method="POST" action="{{ route('validate.order') }}" enctype="multipart/form-data">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @csrf
    <div class="mb-3 divname">
        <label for="" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name_input">
        <select class="form-select" id="selectUser" hidden>
            <option>Sorry nothing to show</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Surname</label>
        <input type="text" class="form-control" name="surname" id="surname_input">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Phone</label>
        <input type="phone" class="form-control" name="phone" id="phone">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Order</label>
        <textarea class="form-control" name="order" rows="3" id="order"></textarea>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="" class="form-label">Time</label>
                    <input type="time" class="form-control" name="time" value="18:00" id="time">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="" class="form-label">N°</label>
                    <input type="number" class="form-control" name="qt_pizza" value="1" id="qt_pizza">
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">
        <i class="fas fa-paper-plane"></i>
    </button>
    <div class="mt-5"></div>
</form>

@push('scripts')
    <script>
        $(function() {
            $("#name_input").keyup(function() {
                $.ajax({
                    url: "/searchLive",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        keyText: $('input[name="name"]').val()
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(userFilter) {
                        console.log(userFilter);
                        $("#selectUser").html('<option> Choice your user </option>');
                        if (userFilter['userFilter'].length > 0) {
                            $('#selectUser').removeAttr('hidden');
                            $.each(userFilter['userFilter'], function(key, value) {
                                if (value['surname'] != null) {
                                    $("#selectUser").append('<option value=' + value[
                                            'id'] +
                                        '>' + value['name'] + " " + value[
                                        'surname'] +
                                        '</option>');
                                }
                            })
                        }
                    }
                });
            });
        });
        $(function() {
            $("#selectUser").change(function() {
                $('#name_input').val('');
                $.ajax({
                    url: "/getUser",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: $(this).val()
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(user) {

                        $.each(user, function(key, value) {
                            $('#phone').val(value['phone']);
                            $('#surname_input').val(value['surname']);
                            $('#name_input').val(value['name']);
                        });
                    }
                });
            });
        });
    </script>
@endpush
