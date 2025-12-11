@extends('admin.layouts.app') @section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Customer</h4>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.customers.store') }}" method="POST" id="customerForm" data-parsley-validate>
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required data-parsley-required-message="Please enter a name" data-parsley-minlength="2" data-parsley-minlength-message="Name must be at least 2 characters">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required data-parsley-type="email" data-parsley-type-message="Please enter a valid email address" data-parsley-required-message="Please enter an email">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required data-parsley-pattern="^[0-9]{10}$" data-parsley-pattern-message="Phone number must be exactly 10 digits" data-parsley-required-message="Please enter a phone number">
                </div>
                <button class="btn btn-success w-100 py-2">Save Customer</button>
            </form>

        </div>
    </div>
</div>

@endsection @push('scripts')
<script>
    $(function(){
      $("#customerForm").parsley();
    });
</script>
@endpush