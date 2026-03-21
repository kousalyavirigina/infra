@extends('layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
<section class="sales-dashboard">

    <div class="dashboard-header">
        <h1>Sales Dashboard</h1>
        <p>RaKe Infra • Plot Overview</p>
    </div>

    <div class="stats-grid">

        <a href="{{ route('plots.index') }}" class="stat-card">
            <h3>Total Plots</h3>
            <p>{{ $totalPlots }}</p>
        </a>

        <a href="{{ route('plots.index', ['status' => 'available']) }}" class="stat-card">
            <h3>Available Plots</h3>
            <p>{{ $availablePlots }}</p>
        </a>

        <a href="{{ route('bookings.index') }}" class="stat-card booked">
            <h3>Booked Plots</h3>
            <p>{{ $bookedPlots }}</p>
        </a>

        <a href="{{ route('agreements.due') }}" class="stat-card">
            <h3>Agreements</h3>
            <p>{{ $agreementsCount }}</p>
        </a>
        
        <a href="{{ route('payments.plot') }}" class="stat-card">
            <h3>Sale Amount Payment</h3>
            <p>Pay Net Balance</p>
        </a>

        

    </div>

    <div class="quick-actions">
        <a href="{{ route('plots.index') }}" class="action-btn">
            📋 Open Plot Dashboard
        </a>
    </div>

</section>
@endsection
