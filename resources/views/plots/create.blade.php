@extends('layouts.app')

@section('content')
<section class="booking-form">
    <h2>Add New Plot</h2>
    @if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul style="margin:0; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form method="POST" action="{{ route('admin.plots.store') }}">
        @csrf

        <input type="text" name="plot_no" placeholder="Plot No (A-101)" required>
        <input type="number" step="0.01" id="sq_yards" name="sq_yards"
                placeholder="Sq. Yards (eg: 160)">

        <input type="number" step="0.01" id="gadhulu" name="gadhulu"
                placeholder="Gadhulu (eg: 20)">


        <!-- <input type="number" name="sq_yards" placeholder="Sq. Yards (180)" required> -->

        <select name="facing" required>
            <option value="">Select Facing</option>
            <option value="East">East</option>
            <option value="West">West</option>
            <option value="North">North</option>
            <option value="South">South</option>
        </select>

        <input type="number" name="road_width" placeholder="Road Width (30)" required>

        <button type="submit">Save Plot</button>
    </form>


    <script>
const sqYardsInput = document.getElementById('sq_yards');
const gadhuluInput = document.getElementById('gadhulu');

// When Sq.Yards changes → auto-fill Gadhulu
sqYardsInput.addEventListener('input', function () {
    const sq = parseFloat(this.value);
    if (!isNaN(sq)) {
        gadhuluInput.value = (sq / 8).toFixed(2);
    }
});

// When Gadhulu changes → auto-fill Sq.Yards
gadhuluInput.addEventListener('input', function () {
    const gadhi = parseFloat(this.value);
    if (!isNaN(gadhi)) {
        sqYardsInput.value = (gadhi * 8).toFixed(2);
    }
});
</script>

</section>
@endsection
