@if($datasheet->date_from)
    С {{monthYear($datasheet->date_from)}} -
@endif
По
@if($datasheet->date_to)
    {{monthYear($datasheet->date_to)}}
@else
    настоящее время
@endif
