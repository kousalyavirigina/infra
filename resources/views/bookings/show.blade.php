@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')

<div class="container my-5" style="max-width:1000px;">

<h2 class="mb-1">Booking Details</h2>

<p class="text-muted mb-4">
Booking ID: <strong>RaKe-{{ str_pad($booking->id, 2, '0', STR_PAD_LEFT) }}</strong>
</p>


<!-- CUSTOMER CARD -->

<div class="card mb-3 shadow-sm">

<div class="card-body">

<h5 class="card-title mb-3">Customer</h5>

<div class="row g-2">

<div class="col-md-6"><strong>Name:</strong> {{ $booking->customer_name }}</div>

<div class="col-md-6"><strong>Father Name:</strong> {{ $booking->father_name ?? '-' }}</div>

<div class="col-md-6"><strong>DOB:</strong> {{ $booking->date_of_birth ?? '-' }}</div>

<div class="col-md-6"><strong>Email:</strong> {{ $booking->email ?? '-' }}</div>

<div class="col-md-6"><strong>Contact:</strong> {{ $booking->contact_number }}</div>

<div class="col-md-6"><strong>Alt Contact:</strong> {{ $booking->alternate_contact_number ?? '-' }}</div>

</div>

</div>

</div>


<!-- ADDRESS CARD -->

<div class="card mb-3 shadow-sm">

<div class="card-body">

<h5 class="card-title mb-3">Address</h5>

<div class="row">

<div class="col-md-6">
<strong>Permanent:</strong><br>
{{ $booking->permanent_address }}
</div>

<div class="col-md-6">
<strong>Temporary:</strong><br>
{{ $booking->temporary_address ?? '-' }}
</div>

</div>

</div>

</div>


<!-- PLOT CARD -->

<div class="card mb-3 shadow-sm">

<div class="card-body">

<h5 class="card-title mb-3">Plot</h5>

<div class="row g-2">

<div class="col-md-6"><strong>Plot No:</strong> {{ $booking->plot?->plot_no }}</div>

<div class="col-md-6"><strong>Facing:</strong> {{ $booking->plot?->facing }}</div>

<div class="col-md-6"><strong>Sq. Yards:</strong> {{ $booking->plot?->sq_yards }}</div>

<div class="col-md-6"><strong>Road Width:</strong> {{ $booking->plot?->road_width }} ft</div>

</div>

</div>

</div>


<!-- RECEIPT PREVIEW -->

<div id="receipt" class="card shadow-sm">

<div class="card-body">

<h5 class="card-title mb-3">Receipt (Preview)</h5>

@php
$due = \Carbon\Carbon::parse($booking->agreement_due_date)->addDays((int)$booking->extension_days);
@endphp

<p><strong>Advance:</strong> ₹{{ number_format($booking->advance_amount) }}</p>

<p><strong>Payment:</strong> {{ strtoupper($booking->payment_method) }}</p>

<p><strong>Booking Date:</strong>
{{ \Carbon\Carbon::parse($booking->booking_date_time)->format('d-m-Y h:i A') }}
</p>

<p><strong>Agreement Due:</strong> {{ $due->format('d-m-Y') }}</p>

<hr>


<strong>Policies</strong>

<ul class="mt-2">

<li>Advance payment is <strong>non-refundable</strong>.</li>

<li>Agreement must be executed within <strong>7 days</strong> from booking date.</li>

<li>From date of agreement to sale must complete within <strong>45 days</strong>.</li>

</ul>


@if($booking->live_photo_path)

<div class="mt-3">

<strong>Live Photo:</strong><br>

<img src="{{ asset('storage/'.$booking->live_photo_path) }}"
class="img-thumbnail mt-2"
style="width:220px;">

</div>

@endif


@if(auth()->check() && strtolower(auth()->user()->role) === 'admin')

<div class="mt-3">

<strong>Admin Email Note:</strong>

<div class="border rounded p-3 mt-2 bg-light">

{{ $booking->admin_email_note ?? '—' }}

</div>

</div>

@endif


</div>

</div>


<!-- BACK BUTTON -->

<div class="mt-4">

<a href="{{ route('bookings.index') }}"
class="btn btn-outline-secondary">

Back to Bookings

</a>

</div>


</div>

@endsection