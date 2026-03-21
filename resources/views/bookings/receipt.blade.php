<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Booking Receipt</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:"DejaVu Sans",sans-serif;
background:#f4f7fb;
padding:40px;
}

.receipt-card{
max-width:650px;
margin:auto;
border-radius:12px;
}

.logo img{
height:70px;
}

.amount-box{
margin-top:30px;
padding:20px;
background:#f0f9ff;
border:1px dashed #38bdf8;
border-radius:10px;
text-align:center;
}

.amount-box p{
font-size:26px;
font-weight:bold;
color:#007BFF;
margin:0;
}

.footer{
margin-top:35px;
text-align:center;
font-size:12px;
color:#6b7280;
}

</style>

</head>

<body>

<div class="container">

<div class="card receipt-card shadow-sm">

<div class="card-body p-4">

<!-- LOGO -->

<div class="text-center logo mb-3">

<img src="{{ asset('assets/images/RAKE.jpg') }}" alt="RaKe Infra Logo">

</div>


<!-- TITLE -->

<h3 class="text-center fw-bold text-dark">
Booking Receipt
</h3>

<p class="text-center text-muted small mb-4">
RaKe Infra • Plot Booking Confirmation
</p>


<!-- BOOKING ID -->

<div class="text-center fw-bold text-primary mb-4">

Booking ID: RaKe-{{ str_pad($booking->id, 2, '0', STR_PAD_LEFT) }}

</div>


<!-- DETAILS -->

<table class="table table-borderless">

<tbody>

<tr>
<th style="width:40%">Plot No</th>
<td>{{ $booking->plot->plot_no }}</td>
</tr>

<tr>
<th>Customer Name</th>
<td>{{ $booking->customer_name }}</td>
</tr>

<tr>
<th>Contact</th>
<td>{{ $booking->contact_number }}</td>
</tr>

<tr>
<th>Payment Method</th>
<td>{{ strtoupper($booking->payment_method) }}</td>
</tr>

<tr>
<th>Booking Date</th>
<td>{{ $booking->booking_date_time->format('d M Y, h:i A') }}</td>
</tr>

</tbody>

</table>


<!-- AMOUNT BOX -->

<div class="amount-box">

<p>₹ {{ number_format($booking->advance_amount) }}</p>

</div>


<!-- FOOTER -->

<div class="footer">

This is a system generated receipt.<br>

Thank you for choosing <strong>RaKe Infra</strong>.

</div>

</div>

</div>

</div>

</body>
</html>