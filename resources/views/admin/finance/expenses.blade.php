@extends('layouts.app')

@section('title', 'Expenditure')

@section('content')

<div class="container mt-4">

    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Expenditure</h2>

        <a href="{{ route('admin.finance') }}" class="btn btn-outline-dark">
            Back to Finance
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="row">

        <!-- CATEGORY CREATE + LIST -->
        <div class="col-md-6">

            <div class="card shadow-sm mb-3">

                <div class="card-header">
                    <b>Expense Categories</b>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.expenditure.category.store') }}" class="row g-2 mb-3">
                        @csrf

                        <div class="col-8">
                            <input type="text" name="name" class="form-control"
                                   placeholder="Create Category (ex: Office Rent)" required>
                        </div>

                        <div class="col-4">
                            <button class="btn btn-primary w-100">
                                Create
                            </button>
                        </div>

                    </form>

                    <div class="border rounded p-2" style="max-height:250px; overflow:auto;">

                        @forelse($categories as $cat)

                            <div class="d-flex justify-content-between border-bottom py-2">

                                <span>{{ $cat->name }}</span>

                                <span class="badge bg-primary">
                                    #{{ $cat->id }}
                                </span>

                            </div>

                        @empty

                            <p class="text-muted m-0">
                                No categories yet.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


        <!-- ADD EXPENSE -->
        <div class="col-md-6">

            <div class="card shadow-sm mb-3">

                <div class="card-header">
                    <b>Add Expense</b>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.expenditure.expense.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label"><b>Category</b></label>

                            <select name="expense_category_id" class="form-select" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-4">
                                <label class="form-label"><b>Expense Date</b></label>
                                <input type="date" name="expense_date" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><b>Approved By</b></label>
                                <input type="text" name="approved_by" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"><b>Amount</b></label>
                                <input type="number" name="amount" class="form-control" required min="1" step="0.01">
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label"><b>Payee</b></label>

                            <input type="text" name="payee" class="form-control"
                                   placeholder="Paid To (Vendor / Person)" required>

                        </div>

                        <div class="row mb-3">

                            <div class="col-md-4">

                                <label class="form-label"><b>Mode of Payment</b></label>

                                <select name="payment_mode" class="form-select" required>

                                    <option value="">Select Mode</option>
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="neft">NEFT</option>
                                    <option value="rtgs">RTGS</option>
                                    <option value="online">Online Transfer</option>
                                    <option value="cheque">Cheque</option>

                                </select>

                            </div>

                            <div class="col-md-8">

                                <label class="form-label"><b>Notes</b></label>

                                <input type="text" name="notes" class="form-control"
                                       placeholder="Notes (optional)">

                            </div>

                        </div>

                        <button class="btn btn-success">
                            Save Expense
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- FILTER + TABLE -->
    <div class="card shadow-sm">

        <div class="card-header">
            <b>Expenses</b>
        </div>

        <div class="card-body">

            <!-- FILTER -->
            <form method="GET" action="{{ route('admin.expenditure') }}" class="row g-2 mb-3">

                <div class="col-md-3">

                    <select name="category_id" class="form-select">

                        <option value="">All Categories</option>

                        @foreach($categories as $cat)

                            <option value="{{ $cat->id }}"
                                {{ request('category_id')==$cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">

                    <select name="payment_mode" class="form-select">

                        <option value="">All Payment Modes</option>

                        @foreach(['cash'=>'Cash','upi'=>'UPI','neft'=>'NEFT','rtgs'=>'RTGS','online'=>'Online','cheque'=>'Cheque'] as $k=>$v)

                            <option value="{{ $k }}"
                                {{ request('payment_mode')==$k ? 'selected' : '' }}>
                                {{ $v }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-3">
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-12 d-flex gap-2 mt-2">

                    <button class="btn btn-primary">
                        Filter
                    </button>

                    <a class="btn btn-outline-secondary"
                       href="{{ route('admin.expenditure.download.csv', request()->query()) }}">
                        Download CSV
                    </a>

                </div>

            </form>


            <!-- TABLE -->

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Approved By</th>
                            <th>Payee</th>
                            <th>Payment Mode</th>
                            <th class="text-end">Amount</th>
                            <th>Notes</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($expenses as $e)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($e->expense_date)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $e->category->name ?? '-' }}
                            </td>

                            <td>{{ $e->approved_by }}</td>

                            <td>{{ $e->payee }}</td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ strtoupper($e->payment_mode) }}
                                </span>
                            </td>

                            <td class="text-end fw-bold">
                                ₹ {{ number_format($e->amount, 2) }}
                            </td>

                            <td>{{ $e->notes }}</td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No expenses found
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection