@extends('layouts.app')

@section('title', 'Create User')

@section('content')

<div style="display:flex; justify-content:center; margin-top:60px;">

<div style="
width:420px;
background:white;
padding:35px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
">

<h2 style="text-align:center; margin-bottom:30px;">
Create New User
</h2>

@if(session('success'))
<div style="color:green; margin-bottom:15px;">
{{ session('success') }}
</div>
@endif

<form method="POST" action="/admin/users">
@csrf
<div class="mb-3">
  <label for="name" class="form-label">Name</label>
  <input 
    type="text"
    id="name"
    name="name"
    class="form-control"
    placeholder="Enter user name"
    required
  >
</div>
<div class="mb-3">
<label class="form-label" style="font-weight:600;">Email Address</label>
<input 
type="email"
name="email"
class="form-control"
placeholder="Enter email address"
required>
<div class="form-text">We'll never share the email.</div>
</div>

<div class="mb-3">
<label class="form-label" style="font-weight:600;">Password</label>
<input 
type="password"
name="password"
class="form-control"
placeholder="Enter password"
required>
</div>

<div class="mb-3">
<label class="form-label" style="font-weight:600;">User Role</label>
<select
name="role"
class="form-select"
required>
<option value="">Choose Role</option>
<option value="sales">Sales</option>
<option value="admin">Admin</option>
</select>
</div>

<div style="display:flex; justify-content:space-between;">
<button type="submit" class="btn btn-primary btn-submit">
  Create User
</button>
<a href="/admin/users" style="color:#2563eb; text-decoration:none; padding-top:8px;">
Back
</a>

</div>

</form>

</div>

</div>

@endsection