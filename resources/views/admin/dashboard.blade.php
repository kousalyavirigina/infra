@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="admin-dashboard">

    <h1 class="dash-title">Admin Dashboard</h1>
    <p class="dash-subtitle">RaKe Infra • Construction Control Panel</p>
<div class="stats-grid">

    <a href="{{ route('plots.index') }}" class="stat-card stat-link">
    <h3>Total Plots</h3>
    <p>{{ $totalPlots }}</p>
</a>

<a href="{{ route('plots.index', ['status' => 'available']) }}" class="stat-card stat-link">
    <h3>Available Plots</h3>
    <p>{{ $availablePlots }}</p>
</a>
    <a href="{{ route('bookings.index') }}" class="stat-card stat-link">
        <h3>Booked Plots</h3>
        <p>{{ $bookedPlots }}</p>
    </a>

    <a href="{{ route('agreements.due') }}" class="stat-card stat-link">
        <h3>Agreements</h3>
        <p>{{ $agreementsCount }}</p>
    </a>

    <a href="{{ route('sale-deeds.index') }}" class="stat-card stat-link">
        <h3>Sale Deeds</h3>
        <p>{{ $saleDeedsCount }}</p>
    </a>
    <a href="{{ route('payments.plot') }}" class="stat-card">
        <h3>Sale Amount Payment</h3>
        <p>Pay Net Balance</p>
    </a>

    <a href="{{ route('admin.finance') }}" class="stat-card finance-stat">
        <div class="finance-icon">💰</div>
        <h1 class="finance-title-text">Finance</h1>
    </a>
    <a href="{{ route('admin.requests.feedback') }}" class="stat-card stat-link">
        <h3>User Requests & Feedback</h3>
        <p>View</p>
    </a>






</div>



<div class="quick-actions">
    <a href="{{ route('admin.users.index') }}" class="action-btn">👤 Manage Users</a>
    <a href="{{ route('admin.plots.create') }}" class="action-btn">➕ Add Plot</a>
    <a href="{{ route('admin.plots.index') }}" class="action-btn">📋 View Plots</a>
    <a href="{{ route('admin.plots.trash') }}" class="action-btn danger">🗑 Trash</a>
</div>
</section>
    
@endsection
