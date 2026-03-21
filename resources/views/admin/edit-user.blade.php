@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-6 col-md-8">

<div class="card shadow-lg border-0 rounded-3">

<div class="card-header bg-primary text-white">
<h5 class="mb-0">Edit User</h5>
</div>

<div class="card-body p-4">

<form method="POST" action="/admin/users/{{ $user->id }}/update">
@csrf

<!-- Name -->

<div class="mb-3">
<label class="form-label fw-semibold">Full Name</label>

<div class="input-group">
<span class="input-group-text">
<i class="bi bi-person"></i>
</span>

<input 
type="text"
name="name"
class="form-control"
value="{{ $user->name }}"
placeholder="Enter full name"
required>

</div>
</div>

<!-- Email -->

<div class="mb-3">
<label class="form-label fw-semibold">Email Address</label>

<div class="input-group">
<span class="input-group-text">
<i class="bi bi-envelope"></i>
</span>

<input 
type="email"
name="email"
class="form-control"
value="{{ $user->email }}"
placeholder="Enter email address"
required>

</div>

</div>

<!-- Role -->

<div class="mb-3">

<label class="form-label fw-semibold">User Role</label>

<select name="role" class="form-select">

<option value="sales" {{ $user->role=='sales'?'selected':'' }}>
Sales
</option>

<option value="admin" {{ $user->role=='admin'?'selected':'' }}>
Admin
</option>

</select>

</div>

<!-- Password -->

<div class="mb-4">

<label class="form-label fw-semibold">New Password</label>

<div class="input-group">

<input 
type="password"
name="password"
class="form-control"
placeholder="Leave blank if not changing">

<button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
👁
</button>

</div>

<div class="form-text">
Leave blank if you don't want to change the password.
</div>

</div>

<div class="d-flex justify-content-between">

<a href="/admin/users" class="btn btn-outline-secondary">
← Back
</a>

<button type="submit" class="btn btn-primary px-4">
Update User
</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script>

function togglePassword(){
const password = document.querySelector('input[name="password"]');
password.type = password.type === "password" ? "text" : "password";
}

</script>

@endsection
