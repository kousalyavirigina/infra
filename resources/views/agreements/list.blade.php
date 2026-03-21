@extends('layouts.app')

@section('title','Agreement List')

@section('content')

<div class="container mt-4">

<h2 class="mb-3">Agreement List</h2>

<div class="card shadow-sm">

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark text-center">
<tr>
<th>#</th>
<th>Customer</th>
<th>Plot No</th>
<th>Agreement</th>
</tr>
</thead>

<tbody>

@foreach($bookings as $booking)

<tr class="text-center">

<td>{{ $loop->iteration }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->plot->plot_no ?? '-' }}</td>

<td>

@if($booking->agreement)

<a href="{{ route('agreement.view', $booking->agreement) }}"
class="btn btn-success btn-sm">
View Agreement
</a>

@else

<a href="{{ route('agreement.create', $booking) }}"
class="btn btn-primary btn-sm">
Make Agreement
</a>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

@endsection