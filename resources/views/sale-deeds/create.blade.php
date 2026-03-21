@extends('layouts.app')

@section('title', 'Sale Deed')

@section('content')

<style>
.sale-doc {
    max-width: 900px;
    margin: 40px auto;
    padding: 40px;
    background: #fff;
    font-family: "Times New Roman", serif;
    font-size: 15px;
    line-height: 1.9;
    color: #000;
    text-align: justify;
}
.sale-doc h2 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 30px;
}
.sale-doc p {
    text-indent: 40px;
}
.sale-doc h3 {
    margin-top: 25px;
    font-weight: bold;
}
input.inline {
    border: none;
    border-bottom: 1px solid #000;
    font-family: inherit;
    font-size: 15px;
}
input.short { width: 90px; }
input.medium { width: 160px; }
input.long { width: 300px; }

textarea {
    width: 100%;
    min-height: 140px;
    border: 1px solid #000;
    padding: 10px;
    font-family: inherit;
    font-size: 15px;
}

.no-save {
    margin-top: 25px;
}
</style>

<form method="POST"
      action="{{ route('sale-deeds.store', $agreement->id) }}"
      id="saleDeedForm">
@csrf

<div class="sale-doc">

<h2>SALE DEED FOR PLOT</h2>

<p>
THIS DEED OF SALE is made and executed on this the
<input class="inline short"> day of
<input class="inline medium">,
by
</p>

<p>
Sri <input class="inline long"> S/o, D/o, W/o.
<input class="inline long">,
aged about <input class="inline short"> years, Occupation:
<input class="inline long">
Resident of D.No.
<input class="inline long">
</p>

<p>
Represented by his / her agent<br>
Being minor represented by Father/Mother/Brother/Guardian
</p>

<p>
Sri <input class="inline long"> S/o, D/o, W/o.
<input class="inline long">,
aged about <input class="inline short"> years, Occupation:
<input class="inline long">
Residing at
<input class="inline long">
under general / special power of attorney dated
<input class="inline medium">
Registered as Document Number
<input class="inline medium">
of Year
<input class="inline short">
Book I / IV of RO/SRO
<input class="inline medium">.
</p>

<p>
( Hereinafter called the “VENDOR” ).
</p>

<p><b>IN FAVOUR OF</b></p>

<p>
Sri <input class="inline long"> S/o, D/o, W/o.
<input class="inline long">,
aged about <input class="inline short"> years, Occupation:
<input class="inline long">
Resident of D.No.
<input class="inline long">
</p>

<p>
( Hereinafter called the “VENDEE” ).
</p>

<p>
The terms “THE VENDOR” and “THE VENDEE” herein used shall wherever the context so admits mean and include their respective heirs, executors, successors, legal representatives, administrators and assignees etc., as the parties themselves.
</p>

<p>
WHEREAS the Vendor is the sole and absolute owner of the Plot bearing No.
<input class="inline short">,
situated at
<input class="inline long">
(Vill)
<input class="inline long">
(Mandal)
<input class="inline long">
Districts, which was inherited / having acquired through a Sale/Gift/Gift Settlement /Partition/Will deed registered as Document No.
<input class="inline medium">
of S.R.O.
<input class="inline medium">
copied in Volume No.
<input class="inline short">
at Page
<input class="inline short">.
</p>

<p>
WHEREAS the Vendor has offered to sell the above said plot as described in schedule hereunder, which is Free from encumbrances for a total consideration of Rs.
<input class="inline medium">
and the Vendee has agreed to purchase the same for the said consideration.
</p>

<p>
WHEREAS the Vendor has received the said consideration as
<input class="inline long">
</p>

<p>
NOW THEREFORE this Deed of Sale witnesseth that in pursuance of the said agreement and in consideration of the sum of Rs.
<input class="inline medium">
already received by the Vendor from the Vendee the said Vendor as absolute owner of the said property described in the schedule hereto and more clearly delineated in the plan annexed with the boundaries thereof clearly shown in plan annexed does hereby transfer, convey and assign free from encumbrances all the said property to hold the same to the said Vendee as absolute owner together with appurtenances belonging hereto and all the estate, right, title, interest and claim whatsoever of the Vendor in or to the said property hereby conveyed. The Vendee shall hold and enjoy the same as absolute owner.
</p>

<p>
The Vendor hereby covenants with the Vendee as follows:
</p>

<p>1. The said property shall be quietly entered into and upon by the Vendee who shall hold and enjoy the same as absolute owner without any interruption from the Vendor or any persons claiming through the Vendor.</p>

<p>2. The Vendor has given vacant possession of the said property to the Vendee.</p>

<p>3. The Vendor has paid all taxes etc., payable on the said property upto date and the Vendee will have to pay such taxes etc., payable hereafter.</p>

<p>4. The property is free from all encumbrances, charges, mortgages, prior assignments of sale or lease hold or court attachments and it is not subject to any other litigation.</p>

<p>5. The previous title deeds relating to the said property hereby handed over to the Vendee.</p>

<p>6. The Vendor hereby agrees to co-operate with the Vendee to get the title of the said property changed in the name of the Vendee in Revenue Records.</p>

<p>7. The Vendor does hereby further agree with the Vendee at all times hereafter at the cost of the Vendee to do and execute all such lawful acts, deeds and things for further and more perfectly assuring the said property to the Vendee according to the true intent and meaning of this deed.</p>

<p>8. The Vendor does hereby agree to keep indemnified the Vendee from and against all losses, costs, damages and expenses, which the Vendee may sustain by reason of anybody to the said property.</p>

<p>9. The land is not an assigned land within the meaning of A.P. Assigned lands (Prohibition of Transfers) Act 9 of 1977 and it does not belong to or under mortgage to Govt. Agencies/Undertakings.</p>

<p>10. There is no House or any constructions in the said site.</p>

<h3>SCHEDULE OF PROPERTY</h3>

<textarea>
Plot No: {{ $agreement->booking->plot->plot_no }}
</textarea>

<p>
IN WITNESS WHEREOF, the Vendor hereunto has set his hand to this Deed of Sale with his free will and sound mind on the day, month and year first above mentioned in the presence of the following witnesses.
</p>

<p><b>SIGNATURE OF THE VENDOR</b></p>

<p><b>WITNESSES :</b></p>
<p>1.</p>
<p>2.</p>

<button type="submit" class="no-save">SAVE SALE DEED</button>

</div>

<input type="hidden" name="sale_deed_date" value="{{ now()->toDateString() }}">
<input type="hidden" name="content" id="sale_deed_html">

</form>

<script>
document.getElementById('saleDeedForm').addEventListener('submit', function () {

    const doc = document.querySelector('.sale-doc').cloneNode(true);
    doc.querySelectorAll('.no-save').forEach(el => el.remove());

    doc.querySelectorAll('input').forEach(i => {
        const span = document.createElement('span');
        span.textContent = i.value || '__________';
        i.replaceWith(span);
    });

    doc.querySelectorAll('textarea').forEach(t => {
        const div = document.createElement('div');
        div.textContent = t.value || '__________';
        t.replaceWith(div);
    });

    document.getElementById('sale_deed_html').value = doc.outerHTML;
});
</script>

@endsection
