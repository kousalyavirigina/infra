@extends('layouts.app')

@section('title', 'Sale Deeds')

@section('content')

<div style="max-width:98%; margin:30px auto;">

    <h2 style="margin-bottom:14px;">Sale Deeds</h2>

    <div style="
        background:#fff;
        border-radius:14px;
        overflow-x:auto;
        box-shadow:0 10px 30px rgba(0,0,0,.06);
    ">
        <table style="
            width:100%;
            border-collapse:collapse;
            min-width:1300px;
        ">

            <thead>
                <tr style="background:#0A1735;color:#fff;">
                    <th style="padding:12px;">Booking ID</th>
                    <th style="padding:12px;">Plot No</th>
                    <th style="padding:12px;">Customer Name</th>
                    <th style="padding:12px;">Contact</th>
                    <th style="padding:12px;">Email</th>
                    <th style="padding:12px;">Total Paid Amount</th>
                    <th style="padding:12px;">Payment</th>
                    <th style="padding:12px;">Booking Date</th>
                    <th style="padding:12px;">Agreement No</th>
                    <th style="padding:12px;">Completed Date</th>
                    <th style="padding:12px;">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($agreements as $agreement)

                @php
                    $booking = $agreement->booking;
                    $plot = $booking?->plot;

                    $totalPaid =
                        ($booking?->advance_amount ?? 0)
                        + (optional($agreement)->agreement_paid_amount ?? 0);

                @endphp

                <tr style="border-bottom:1px solid #e9eef5;">

                    <td style="padding:16px;text-align:center;">
                        RaKe-{{ $booking?->id ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ $plot?->plot_no ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ $booking?->customer_name ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ $booking?->contact_number ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ $booking?->email ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;font-weight:600;color:#0a8f2f;">
                        ₹ {{ number_format($totalPaid) }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        <span style="
                            background:#1d4ed8;
                            color:#fff;
                            padding:6px 14px;
                            border-radius:18px;
                            font-weight:600;
                            font-size:13px;
                        ">
                            {{ strtoupper($booking?->payment_method ?? '-') }}
                        </span>
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ optional($booking?->booking_date_time)->format('d M Y') ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ $agreement->agreement_number }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        {{ optional($agreement->completed_at)->format('d M Y') ?? '-' }}
                    </td>

                    <td style="padding:16px;text-align:center;">
                        @if($agreement->saleDeed)
                            <a href="{{ route('sale-deeds.show', $agreement->saleDeed->id) }}"
                               style="color:#2563eb;font-weight:600;">
                                View Sale Deed
                            </a>
                        @else
                            <a href="{{ route('sale-deeds.create', $agreement->id) }}"
                               style="color:#2563eb;font-weight:600;">
                                Create Sale Deed
                            </a>
                        @endif
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="11"
                        style="padding:20px;text-align:center;color:#666;">
                        No completed agreements found for Sale Deed.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection
