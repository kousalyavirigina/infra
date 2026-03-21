<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sale Payment Receipt</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 20px;
            border: 1px solid #000;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            height: 70px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            width: 45%;
        }

        .value {
            width: 55%;
            text-align: right;
        }

        hr {
            margin: 12px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: right;
        }

        th {
            background: #f0f0f0;
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- LOGO -->
    <div class="logo">
        <img src="{{ public_path('assets/images/RAKE.jpg') }}">
    </div>

    <!-- TITLE -->
    <h2>RAKE INFRA<br>SALE PAYMENT RECEIPT</h2>

    <!-- RECEIPT INFO -->
    <div class="row">
        <div class="label">Receipt No</div>
        <div class="value">{{ $payment->receipt_no }}</div>
    </div>

    <div class="row">
        <div class="label">Date</div>
        <div class="value">{{ $payment->created_at->format('d-m-Y') }}</div>
    </div>

    <hr>

    <!-- CUSTOMER DETAILS -->
    <div class="row">
        <div class="label">Customer Name</div>
        <div class="value">{{ $payment->booking->customer_name }}</div>
    </div>

    <div class="row">
        <div class="label">Plot No</div>
        <div class="value">{{ $payment->booking->plot->plot_no }}</div>
    </div>

    <!-- PAYMENT MODE (ALL OPTIONS SUPPORTED) -->
    <div class="row">
        <div class="label">Payment Mode</div>
        <div class="value">
            @php
                $modes = [
                    'cash'   => 'Cash',
                    'upi'    => 'UPI',
                    'neft'   => 'NEFT',
                    'rtgs'   => 'RTGS',
                    'online' => 'Online Transfer',
                ];
            @endphp

            {{ $modes[$payment->payment_mode] ?? strtoupper($payment->payment_mode) }}
        </div>
    </div>

    <hr>

    <!-- AMOUNT DETAILS -->
    <table>
        <tr>
            <th>Description</th>
            <th>Amount (₹)</th>
        </tr>

        <tr>
            <td class="left">Total Plot Cost</td>
            <td>{{ number_format($payment->total_cost, 2) }}</td>
        </tr>

        <tr>
            <td class="left">Advance Paid</td>
            <td>{{ number_format($payment->advance_amount, 2) }}</td>
        </tr>

        <tr>
            <td class="left">Agreement Paid</td>
            <td>{{ number_format($payment->agreement_amount, 2) }}</td>
        </tr>

        <tr>
            <td class="left">Sale Amount Paid</td>
            <td>{{ number_format($payment->paid_amount, 2) }}</td>
        </tr>

        <tr>
            <th class="left">Remaining Balance</th>
            <th>{{ number_format($payment->remaining_balance, 2) }}</th>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        This is a system generated receipt
    </div>

</div>

</body>
</html>
