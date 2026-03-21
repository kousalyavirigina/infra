@extends('layouts.app')

@section('title', 'Finance Receipts')

@section('content')

<style>

/* ===============================
   RECEIPTS – PROFESSIONAL TABLE
================================ */

.receipts-container{
    background:#f7f9fc;
    padding:24px;
    border-radius:16px;
}

/* Header */

.receipts-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
}

.receipts-header h2{
    font-size:22px;
    font-weight:700;
    color:#0A1735;
}

.total-box{
    background:#eef4ff;
    padding:8px 16px;
    border-radius:10px;
    font-weight:700;
    color:#0A1735;
}

/* ================= FILTER ================= */

.filter-box{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:18px;
}

.filter-box input,
.filter-box select{
    height:38px;
    padding:6px 10px;
    border:1px solid #dcdcdc;
    border-radius:6px;
    font-size:14px;
}

.filter-box button{
    background:#0A1735;
    color:#fff;
    border:none;
    padding:0 18px;
    border-radius:6px;
    font-weight:600;
    cursor:pointer;
}

.filter-box a{
    padding:8px 16px;
    border:1px solid #ccc;
    border-radius:6px;
    text-decoration:none;
    color:#333;
}

.download-btn{
    background:#0A1735;
    color:#fff !important;
    padding:8px 16px;
    border-radius:6px;
    font-weight:600;
}

/* ================= TABLE ================= */

.table-wrap{
    overflow-x:auto;
}

.receipts-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
}

.receipts-table th,
.receipts-table td{
    padding:14px 16px;
    font-size:14px;
    border-bottom:1px solid #e6e9f0;
    white-space:nowrap;
}

.receipts-table th{
    background:#f1f4fb;
    color:#0A1735;
    font-weight:700;
    text-align:center;
}

.receipts-table td.amount{
    text-align:right;
    font-weight:700;
}

.receipts-table td.center{
    text-align:center;
}

.receipts-table td.mode{
    font-size:12px;
    color:#555;
    text-align:center;
}

.receipts-table tr:last-child td{
    border-bottom:none;
}

/* Actions */

.actions a{
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    margin:0 6px;
}

.actions a.view{ color:#1d4ed8; }
.actions a.pdf{ color:#dc2626; }

/* Empty */

.empty-row td{
    text-align:center;
    padding:20px;
    color:#777;
}

</style>

<div class="receipts-container">

    <!-- HEADER -->
    <div class="receipts-header">
        <h2>Receipts</h2>

        <div class="total-box">
            💰 Total: ₹ {{ number_format($totalCollection,2) }}
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="filter-box">

        <input type="date" name="from" value="{{ request('from') }}">
        <input type="date" name="to" value="{{ request('to') }}">

        <input type="text" name="customer" placeholder="Customer"
               value="{{ request('customer') }}">

        <input type="text" name="plot_no" placeholder="Plot No"
               value="{{ request('plot_no') }}">

        @if(auth()->user()->role === 'admin')

            <select name="sales_person_id">

                <option value="">All Sales</option>

                @foreach($salesUsers as $s)

                    <option value="{{ $s->id }}"
                        {{ request('sales_person_id')==$s->id ? 'selected':'' }}>
                        {{ $s->name }}
                    </option>

                @endforeach

            </select>

        @endif


        <button type="submit">Filter</button>

        <a href="{{ url()->current() }}">Reset</a>

        <a href="{{ request()->fullUrlWithQuery(['export'=>'csv']) }}"
           class="download-btn">
           ⬇ Download
        </a>

    </form>


    <!-- TABLE -->

    <div class="table-wrap">

    <table class="receipts-table">

        <thead>

        <tr>

            <th>Receipt No</th>
            <th>Date</th>
            <th>Plot</th>
            <th>Customer</th>
            <th style="text-align:right;">Amount</th>
            <th class="center">Mode</th>

            @if(auth()->user()->role === 'admin')
                <th class="center">Sales Person</th>
            @endif

            <th class="center">Receipt</th>

        </tr>

        </thead>


        <tbody>

        @forelse($receipts as $r)

            <tr>

                <td>{{ $r['receipt_no'] }}</td>

                <td>{{ \Carbon\Carbon::parse($r['date'])->format('d M Y') }}</td>

                <td class="center">{{ $r['plot_no'] ?? '-' }}</td>

                <td>{{ $r['customer'] }}</td>

                <td class="amount">
                    ₹ {{ number_format($r['amount'],2) }}
                </td>

                <td class="mode">
                    {{ strtoupper($r['mode']) }}
                </td>

                @if(auth()->user()->role === 'admin')

                    <td class="center" style="font-weight:600;">
                        {{ $r['sales_person'] ?? 'Admin' }}
                    </td>

                @endif

                <td class="center actions">

                    <a href="{{ $r['view_url'] }}" class="view">View</a> |

                    <a href="{{ $r['download_url'] }}" class="pdf">
                        Download
                    </a>

                </td>

            </tr>

        @empty

            <tr class="empty-row">

                <td colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}">

                    No receipts found

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    </div>

</div>

@endsection