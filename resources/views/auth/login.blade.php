@extends('layouts.app')

@section('title', 'Rake Infra Login')

@section('content')

<div class="d-flex align-items-center justify-content-center vh-100"
     style="background:linear-gradient(135deg,#eef2ff,#f8fafc);">

<div class="card shadow-lg p-4"
     style="width:420px;border-radius:16px;">

<!-- LOGO -->

<div class="text-center mb-3">

<img src="{{ asset('assets/images/RAKE.jpg') }}"
     style="height:60px;" class="mb-2">

<h4 class="fw-bold text-dark mb-0">
Login
</h4>

<p class="text-muted small">
Authorized access only
</p>

</div>


{{-- ERROR MESSAGE --}}

@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>

@endif


{{-- VALIDATION ERRORS --}}

@if ($errors->any())

<div class="alert alert-warning">

@foreach ($errors->all() as $error)

<div>• {{ $error }}</div>

@endforeach

</div>

@endif


<!-- LOGIN FORM -->

<form method="POST" action="{{ route('login.submit') }}">

@csrf

<div class="mb-3">

<label class="form-label fw-semibold">
Email Address
</label>

<input type="email"
name="email"
class="form-control"
required
value="{{ old('email') }}"
placeholder="you@example.com">

</div>


<div class="mb-4">

<label class="form-label fw-semibold">
Password
</label>

<input type="password"
name="password"
class="form-control"
required
placeholder="••••••••">

</div>


<button type="submit"
class="btn w-100 text-white fw-bold"
style="background:#0A1735;">

Login

</button>

</form>


<!-- FOOTER -->

<div class="text-center mt-3">

<a href="{{ route('home') }}"
class="text-decoration-none small">

← Back to Home

</a>

</div>

</div>

</div>

@endsection