<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Booking Receipt</title>
</head>

<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:30px 0;">
<tr>
<td align="center">

<table width="650" cellpadding="20" cellspacing="0" style="background:#ffffff;border-radius:8px;">

<tr>
<td align="center">

<h2 style="margin:0;color:#0A1735;">Booking Receipt</h2>
<p style="margin:5px 0 15px;color:#666;font-size:13px;">
RaKe Infra • Plot Booking Confirmation
</p>

</td>
</tr>

<tr>
<td>

<p style="font-size:14px;color:#555;">
<b>Booking ID:</b>
RaKe-{{ str_pad($booking->id, 2, '0', STR_PAD_LEFT) }}
</p>

</td>
</tr>

<tr>
<td>

<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">

<tr>
<td style="border-bottom:1px solid #eee;"><b>Customer</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->customer_name }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Phone</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->contact_number }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Email</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->email }}</td>
</tr>

</table>

</td>
</tr>

<tr>
<td>

<h3 style="margin-top:10px;color:#0A1735;">Plot Details</h3>

<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">

<tr>
<td style="border-bottom:1px solid #eee;"><b>Plot No</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->plot->plot_no }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Sq. Yards</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->plot->sq_yards }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Facing</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->plot->facing }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Road Width</b></td>
<td style="border-bottom:1px solid #eee;">{{ $booking->plot->road_width }} ft</td>
</tr>

</table>

</td>
</tr>

<tr>
<td>

<h3 style="margin-top:10px;color:#0A1735;">Payment</h3>

<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">

<tr>
<td style="border-bottom:1px solid #eee;"><b>Advance Amount</b></td>
<td style="border-bottom:1px solid #eee;">₹{{ number_format($booking->advance_amount) }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Method</b></td>
<td style="border-bottom:1px solid #eee;">{{ strtoupper($booking->payment_method) }}</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Booking Date</b></td>
<td style="border-bottom:1px solid #eee;">
{{ $booking->booking_date_time->format('d-m-Y h:i A') }}
</td>
</tr>

<tr>
<td style="border-bottom:1px solid #eee;"><b>Agreement Due Date</b></td>
<td style="border-bottom:1px solid #eee;">
{{ \Carbon\Carbon::parse($booking->agreement_due_date)->format('d-m-Y') }}
</td>
</tr>

</table>

</td>
</tr>

<tr>
<td>

<h3 style="color:#0A1735;">Policies</h3>

<p style="margin:5px 0;">• Advance payment is <b>non-refundable</b>.</p>
<p style="margin:5px 0;">• Agreement must be completed within <b>50 days</b>.</p>
<p style="margin:5px 0;">• Admin can extend agreement up to <b>15 days</b>.</p>

</td>
</tr>

@if(!empty($booking->admin_email_note))

<tr>
<td>

<h3 style="color:#0A1735;">Admin Note</h3>
<p>{{ $booking->admin_email_note }}</p>

</td>
</tr>

@endif

<tr>
<td>

<p style="margin-top:20px;">
Thank you,<br>
<b>RaKe Infra</b>
</p>

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>