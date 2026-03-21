@extends('layouts.app')

@section('title','Pay Sale Amount')

@section('content')

<div class="container my-5" style="max-width:900px;">

<div class="card shadow-sm">

<div class="card-body p-4">

<h3 class="text-center fw-bold mb-4 text-dark">
Pay Sale Amount
</h3>

<!-- INFO -->

<div class="row mb-4">

<div class="col-md-6 mb-2">
<b>Plot No:</b> {{ $booking->plot->plot_no }}
</div>

<div class="col-md-6 mb-2">
<b>Customer:</b> {{ $booking->customer_name }}
</div>

<div class="col-md-6 mb-2">
<b>Agreement Date:</b>
{{ $booking->agreement->created_at->format('d-m-Y') }}
</div>

<div class="col-md-6 mb-2">
<b>Due Date:</b>
{{ $booking->agreement->created_at->addDays(45)->format('d-m-Y') }}
</div>

</div>


<!-- FORM -->

<form method="POST" action="{{ route('payments.store', $booking->id) }}">

@csrf

<div class="row g-3">

<!-- TOTAL COST -->

<div class="col-md-6">

<label class="form-label fw-semibold">
Total Plot Cost
</label>

<input type="number"
class="form-control"
name="total_cost"
id="total_cost"
placeholder="Enter total plot cost"
required>

</div>


<!-- ADVANCE -->

<div class="col-md-6">

<label class="form-label fw-semibold">
Advance Paid
</label>

<input type="number"
class="form-control"
id="advance_amount"
value="{{ $booking->advance_amount }}"
readonly>

</div>


<!-- AGREEMENT -->

<div class="col-md-6">

<label class="form-label fw-semibold">
Agreement Paid
</label>

<input type="number"
class="form-control"
id="agreement_amount"
value="{{ $booking->agreement->agreement_paid_amount }}"
readonly>

</div>


<!-- NET BALANCE -->

<div class="col-md-6">

<label class="form-label fw-semibold">
Net Balance
</label>

<input type="number"
class="form-control"
id="net_balance"
value="0"
readonly>

</div>


<!-- PAY SALE -->

<div class="col-md-6">

<label class="form-label fw-semibold">
Pay Sale Amount
</label>

<input type="number"
class="form-control"
name="paid_amount"
placeholder="Enter sale payment"
required>

</div>


<!-- PAYMENT MODE -->

<div class="col-md-6">

<label class="form-label fw-semibold">
Payment Mode
</label>

<select name="payment_mode" class="form-select" required>

<option value="">Payment Mode</option>
<option value="cash">Cash</option>
<option value="upi">UPI</option>
<option value="neft">NEFT</option>
<option value="rtgs">RTGS</option>
<option value="online">Online Transfer</option>

</select>

</div>

</div>


<div class="text-center mt-4">

<button type="submit" class="btn btn-dark px-4 py-2">

Save & Download Receipt

</button>

</div>

</form>

</div>

</div>

</div>


<script>

const totalCostInput  = document.getElementById('total_cost');
const advanceInput    = document.getElementById('advance_amount');
const agreementInput  = document.getElementById('agreement_amount');
const netBalanceInput = document.getElementById('net_balance');

function calculateNetBalance(){

const total     = Number(totalCostInput.value || 0);
const advance   = Number(advanceInput.value || 0);
const agreement = Number(agreementInput.value || 0);

const net = total - (advance + agreement);

netBalanceInput.value = net >= 0 ? net : 0;

}

totalCostInput.addEventListener('input', calculateNetBalance);

calculateNetBalance();

</script>

@endsection