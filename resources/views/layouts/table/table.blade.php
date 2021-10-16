{{-- START MODAL FOR CREATE INFO E OTHER ELEMENT --}}
<!-- Button trigger modal -->
<div class="modal fade modal-settings" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('layouts.form.form_settings')
            </div>
        </div>
    </div>
</div>
{{-- END MODAL --}}
@include('layouts.toast.toast')
<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h3>Order</h3>
            <hr>
            @include('layouts.form.form')
        </div>
        <div class="col">
            <h3>
                Orders
            </h3>
            <hr>
            <table class="table table-striped table-responsive overflow-auto">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Surn.</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!is_null($user_orders))
                        @foreach ($user_orders as $order)
                            <tr>
                                <td>{{ $order['name'] }}</td>
                                <td>{{ substr($order['surname'], 0, 4) . '.' }}</td>
                                <td>{{ $order['phone'] }}</td>
                                <td>{{ $order['time'] }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Button group">
                                        {{-- <form class="form-group"> --}}
                                        <button type="submit" class="btn btn-info btn-sm" id="info_id"
                                            value="info_{{ $order['order_id'] }}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <input type="hidden" name="btn_order"
                                            value="order_id{{ $order['order_id'] }}">
                                        <span>
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                value="delete_{{ $order['order_id'] }}" id="delete_order_id">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </span>
                                        <span>
                                            <button type="submit" class="btn btn-warning btn-sm"
                                                value="settings_{{ $order['order_id'] }}" id="settings_order_id">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                        </span>
                                        {{-- </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>Nothing to show :(</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col">
            <h3>
                Dashboard
            </h3>
            <hr>
            {{-- GRAPH OF PERC --}}
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card-counter primary">
                            <i class="fa fa-database"></i>
                            <span class="count-numbers">
                                {{$statistics->total - $statistics->qt_pizza}}
                            </span>
                            <span class="count-name">
                                Remaining
                            </span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card-counter danger">
                            <i class="fas fa-users"></i>
                            <span class="count-numbers">
                                {{$statistics->qt_user}}
                            </span>
                            <span class="count-name">
                                Customer
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card-counter success">
                            <i class="fas fa-flag"></i>
                            <span class="count-numbers">
                                {{$statistics->total}}
                            </span>
                            <span class="count-name">
                                Total
                            </span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card-counter info">
                            <i class="fa fa-database"></i>
                            <span class="count-numbers">
                                    {{ $order_count }}
                            </span>
                            <span class="count-name">Order</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('.btn').click(function update(e) {
                //var whichBtn = $(this).getById();
                var getValueBtn = $(this).val();
                var id = "";
                if (getValueBtn.indexOf("info_") >= 0) // also return -1
                {
                    id = getValueBtn.substring(5, 11);
                    //call ajax
                    $.ajax({
                        url: "/infoOrder",
                        type: "post",
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: id
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(info_order) {
                            $.each(info_order, function(key, value) {
                                Swal.fire({
                                    title: value['name'] + ' - ' + value[
                                        'time'] + " (P: " + value['qt_pizza'] + ")",
                                    text: value['order'],
                                    icon: 'info',
                                    confirmButtonText: 'Ok'
                                });
                            })
                        }
                    });
                } else if (getValueBtn.indexOf("delete_") >= 0) // also return -1
                {
                    // alert show
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You will not be able to recover this order!",
                        icon: "warning",
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Yes, delete it!",
                        denyButtonText: "No, cancel!",
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) // if confirm
                        {
                            //call ajax
                            $.ajax({
                                url: "/deleteOrder",
                                type: "post",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    order_id: getValueBtn.substring(7, 14)
                                },
                                cache: false,
                                dataType: 'json',
                                success: function(delete_order) {
                                    $.each(delete_order, function(key, value) {
                                        if (value ==
                                            true
                                        ) { // order is deleted and correct mode
                                            // alert show
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "Your order has been deleted",
                                                icon: "success",
                                                confirmButtonText: "Ok",
                                            }).then((result) => {
                                                /* Read more about isConfirmed */
                                                if (result
                                                    .isConfirmed
                                                ) // if confirm
                                                {
                                                    location.reload();
                                                }
                                            })
                                        } else { // something went wrong and mode is not correct
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Something went wrong',
                                                icon: 'error',
                                                //confirmButtonText: 'Ok',
                                                timer: 2000
                                            })
                                        }

                                    });
                                }
                            });
                        } else if (result.isDenied) { // not confirm
                            Swal.fire("Cancelled",
                                "Your order is safe :)",
                                "error");
                        }
                    })

                } else if (getValueBtn.indexOf("settings_") >= 0) // also return -1
                {
                    $.ajax({
                        url: "/settings",
                        type: "post",
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: getValueBtn.substring(9, 15)
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(settings) {
                            $.each(settings, function(key, value) {
                                $('#name_s').val(value['name']);
                                $('#surname_s').val(value['surname']);
                                $('#time_s').val(value['time']);
                                $('#qt_pizza_s').val(value['qt_pizza']);
                                $('#order_s').val(value['order']);
                                $('#phone_s').val(value['phone']);
                                $('#hidden_order_id').val(getValueBtn.substring(9, 15));
                                $('.modal-settings').modal('show');
                            });
                        }
                    });
                } else {
                    console.log('not found!');
                }
            });
        });
        $(document).ready(function showNotify(e) {
            var timer = setTimeout(showNotify, 15000);
            $.ajax({
                url: "/notify",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                cache: false,
                dataType: 'json',
                success: function(notify) {
                    if (notify['notify'] === 'added')
                    {
                        // disable timer
                        clearTimeout(timer);
                        // show toast
                        $('#added').toast('show').delay(10000);
                        // start and create timer
                        timer;
                    }
                    else if (notify['notify'] === 'deleted')
                    {
                        // disable timer
                        clearTimeout(timer);
                        // show toast
                        $('#deleted').toast('show').delay(10000);
                        // start and create timer
                        timer;
                    }
                }
            }).then(function() {
                timer;
                /* location.reload(); */
            })
        });
        $(function() {
            $('#totalQt_pasta').click(function() {
                $.ajax({
                    url: "/totalPasta",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(total) {
                        $('#qt_pasta').val(total['total']);
                        $('#modal_total_pasta').modal('show');
                    }
                })
            })
        });
    </script>
@endpush

@push('css')
    <style>
        .card-counter {
            box-shadow: 2px 2px 10px #DADADA;
            margin: 5px;
            padding: 20px 10px;
            background-color: #fff;
            height: 100px;
            border-radius: 5px;
            transition: .3s linear all;
        }

        .card-counter:hover {
            box-shadow: 4px 4px 20px #DADADA;
            transition: .3s linear all;
        }

        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }

        .card-counter.danger {
            background-color: #ef5350;
            color: #FFF;
        }

        .card-counter.success {
            background-color: #66bb6a;
            color: #FFF;
        }

        .card-counter.info {
            background-color: #26c6da;
            color: #FFF;
        }

        .card-counter i {
            font-size: 5em;
            opacity: 0.2;
        }

        .card-counter .count-numbers {
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
        }

        .card-counter .count-name {
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.5;
            display: block;
            font-size: 18px;
        }

    </style>
@endpush
