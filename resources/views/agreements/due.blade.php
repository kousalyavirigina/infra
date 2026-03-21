@extends('layouts.app')

@section('title', 'Agreements Due')

@section('content')

<div class="container my-4">

<h2 class="fw-bold mb-3">Agreements Due</h2>

<div class="card shadow-sm">

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark text-center">

<tr>
<th>Booking ID</th>
<th>Plot No</th>
<th>Customer Name</th>
<th>Father Name</th>
<th>Contact</th>
<th>Email</th>
<th>Advance Amount</th>
<th>Payment</th>
<th>Booking Date</th>
<th>Agreement</th>
</tr>

</thead>

<tbody>

@forelse($bookings as $booking)

<tr class="text-center">

<td>
RaKe-{{ str_pad($booking->id, 2, '0', STR_PAD_LEFT) }}
</td>

<td>{{ $booking->plot->plot_no }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->father_name ?? '-' }}</td>

<td>{{ $booking->contact_number }}</td>

<td>{{ $booking->email ?? '-' }}</td>

<td class="fw-bold text-success">
₹ {{ number_format($booking->agreement->agreement_paid_amount ?? 0) }}
</td>

<td>

@if(strtolower($booking->payment_method) === 'upi')

<span class="badge bg-primary">
{{ strtoupper($booking->payment_method) }}
</span>

@else

<span class="badge bg-purple">
{{ strtoupper($booking->payment_method) }}
</span>

@endif

</td>

<td>
{{ $booking->booking_date_time->format('d M Y') }}
</td>


<td>

@if($booking->agreement)

<a href="{{ route('agreements.view', $booking->agreement->id) }}"
class="btn btn-sm btn-outline-primary mb-1">
View Agreement
</a>

<br>

@if($booking->agreement->agreement_paid_amount > 0)

<a href="{{ route('agreements.receipt.view', $booking->agreement->id) }}"
class="btn btn-sm btn-dark">
View Receipt
</a>

@else

<span class="text-danger small">
No Payment Yet
</span>

@endif


@else

<a href="{{ route('agreements.create', $booking->id) }}"
class="btn btn-sm btn-success">
Make Agreement
</a>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="10" class="text-center py-3">
No agreements found.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

<style>
.bg-purple{
background:#7c3aed;
}
</style>

@endsection