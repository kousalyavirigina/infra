@extends('layouts.app')

@section('title', 'Agreement of Sale')

@section('content')

{{-- Telugu font only when needed --}}
@if($agreement->language === 'te')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Telugu&display=swap" rel="stylesheet">
@endif

<div class="container my-4">

<style>

/* ===== ACTION BUTTONS ===== */

.action-buttons{
display:flex;
justify-content:center;
gap:15px;
margin-top:25px;
flex-wrap:wrap;
}

/* ===== A4 PAGE ===== */

.a4-page{
width:210mm;
min-height:297mm;
margin:auto;
padding:25mm;
background:#fff;
box-shadow:0 0 10px rgba(0,0,0,.15);

font-family: {{ $agreement->language === 'te'
? '"Noto Sans Telugu", sans-serif'
: '"Times New Roman", serif'
}};

font-size:15px;
line-height:1.9;
color:#000;
}

.a4-page *{
font-family:inherit!important;
}

/* TITLE */

.a4-page h2{
text-align:center!important;
margin-bottom:30px;
}

/* BODY */

.a4-page h3,
.a4-page p,
.a4-page div{
text-align:left!important;
}

/* PRINT MODE */

@media print{

body *{
visibility:hidden;
}

.a4-page,
.a4-page *{
visibility:visible;
}

.a4-page{
position:absolute;
left:0;
top:0;
width:210mm;
height:297mm;
margin:0;
padding:25mm;
box-shadow:none;
}

.no-print{
display:none!important;
}

}

</style>


<div class="a4-page">

{!! $agreement->agreement_html !!}

<!-- ACTION BUTTONS -->

<div class="action-buttons no-print">

@if($agreement->language === 'te')

<a href="{{ route('agreements.word', $agreement) }}"
class="btn btn-primary">
📝 Download Word
</a>

@else

<a href="{{ route('agreements.pdf', $agreement) }}"
class="btn btn-danger">
📄 Download PDF
</a>

@endif

<button onclick="window.print()"
class="btn btn-secondary">

🖨️ Print

</button>

</div>

</div>

</div>

@endsection