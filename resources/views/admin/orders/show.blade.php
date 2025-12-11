@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">

    <!-- ORDER HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Order #{{ $order->id }}</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <!-- ORDER SUMMARY CARD -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Order Summary</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong class="text-muted d-block">Customer Name</strong>
                    <span class="fw-semibold">{{ $order->customer->name }}</span>
                </div>

                <div class="col-md-4">
                    <strong class="text-muted d-block">Email</strong>
                    <span>{{ $order->customer->email }}</span>
                </div>

                <div class="col-md-4">
                    <strong class="text-muted d-block">Phone</strong>
                    <span>{{ $order->customer->phone }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong class="text-muted d-block">Order Date</strong>
                    <span>{{ $order->order_date->format('d-m-Y') }}</span>
                </div>

                <div class="col-md-4">
                    <strong class="text-muted d-block">Status</strong>

                    @php
                        $statusClass = [
                            'Pending' => 'warning',
                            'Completed' => 'success',
                            'Cancelled' => 'danger'
                        ][$order->status] ?? 'secondary';
                    @endphp

                    <span class="badge bg-{{ $statusClass }} px-3 py-2">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="col-md-4">
                    <strong class="text-muted d-block">Total Amount</strong>
                    <span class="fw-bold">₹ {{ number_format($order->total_amount,2) }}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ORDER ITEMS TABLE -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Order Items</h5>
        </div>

        <div class="card-body p-0">

            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40%">Product</th>
                        <th width="15%">Quantity</th>
                        <th width="20%">Unit Price</th>
                        <th width="25%">Line Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹ {{ number_format($item->price,2) }}</td>
                            <td class="fw-semibold">₹ {{ number_format($item->quantity * $item->price,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- STATUS UPDATE -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Update Order Status</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf

                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Select Status</label>
                        <select name="status" class="form-select">
                            <option value="Pending"   {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">Update Status</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>

@endsection
