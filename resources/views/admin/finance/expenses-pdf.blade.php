@extends('layouts.app')

@section('title','Expenses Report')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-dark text-white text-center">
            <h4 class="mb-0">RAKE INFRA - EXPENSES REPORT</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                        <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Approved By</th>
                            <th>Payment Mode</th>
                            <th class="text-end">Amount (₹)</th>
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

                            <td>
                                {{ $e->approved_by }}
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ strtoupper($e->payment_mode) }}
                                </span>
                            </td>

                            <td class="text-end fw-bold">
                                ₹ {{ number_format($e->amount, 2) }}
                            </td>

                            <td>
                                {{ $e->notes }}
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center">
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