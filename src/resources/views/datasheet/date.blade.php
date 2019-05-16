@if($datasheet->date_from)
    С {{monthYear($datasheet->date_from->format('d.m.Y'))}} &bull;
    По
    @if($datasheet->date_to)
        {{monthYear($datasheet->date_to->format('d.m.Y'))}}
    @else
        настоящее время
    @endif
@endif

