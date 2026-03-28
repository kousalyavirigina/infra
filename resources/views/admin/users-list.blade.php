@extends('layouts.app')

@section('title', 'Users List')

@section('content')

<div class="container mt-5">

<h2 class="mb-4">Users List</h2>

<form method="GET" action="{{ route('admin.users.create') }}" class="mb-3">
<button type="submit" class="btn btn-primary">
+ Create User
</button>
</form>

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered table-hover">


<thead class="table-light">
<tr>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th width="200">Actions</th>
</tr>
</thead>


<tbody>

@forelse($users as $user)

<tr>
<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>{{ ucfirst($user->role) }}</td>

<td>

<a href="/admin/users/{{ $user->id }}/edit" class="btn btn-warning btn-sm">
Edit
</a>

<a href="/admin/users/{{ $user->id }}/delete"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete user?')">
Delete </a>

</td>
</tr>

@empty

<tr>
<td colspan="4" class="text-center">
No users found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
