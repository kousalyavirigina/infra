@extends('layouts.app')

@section('title', 'Agreement Of Sale')

@section('content')

<div class="container my-4">

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif


<!-- LANGUAGE SELECT -->
<div class="text-center mb-4">

<label class="fw-bold me-3">Agreement Language:</label>

<div class="form-check form-check-inline">
    <input class="form-check-input"
           type="radio"
           name="agreement_language"
           value="en"
           checked>
    <label class="form-check-label">English</label>
</div>

<div class="form-check form-check-inline">
    <input class="form-check-input"
           type="radio"
           name="agreement_language"
           value="te">
    <label class="form-check-label">తెలుగు</label>
</div>

</div>


<form id="agreementForm"
method="POST"
action="{{ route('agreements.store', $booking->id) }}">

@csrf

<input type="hidden" name="agreement_language" id="agreement_language" value="en">

<div class="card shadow-sm">

<div class="card-body agreement-doc">

<h2>AGREEMENT OF SALE</h2>

<p>
THIS AGREEMENT OF SALE is made and executed on this the
<input class="inline short" name="day"> day
<input class="inline short" name="month">
of
<input class="inline short" name="year">
</p>

<p><b>BETWEEN</b></p>

<p>
Mr.
<input class="inline long" name="seller_name">
s/o.
<input class="inline long" name="seller_father">
aged
<input class="inline short" name="seller_age">
years residing at
<input class="inline long" name="seller_address">
</p>

<p><b>AND</b></p>

<p>
Mr.
<input class="inline long"
name="purchaser_name"
value="{{ $booking->customer_name }}">

s/o
<input class="inline long"
name="purchaser_father"
value="{{ $booking->father_name }}">

aged
<input class="inline short"
name="purchaser_age">

years residing at
<input class="inline long"
name="purchaser_address">
</p>


<!-- PROPERTY SCHEDULE -->

<h5 class="mt-4">SCHEDULE</h5>

<textarea class="form-control mb-3"
name="schedule_of_property">

Plot No: {{ $booking->plot->plot_no }}

</textarea>


<p>
Signed by SELLER _____________
</p>

<p>
Signed by PURCHASER _____________
</p>

<hr class="my-4">

<!-- PAYMENT DETAILS -->

<h5 class="mb-3">Agreement Payment</h5>

<div class="row g-3">

<div class="col-md-4">
<label class="form-label fw-bold">
Agreement Paid Amount <span class="text-danger">*</span>
</label>

<div class="input-group">
<span class="input-group-text">₹</span>

<input type="number"
class="form-control"
name="agreement_paid_amount"
required
min="1">

</div>
</div>


<div class="col-md-4">

<label class="form-label fw-bold">
Payment Mode <span class="text-danger">*</span>
</label>

<select class="form-select"
name="payment_mode"
id="payment_mode"
required>

<option value="">Select Payment Mode</option>
<option value="cash">Cash</option>
<option value="upi">UPI</option>
<option value="cheque">Cheque</option>
<option value="neft">NEFT</option>
<option value="rtgs">RTGS</option>
<option value="online">Online Transfer</option>

</select>

</div>

</div>


<div id="payment-extra"
class="row g-3 mt-2"
style="display:none;">

<div class="col-md-4">

<label class="form-label">Reference / UTR / Cheque No</label>

<input type="text"
class="form-control"
name="reference_no">

</div>


<div class="col-md-4">

<label class="form-label">Bank Name</label>

<input type="text"
class="form-control"
name="bank_name">

</div>

</div>


<div class="text-center mt-4">

<button type="submit"
class="btn btn-primary px-4 no-save">

SAVE AGREEMENT

</button>

</div>

</div>
</div>


<input type="hidden" name="agreement_html" id="agreement_html">
<input type="hidden" name="agreement_date" value="{{ now()->toDateString() }}">
<input type="hidden" name="agreement_number" value="RAKE-AGR-{{ $booking->id }}">

</form>

</div>


<style>

/* KEEP DOCUMENT STYLE */

.agreement-doc{
max-width:900px;
margin:auto;
font-family:"Times New Roman",serif;
font-size:15px;
line-height:1.9;
text-align:justify;
}

.agreement-doc p{
text-indent:40px;
}

input.inline{
border:none;
border-bottom:1px solid #000;
font-family:inherit;
font-size:15px;
width:180px;
}

input.short{width:100px;}
input.long{width:300px;}

textarea{
font-family:inherit;
font-size:15px;
}

</style>


<script>

document.getElementById('agreementForm').addEventListener('submit',function(){

const agreement=document.querySelector('.agreement-doc').cloneNode(true);

agreement.querySelectorAll('.no-save').forEach(el=>el.remove());

agreement.querySelectorAll('input,textarea,select').forEach(el=>{

const span=document.createElement('span');

span.textContent=el.value||'__________';

el.replaceWith(span);

});

document.getElementById('agreement_html').value=agreement.outerHTML;

});


document.getElementById('payment_mode').addEventListener('change',function(){

document.getElementById('payment-extra').style.display=

this.value && this.value!=='cash'?'block':'none';

});

</script>


@endsection