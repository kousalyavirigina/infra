@extends('layouts.app')

@section('title', 'Finance')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      
      <div class="card finance-card border-0">
        
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Finance Report</h5>
        </div>

<div class="card-body p-4">

<form method="POST" action="{{ route('admin.finance.download') }}">
@csrf

<div class="row mb-4">

<div class="col-md-6">

<label class="form-label fw-semibold">From Date</label>

<input 
type="date"
name="from"
class="form-control"
required>

</div>

<div class="col-md-6">

<label class="form-label fw-semibold">To Date</label>

<input 
type="date"
name="to"
class="form-control"
required>

</div>

</div>

<div class="d-grid">

<button type="submit" class="btn btn-success">
⬇ Download Report
</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

@endsection
