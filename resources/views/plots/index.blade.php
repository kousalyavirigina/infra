@extends('layouts.app')

@section('title', 'Plots Dashboard')

@section('content')
<section class="dashboard">

    <h1>Plots Dashboard</h1>

    {{-- ADMIN ONLY: TRASH LINK --}}
    @if(auth()->check() && strtolower(trim(auth()->user()->role)) === 'admin')
        <div style="margin-bottom:15px;">
            <a href="{{ route('admin.plots.trash') }}" style="color:red;font-weight:bold;">
                🗑 View Deleted Plots (Trash)
            </a>
        </div>
    @endif

    @php
        // ✅ Define positions only ONCE
        $positions = [
            1 => ['top' => '30.2%', 'left' => '65.3%'],
            2 => ['top' => '34.2%', 'left' => '65.4%'],
            3 => ['top' => '37.5%', 'left' => '65.5%'],
            4 => ['top' => '40.6%', 'left' => '65.6%'],
            5 => ['top' => '43.9%', 'left' => '65.6%'],

            17 => ['top' => '25.2%', 'left' => '52.4%'],
            18 => ['top' => '28.9%', 'left' => '52.4%'],
            19 => ['top' => '32%', 'left' => '52.4%'],
            20 => ['top' => '35.4%', 'left' => '52.3%'],
            21 => ['top' => '38.6%', 'left' => '52.2%'],
            22 => ['top' => '42%', 'left' => '52.41%'],
            23 => ['top' => '45.2%', 'left' => '52.4%'],
            24 => ['top'  => '48.5%', 'left'  => '52.4%'],
            25 => ['top'  => '52.3%', 'left'  => '52.4%'],

            44 => ['top' => '24.9%', 'left' => '43.7%'],
            43 => ['top' => '28.85%', 'left' => '43.8%'],
            42 => ['top' => '32.15%', 'left' => '43.8%'],
            41 => ['top' => '35.26%', 'left' => '43.73%'],
            40 => ['top' => '38.6%', 'left' => '43.8%'],
            39 => ['top' => '41.9%', 'left' => '43.8%'],
            38 => ['top' => '45.2%', 'left' => '43.8%'],
            37 => ['top' => '48.5%', 'left' => '43.8%'],
            36 => ['top' => '52.3%', 'left' => '43.8%'],

            45 => ['top'  => '24.4%', 'left'  => '30.4%'],
            46 => ['top'  => '28.9%', 'left'  => '30.5%'],
            47 => ['top'  => '32.15%', 'left'  => '30.5%'],
            48 => ['top'  => '35.3%', 'left'  => '30.5%'],
            49 => ['top'  => '38.65%', 'left'  => '30.5%'],
            50 => ['top'  => '41.9%',   'left'  => '30.5%'],
            51 => ['top'  => '45.2%',   'left'  => '30.5%'],
            52 => ['top'  => '48.5%', 'left'  => '30.5%'],
            53 => ['top'  => '52.3%', 'left'  => '30.55%'],

            66 => ['top'  => '24.43%', 'left'  => '22.4%'],
            65 => ['top'  => '30.5%', 'left'  => '21.2%'],
            64 => ['top'  => '37%', 'left'  => '20.7%'],
            63 => ['top'  => '43.5%', 'left'  => '20.6%'],
            62 => ['top'  => '50.8%', 'left'  => '20.5%'],

            61 => ['top'  => '62.6%', 'left'  => '20.2%'],
            60 => ['top'  => '68.9%',  'left'  => '20.1%'],
            59 => ['top'  => '73.9%',  'left'  => '20%'],

            54 => ['top'  => '61%', 'left'  => '30.6%'],
            55 => ['top'  => '64.9%', 'left'  => '30.6%'],
            56 => ['top'  => '68.15%', 'left'  => '30.6%'],
            57 => ['top'  => '71.4%', 'left'  => '30.6%'],
            58 => ['top'  => '74.7%',   'left'  => '30.6%'],

            35 => ['top'  => '61%', 'left'  => '43.8%'],
            34 => ['top'  => '64.9%', 'left'  => '43.8%'],
            33 => ['top'  => '68.15%', 'left'  => '43.8%'],
            32 => ['top'  => '71.4%', 'left'  => '43.8%'],
            31 => ['top'  => '74.7%',   'left'  => '43.8%'],

            26 => ['top'  => '61%', 'left'  => '52.4%'],
            27 => ['top'  => '64.9%', 'left'  => '52.4%'],
            28 => ['top'  => '68.15%', 'left'  => '52.4%'],
            29 => ['top'  => '71.4%', 'left'  => '52.4%'],
            30 => ['top'  => '74.7%',   'left'  => '52.4%'],

            16 => ['top'  => '61%', 'left'  => '65.6%'],
            15 => ['top'  => '64.9%', 'left'  => '65.6%'],
            14 => ['top'  => '68.15%', 'left'  => '65.6%'],
            13 => ['top'  => '71.4%', 'left'  => '65.6%'],
            12 => ['top'  => '74.7%',   'left'  => '65.6%'],

            7  => ['top'  => '61%', 'left'  => '73.9%'],
            8  => ['top'  => '64.9%', 'left'  => '73.9%'],
            9  => ['top'  => '68.15%', 'left'  => '73.9%'],
            10 => ['top'  => '71.4%', 'left'  => '74%'],
            11 => ['top'  => '74.7%',   'left'  => '73.9%'],
        ];

        // ✅ Very important: map plots by plot_no so clicking 35 always uses plot_no=35 record
        $plotsByNo = $plots->keyBy('plot_no');
    @endphp

    {{-- =========================
        SITE LAYOUT WITH PLOT BUTTONS
    ========================== --}}
    <div class="layout-wrapper">
        <img src="{{ asset('assets/images/layout.png') }}" class="layout-image">

        {{-- ✅ Draw circles based on POSITIONS (not based on DB order) --}}
        @foreach($positions as $plotNo => $pos)
            @php
                $plot = $plotsByNo->get($plotNo);
            @endphp

            @if($plot)
                <div
                    class="plot {{ $plot->status === 'available' ? 'available' : 'sold' }}"
                    style="top: {{ $pos['top'] }}; left: {{ $pos['left'] }};"
                    @if($plot->status === 'available')
                        onclick="openBooking({{ $plot->id }})"
                    @endif
                >
                    {{ str_pad($plot->plot_no, 2, '0', STR_PAD_LEFT) }}

                </div>
            @endif
        @endforeach
    </div>

    {{-- =========================
        PLOTS TABLE
    ========================== --}}
    <table border="1" cellpadding="10" cellspacing="0" width="100%" style="margin-top:40px;">
        <thead>
            <tr>
                <th>Plot No</th>
                <th>Sq. Yards</th>
                <th>Gadhulu</th>
                <th>Facing</th>
                <th>Road Width</th>
                <th>Status</th>
                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <th>Edit</th>
                    <th>Admin Action</th>
                @endif
            </tr>
        </thead>

        <tbody>
        @forelse($plots as $plot)
            <tr>
                <td>{{ str_pad($plot->plot_no, 2, '0', STR_PAD_LEFT) }}</td>

                <td>{{ $plot->sq_yards }}</td>
                <td>{{ number_format($plot->gadhulu, 2) }}</td>
                <td>{{ $plot->facing }}</td>
                <td>{{ $plot->road_width }} ft</td>

                <td>
                    @if($plot->status === 'available')
                        <span style="color:green;font-weight:bold;">Available</span>
                    @else
                        <span style="color:red;font-weight:bold;">Booked</span>
                    @endif
                </td>

                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <td>
                        <a href="{{ route('admin.plots.edit', $plot->id) }}" style="color:blue;font-weight:bold;">
                            Edit
                        </a>
                    </td>

                    <td>
                        <form method="POST"
                              action="{{ route('admin.plots.destroy', $plot->id) }}"
                              onsubmit="return confirm('Move this plot to trash?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red;">Delete</button>
                        </form>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="8" align="center">No plots found</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</section>

<script>
function openBooking(plotId) {
    window.location.href = "{{ url('/plots') }}/" + plotId + "/booking";
}
</script>
@endsection
