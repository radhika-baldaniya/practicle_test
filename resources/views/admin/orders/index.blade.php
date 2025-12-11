@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Orders</h3>
  <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Create Order</a>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Customer</th>
      <th>Total Amount</th>
      <th>Status</th>
      <th>Items</th>
      <th>Order Date</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($orders as $order)
      <tr>
        <td>{{ $order->customer->name }}</td>
        <td>{{ number_format($order->total_amount,2) }}</td>
        <td>{{ $order->status }}</td>
        <td>{{ $order->total_qty }}</td>
        <td>{{ $order->order_date?->format('d-m-Y') }}</td>
        <td>
          <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $orders->links() }}
@endsection
