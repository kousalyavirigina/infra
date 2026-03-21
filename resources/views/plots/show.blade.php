@extends('layouts.app')

@section('title', 'Plot Details')

@section('content')
<section style="padding:40px; max-width:900px; margin:auto;">

    <h1>🏗 Plot Details</h1>

    <div style="
        margin-top:25px;
        padding:25px;
        border-radius:16px;
        background:#ffffff;
        box-shadow:0 20px 40px rgba(0,0,0,0.1);
    ">

        <table width="100%" cellpadding="12" cellspacing="0">
            <tr>
                <td><strong>Plot No</strong></td>
                <td>{{ $plot->plot_no }}</td>
            </tr>

            <tr>
                <td><strong>Sq. Yards</strong></td>
                <td>{{ $plot->sq_yards }}</td>
            </tr>

            <tr>
                <td><strong>Gadhulu</strong></td>
                <td>{{ $plot->gadhulu }}</td>
            </tr>

            <tr>
                <td><strong>Facing</strong></td>
                <td>{{ $plot->facing }}</td>
            </tr>

            <tr>
                <td><strong>Road Width</strong></td>
                <td>{{ $plot->road_width }} ft</td>
            </tr>

            <tr>
                <td><strong>Status</strong></td>
                <td>
                    @if($plot->status === 'available')
                        <span style="color:green; font-weight:bold;">Available</span>
                    @else
                        <span style="color:red; font-weight:bold;">Sold</span>
                    @endif
                </td>
            </tr>
        </table>

        {{-- BOOK NOW --}}
        @if($plot->status === 'available')
            <div style="margin-top:30px;">
                <a href="{{ route('plots.book', $plot->id) }}"
                   style="
                    padding:14px 28px;
                    background:#0d2b5e;
                    color:#fff;
                    border-radius:30px;
                    text-decoration:none;
                    font-weight:bold;
                   ">
                    📋 Book This Plot
                </a>
            </div>
        @endif

    </div>

</section>
@endsection
