<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body{
font-family:"DejaVu Sans",sans-serif;
font-size:14px;
color:#000;
}

.container{
width:100%;
padding:20px;
border:1px solid #000;
}

.logo{
text-align:center;
margin-bottom:10px;
}

.logo img{
height:70px;
}

.title{
text-align:center;
font-size:18px;
font-weight:bold;
margin-bottom:15px;
}

.info-table{
width:100%;
border-collapse:collapse;
margin-bottom:10px;
}

.info-table td{
padding:6px;
}

.label{
font-weight:bold;
width:40%;
}

.value{
text-align:right;
width:60%;
}

hr{
margin:10px 0;
}

.payment-table{
width:100%;
border-collapse:collapse;
margin-top:15px;
}

.payment-table th,
.payment-table td{
border:1px solid #000;
padding:8px;
}

.payment-table th{
background:#f0f0f0;
text-align:center;
}

.text-left{
text-align:left;
}

.text-right{
text-align:right;
}

.footer{
margin-top:30px;
text-align:center;
font-weight:bold;
font-size:13px;
}

</style>

</head>

<body>

<div class="container">

<div class="logo">
<img src="{{ public_path('assets/images/RAKE.jpg') }}">
</div>

<div class="title">
RAKE INFRA<br>
AGREEMENT PAYMENT RECEIPT
</div>

<table class="info-table">

<tr>
<td class="label">Receipt No</td>
<td class="value">{{ $payment->receipt_no }}</td>
</tr>

<tr>
<td class="label">Date</td>
<td class="value">{{ $payment->payment_date->format('d-m-Y') }}</td>
</tr>

</table>

<hr>

<table class="info-table">

<tr>
<td class="label">Customer Name</td>
<td class="value">{{ $agreement->booking->customer_name }}</td>
</tr>

<tr>
<td class="label">Plot No</td>
<td class="value">{{ $agreement->booking->plot->plot_no }}</td>
</tr>

<tr>
<td class="label">Payment Mode</td>
<td class="value">{{ strtoupper($payment->payment_mode) }}</td>
</tr>

@if($payment->reference_no)
<tr>
<td class="label">Reference / UTR</td>
<td class="value">{{ $payment->reference_no }}</td>
</tr>
@endif

@if($payment->bank_name)
<tr>
<td class="label">Bank</td>
<td class="value">{{ $payment->bank_name }}</td>
</tr>
@endif

</table>

<hr>

<table class="payment-table">

<tr>
<th>Description</th>
<th>Amount (₹)</th>
</tr>

<tr>
<td class="text-left">Agreement Paid Amount</td>
<td class="text-right">{{ number_format($payment->amount,2) }}</td>
</tr>

<tr>
<th class="text-left">Total Paid</th>
<th class="text-right">{{ number_format($payment->amount,2) }}</th>
</tr>

</table>

<div class="footer">
This is a system generated receipt
</div>

</div>

</body>
</html>