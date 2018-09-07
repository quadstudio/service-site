@if(!is_null($datasheet->date_from))
    С {{monthYear($datasheet->date_from)}} &bull;
    По
    @if(!is_null($datasheet->date_to))
        {{monthYear($datasheet->date_to)}}
    @else
        настоящее время
    @endif
@endif

