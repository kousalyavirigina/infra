@extends('layouts.app')

@section('title', 'Finance Dashboard')

@section('content')

<div class="container mt-5">

<style>
/* 🔹 Finance Container */
.finance-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}

/* 🔹 Header */
.finance-header h1 {
    font-size: 26px;
    margin-bottom: 8px;
    color: #0f172a;
    font-weight: 600;
}

/* 🔹 Subtitle / Status */
.finance-header p {
    color: #16a34a;
    font-weight: 600;
    margin-bottom: 25px;
    font-size: 14px;
}

/* Cards layout */
.finance-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

/* Card style */
.finance-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 30px;
    text-align: center;
    text-decoration: none;
    color: #0A1735;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.finance-card:hover {
    transform: translateY(-6px);
    border-color: #0A1735;
}

.finance-card .icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.finance-card h3 {
    font-size: 22px;
    margin-bottom: 8px;
}

.finance-card p {
    font-size: 14px;
    color: #555;
}

/* Card colors */
.receipts {
    background: linear-gradient(135deg, #e8f0ff, #ffffff);
}

.expenses {
    background: linear-gradient(135deg, #fff0f0, #ffffff);
}

</style>

<div class="finance-container">

    <!-- HEADER -->
    <div class="finance-header">
        <h1>Finance Dashboard</h1>
        <p>Finance module loaded successfully ✔</p>
    </div>

    <!-- CARDS -->
    <div class="finance-grid">

        <!-- RECEIPTS -->
        <a href="{{ route('admin.finance.receipts') }}" class="finance-card receipts">
            <div class="icon">🧾</div>
            <h3>Receipts</h3>
            <p>View & download all receipts</p>
        </a>

        <!-- EXPENSES -->
        <a href="{{ route('admin.expenditure') }}" class="finance-card expenses">
            <div class="icon">📉</div>
            <h3>Manage Expenses</h3>
            <p>Add, filter & download expenditure records</p>
        </a>

    </div>

</div>

</div>

@endsection