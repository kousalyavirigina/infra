<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Agreement Payment Receipt</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:"DejaVu Sans",sans-serif;
font-size:14px;
color:#000;
background:#f8f9fa;
}

.receipt-card{
max-width:750px;
margin:auto;
border:1px solid #000;
}

.logo img{
height:70px;
}

.receipt-title{
font-size:18px;
font-weight:700;
text-align:center;
}

.info-row{
margin-bottom:6px;
}

.label{
font-weight:600;
}

.amount-table th,
.amount-table td{
border:1px solid #000;
}

.amount-table th{
background:#f0f0f0;
}

.footer{
margin-top:30px;
text-align:center;
font-weight:600;
font-size:13px;
}

.signature{
margin-top:40px;
}

@media print{
button,a{
display:none!important;
}
body{
background:#fff;
}
}

</style>
</head>

<body>

<div class="container my-4">

<div class="card receipt-card shadow-sm">

<div class="card-body">

<!-- LOGO -->
<div class="text-center logo mb-2">
<img src="{{ asset('assets/images/RAKE.jpg') }}">
</div>

<!-- TITLE -->
<div class="receipt-title mb-3">
RAKE INFRA <br>
AGREEMENT PAYMENT RECEIPT
</div>

<!-- RECEIPT INFO -->
<div class="row info-row">
<div class="col-6 label">Receipt No</div>
<div class="col-6 text-end">{{ $payment->receipt_no }}</div>
</div>

<div class="row info-row">
<div class="col-6 label">Date</div>
<div class="col-6 text-end">
{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}
</div>
</div>

<hr>

<!-- CUSTOMER DETAILS -->

<div class="row info-row">
<div class="col-6 label">Customer Name</div>
<div class="col-6 text-end">
{{ $agreement->booking->customer_name }}
</div>
</div>

<div class="row info-row">
<div class="col-6 label">Plot No</div>
<div class="col-6 text-end">
{{ $agreement->booking->plot->plot_no }}
</div>
</div>

<div class="row info-row">
<div class="col-6 label">Payment Mode</div>
<div class="col-6 text-end">
{{ strtoupper($payment->payment_mode) }}
</div>
</div>

@if($payment->reference_no)
<div class="row info-row">
<div class="col-6 label">Reference / UTR</div>
<div class="col-6 text-end">
{{ $payment->reference_no }}
</div>
</div>
@endif

@if($payment->bank_name)
<div class="row info-row">
<div class="col-6 label">Bank</div>
<div class="col-6 text-end">
{{ $payment->bank_name }}
</div>
</div>
@endif

<hr>

<!-- AMOUNT TABLE -->

<table class="table table-bordered amount-table mt-3">

<thead>
<tr class="text-center">
<th>Description</th>
<th>Amount (₹)</th>
</tr>
</thead>

<tbody>

<tr>
<td>Agreement Paid Amount</td>
<td class="text-end">{{ number_format($payment->amount,2) }}</td>
</tr>

<tr class="fw-bold">
<td>Total Paid</td>
<td class="text-end">{{ number_format($payment->amount,2) }}</td>
</tr>

</tbody>

</table>


<!-- SIGNATURES -->

<div class="row signature text-center">

<div class="col-6">
Seller Signature
</div>

<div class="col-6">
Purchaser Signature
</div>

</div>


<!-- FOOTER -->

<div class="footer">
This is a system generated receipt
</div>


<!-- ACTION BUTTONS -->

<div class="text-center mt-3">

<a href="{{ route('agreements.receipt.download', $agreement->id) }}"
class="btn btn-outline-dark me-2">
Download PDF
</a>

<button onclick="window.print()"
class="btn btn-outline-dark">
Print Receipt
</button>

</div>

</div>
</div>

</div>

</body>
</html>