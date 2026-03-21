@extends('layouts.app')

@section('title', 'Deleted Plots')

@section('content')
<section style="padding:40px">

    <h2>Deleted Plots</h2>

    <table border="1" cellpadding="10" width="100%">
        <tr>
            <th>Plot No</th>
            <th>Facing</th>
            <th>Actions</th>
        </tr>

        @forelse($plots as $plot)
        <tr>
            <td>{{ $plot->plot_no }}</td>
            <td>{{ $plot->facing }}</td>
            <td>
                <form action="{{ route('admin.plots.restore', $plot->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">Restore</button>
                </form>

                <form action="{{ route('admin.plots.forceDelete', $plot->id) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Delete permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:red">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No deleted plots</td>
        </tr>
        @endforelse
    </table>

</section>
@endsection
