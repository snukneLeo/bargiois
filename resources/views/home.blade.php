@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.table.table',[
        'user_orders' => $user_orders,
        'order_count' => $order_count,
        'statistics' => $statistics
        ])
</div>
@endsection
