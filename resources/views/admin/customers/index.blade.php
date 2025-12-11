@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Customers</h3>
  <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">Add Customer</a>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Name</th><th>Email</th><th>Phone</th><th>Created</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($customers as $c)
      <tr>
        <td>{{ $c->name }}</td>
        <td>{{ $c->email }}</td>
        <td>{{ $c->phone }}</td>
        <td>{{ $c->created_at->format('d-m-Y') }}</td>
        <td>
          <a href="{{ route('admin.customers.edit', $c->id) }}" class="btn btn-sm btn-secondary">Edit</a>

          <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure want to delete?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $customers->links() }}
@endsection
