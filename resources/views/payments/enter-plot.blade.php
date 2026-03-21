@extends('layouts.app')

@section('title','Sale Amount Payment')

@section('content')

<style>
    .payment-wrapper {
        max-width: 1000px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .payment-title {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #0A1735;
    }

    .plot-form {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .plot-form select {
        padding: 10px 14px;
        min-width: 220px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .plot-form button {
        background: #0A1735;
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .plot-form button:hover {
        background: #13285C;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin: 25px 0 15px;
        color: #13285C;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 6px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    table thead {
        background: #f1f5f9;
    }

    table th,
    table td {
        padding: 10px;
        border: 1px solid #e5e7eb;
        text-align: center;
    }

    table th {
        font-weight: 700;
        color: #0A1735;
    }

    table tbody tr:nth-child(even) {
        background: #f9fafb;
    }

    table tbody tr:hover {
        background: #eef2ff;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-paid {
        background: #dcfce7;
        color: #166534;
    }

    .badge-due {
        background: #fee2e2;
        color: #991b1b;
    }

    .receipt-link {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }

    .receipt-link:hover {
        text-decoration: underline;
    }
</style>

<div class="payment-wrapper">

    <div class="payment-title">Sale Amount Payment</div>

    <!-- SELECT PLOT -->
    <form method="POST" action="{{ route('payments.fetch') }}" class="plot-form">
        @csrf

        <select name="plot_no" required>
            <option value="">-- Select Plot --</option>
            @foreach($bookings as $booking)
                <option value="{{ $booking->plot->plot_no }}">
                    Plot {{ $booking->plot->plot_no }} – {{ $booking->customer_name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Fetch Plot Details</button>
    </form>

    <!-- COMPLETED PAYMENTS TABLE -->
    <div class="section-title">Completed Sale Payments</div>

    <table>
        <thead>
            <tr>
                <th>Plot No</th>
                <th>Customer</th>
                <th>Total Cost</th>
                <th>Paid</th>
                <th>Remaining</th>
                <th>Status</th>
                <th>Receipt</th>
            </tr>
        </thead>

        <tbody>
        @forelse($bookings as $booking)
            @foreach($booking->payments as $payment)
                <tr>
                    <td>{{ $booking->plot->plot_no }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>₹ {{ number_format($payment->total_cost) }}</td>
                    <td>₹ {{ number_format($payment->paid_amount) }}</td>
                    <td>₹ {{ number_format($payment->remaining_balance) }}</td>
                    <td>
                        @if($payment->remaining_balance == 0)
                            <span class="badge badge-paid">PAID</span>
                        @else
                            <span class="badge badge-due">DUE</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('payments.receipt.view', $payment->id) }}" target="_blank">
    View
</a>
|
<a href="{{ route('payments.receipt.download', $payment->id) }}">
    Download
</a>

                    </td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="7">No sale payments found</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection
