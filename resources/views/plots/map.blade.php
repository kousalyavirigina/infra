@extends('layouts.app')

@section('title', 'Plot Layout')

@section('content')
<section class="plot-layout-wrapper">
    <h1 class="layout-title">Plot Layout</h1>

    <div class="layout-container">
        <img src="{{ asset('assets/images/layout-map.png') }}" class="layout-image">
        <div style="position:absolute; top:50%; left:50%; width:10px; height:10px; background:red;"></div>


        @foreach($plots as $plot)
            @if($plot->x !== null && $plot->y !== null)
                <a
                    href="{{ route('plot.booking', $plot->id) }}"
                    class="plot {{ $plot->status }}"
                    style="top: {{ $plot->y }}%; left: {{ $plot->x }}%;"
                    title="Plot {{ $plot->plot_no }}"
                >
                    {{ $plot->plot_no }}
                </a>
            @endif
        @endforeach
    </div>
</section>
@endsection
