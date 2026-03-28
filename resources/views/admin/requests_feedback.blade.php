@extends('layouts.app')

@section('title','User Requests & Feedback')

@section('content')

<div class="container mt-5">

<h2 class="text-center mb-5">
User Requests & Feedback
</h2>

<div class="row g-4">

<!-- REQUEST TABLE -->

<div class="col-lg-6">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h5 class="mb-0">User Requests</h5>
</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-light">
<tr>
<th>S No</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Request</th>
</tr>
</thead>

<tbody>

@forelse($requests as $req)

<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ $req->name ?? '-' }}</td>
  <td>{{ $req->email ?? '-' }}</td>
  <td>{{ $req->phone ?? '-' }}</td>
  <td>{{ ucfirst($req->request_type) ?? '-' }}</td>
</tr>
@empty

<tr>
<td colspan="5" class="text-center">
No requests found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

<!-- FEEDBACK TABLE -->

<div class="col-lg-6">

<div class="card shadow">

<div class="card-header bg-success text-white">
<h5 class="mb-0">User Feedback</h5>
</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-light">
<tr>
<th>S No</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Rating</th>
<th>Feedback</th>
</tr>
</thead>

<tbody>

@forelse($feedbacks as $fb)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ $fb->name ?? '-' }}</td>
  <td>{{ $fb->email ?? '-' }}</td>
  <td>{{ $fb->phone ?? '-' }}</td>
  <td>
    <span class="badge bg-success">
      {{ $fb->rating ?? '-' }}
    </span>
  </td>
  <td>{{ $fb->feedback ?? '-' }}</td>
</tr>

@empty

<tr>
<td colspan="6" class="text-center">
No feedback found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

@endsection
