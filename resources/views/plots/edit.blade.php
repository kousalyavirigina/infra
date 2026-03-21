@extends('layouts.app')

@section('title', 'Edit Plot')

@section('content')
<section style="padding:40px; display:flex; justify-content:center;">

    <div style="
        width:600px;
        background:#fff;
        padding:30px;
        border-radius:12px;
        box-shadow:0 10px 30px rgba(0,0,0,0.1);
    ">

        <h2 style="text-align:center; margin-bottom:25px;">
            Edit Plot {{ $plot->plot_no }}
        </h2>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div style="color:red; margin-bottom:15px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.plots.update', $plot->id) }}">
            @csrf
            @method('PUT')

            {{-- Plot No --}}
            <label>Plot No</label>
            <input type="text"
                   name="plot_no"
                   value="{{ old('plot_no', $plot->plot_no) }}"
                   required
                   style="width:100%; padding:10px; margin-bottom:15px;">

            {{-- Sq Yards --}}
            <label>Sq. Yards</label>
            <input type="number"
                   name="sq_yards"
                   value="{{ old('sq_yards', $plot->sq_yards) }}"
                   style="width:100%; padding:10px; margin-bottom:15px;">

            {{-- Gadhulu --}}
            <label>Gadhulu</label>
            <input type="number"
                   step="0.01"
                   name="gadhulu"
                   value="{{ old('gadhulu', $plot->gadhulu) }}"
                   style="width:100%; padding:10px; margin-bottom:15px;">

            {{-- Facing --}}
            <label>Facing</label>
            <select name="facing"
                    required
                    style="width:100%; padding:10px; margin-bottom:15px;">
                <option value="East"  {{ $plot->facing == 'East' ? 'selected' : '' }}>East</option>
                <option value="West"  {{ $plot->facing == 'West' ? 'selected' : '' }}>West</option>
                <option value="North" {{ $plot->facing == 'North' ? 'selected' : '' }}>North</option>
                <option value="South" {{ $plot->facing == 'South' ? 'selected' : '' }}>South</option>
            </select>

            {{-- Road Width --}}
            <label>Road Width (ft)</label>
            <input type="number"
                   name="road_width"
                   value="{{ old('road_width', $plot->road_width) }}"
                   required
                   style="width:100%; padding:10px; margin-bottom:25px;">

            <label>Status</label>
            <select name="status" required>
                <option value="available" {{ $plot->status === 'available' ? 'selected' : '' }}>
                    Available
                    </option>
                    <option value="booked" {{ $plot->status === 'booked' ? 'selected' : '' }}>
                    Booked
                </option>
            </select>



            {{-- Buttons --}}
            <div style="display:flex; justify-content:space-between;">
                <a href="{{ route('admin.plots.index') }}"
                   style="text-decoration:none; padding:10px 20px; background:#ccc; border-radius:6px;">
                    Cancel
                </a>

                <button type="submit"
                        style="padding:10px 25px; background:#0A1735; color:white; border:none; border-radius:6px;">
                    Update Plot
                </button>
            </div>

        </form>

    </div>

</section>
@endsection
