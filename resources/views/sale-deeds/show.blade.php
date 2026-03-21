{!! $saleDeed->content !!}

<br><br>

<a href="{{ route('sale-deeds.download.word', $saleDeed->id) }}">
Download Word
</a>

<button onclick="window.print()">Print</button>
