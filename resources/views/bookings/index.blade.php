@php use App\Models\PlotBooking; @endphp

@extends('layouts.app')

@section('title', 'All Bookings')

@section('content')

<div class="container py-5">

<div class="text-center mb-4">
<h1 class="fw-bold text-dark">All Bookings</h1>
<p class="text-muted">
Admin + Sales can view booking history here.
</p>
</div>


<div class="card shadow-lg">

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-light text-center">

<tr>

<th>Booking ID</th>
<th>Plot No</th>
<th>Customer</th>
<th>Contact</th>
<th>Amount</th>
<th>Payment</th>
<th>Booked At</th>
<th>Due Date</th>
<th>Status</th>
<th>Actions</th>

@if(auth()->user()->role === 'admin')
<th>Sales Person</th>
@endif

@if(auth()->user()->role === 'admin')
<th>Admin</th>
@endif

</tr>

</thead>


<tbody>

@forelse($bookings as $booking)

<tr class="text-center">

<td class="fw-bold">
RaKe-{{ str_pad($booking->id, 2, '0', STR_PAD_LEFT) }}
</td>

<td>{{ $booking->plot->plot_no }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->contact_number }}</td>

<td class="fw-semibold text-success">
₹{{ number_format($booking->advance_amount) }}
</td>

<td>
<span class="badge bg-secondary">
{{ strtoupper($booking->payment_method) }}
</span>
</td>

<td>
{{ $booking->booking_date_time->format('d-m-Y h:i A') }}
</td>

<td>
{{ $booking->agreement_due_date->format('d-m-Y') }}
</td>


<td>

@if($booking->status === \App\Models\PlotBooking::STATUS_BOOKED)

<span class="badge bg-success">
BOOKED
</span>

@else

<span class="badge bg-danger">
{{ strtoupper($booking->status) }}
</span>

@endif

</td>


{{-- ACTIONS --}}

<td>

<a href="{{ route('bookings.show', $booking->id) }}"
class="btn btn-sm btn-outline-primary">
View
</a>

<a href="{{ route('bookings.receipt', $booking->id) }}"
class="btn btn-sm btn-outline-secondary">
Receipt
</a>

</td>


@if(auth()->user()->role === 'admin')

<td class="fw-semibold">
{{ $booking->salesPerson->name ?? 'Admin' }}
</td>

@endif


{{-- ADMIN EXTEND --}}

@if(auth()->user()->role === 'admin')

<td>

<form method="POST"
action="{{ route('admin.plots.extend', $booking->plot_id) }}"
class="d-flex gap-2 justify-content-center">

@csrf

<input type="number"
name="extension_days"
min="1"
max="15"
class="form-control form-control-sm"
style="width:70px;"
placeholder="Days"
required>

<button type="submit"
class="btn btn-sm btn-dark">

Extend

</button>

</form>

</td>

@endif


</tr>

@empty

<tr>

<td colspan="12" class="text-center py-4 text-muted">

No bookings found.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>


{{-- PAGINATION --}}

<div class="mt-3">
{{ $bookings->links() }}
</div>

</div>

</div>

</div>

@endsection