@extends('layouts.app')

@section('title', 'అమ్మకపు ఒప్పందం')

@section('content')

<div class="container my-4">

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif


<div class="text-center mb-4">

<label class="fw-bold me-3">
ఒప్పంద భాష:
</label>

<div class="form-check form-check-inline">
<input class="form-check-input"
       type="radio"
       onclick="window.location='?lang=en'">
<label class="form-check-label">
English
</label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input"
       type="radio"
       checked>
<label class="form-check-label">
తెలుగు
</label>
</div>

</div>


<form id="agreementForm"
method="POST"
action="{{ route('agreements.store', $booking->id) }}">

@csrf

<input type="hidden" name="agreement_language" value="te">

<div class="card shadow-sm">
<div class="card-body agreement-doc">

<h2 class="text-center mb-4">అమ్మకపు ఒప్పందం</h2>

<p>
ఈ అమ్మకపు ఒప్పందం ఈ తేదీన చేయబడినది
<input class="inline short" name="day"> రోజు
<input class="inline short" name="month">
న
<input class="inline short" name="year">
</p>

<p><b>మధ్య</b></p>

<p>
శ్రీ
<input class="inline long" name="seller_name">

తండ్రి
<input class="inline long" name="seller_father">

వయస్సు
<input class="inline short" name="seller_age">

సంవత్సరాలు, నివాసం
<input class="inline long" name="seller_address">
</p>

<p><b>మరియు</b></p>

<p>
శ్రీ
<input class="inline long"
name="purchaser_name"
value="{{ $booking->customer_name }}">

తండ్రి
<input class="inline long"
name="purchaser_father"
value="{{ $booking->father_name }}">

వయస్సు
<input class="inline short"
name="purchaser_age">

సంవత్సరాలు, నివాసం
<input class="inline long"
name="purchaser_address">
</p>

<p>
అమ్మక ధర రూ.
<input class="inline short" name="sale_amount">
(రూపాయలు
<input class="inline long" name="sale_amount_words">
మాత్రమే)
</p>


<h5 class="mt-4">షెడ్యూల్</h5>

<textarea class="form-control mb-3"
name="schedule_of_property">

ప్లాట్ నం: {{ $booking->plot->plot_no }}

</textarea>

<p>సాక్షులు:</p>

<p>1.</p>
<p>2.</p>

<p>అమ్మకందారు సంతకం _____________</p>
<p>కొనుగోలుదారు సంతకం _____________</p>


<div class="text-center mt-4">
<button type="submit"
class="btn btn-primary no-save">

ఒప్పందాన్ని సేవ్ చేయండి

</button>
</div>

</div>
</div>


<input type="hidden" name="agreement_html" id="agreement_html">

<input type="hidden"
name="agreement_date"
value="{{ now()->toDateString() }}">

<input type="hidden"
name="agreement_number"
value="RAKE-AGR-{{ $booking->id }}">

</form>

</div>


<style>

.agreement-doc{
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

agreement.querySelectorAll('input').forEach(input=>{

const span=document.createElement('span');

span.textContent=input.value||'__________';

input.replaceWith(span);

});

agreement.querySelectorAll('textarea').forEach(textarea=>{

const div=document.createElement('div');

div.textContent=textarea.value||'__________';

textarea.replaceWith(div);

});

document.getElementById('agreement_html').value=agreement.outerHTML;

});

</script>


<script src="https://www.google.com/jsapi"></script>

<script>

google.load("elements","1",{packages:"transliteration"});

google.setOnLoadCallback(function(){

const options={

sourceLanguage:google.elements.transliteration.LanguageCode.ENGLISH,

destinationLanguage:[
google.elements.transliteration.LanguageCode.TELUGU
],

shortcutKey:'ctrl+g',

transliterationEnabled:true

};

const control=new google.elements.transliteration.TransliterationControl(options);

const fields=document.querySelectorAll('input.inline, textarea');

control.makeTransliteratable(Array.from(fields));

});

</script>

@endsection