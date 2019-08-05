<h4 class="text-danger">Найдены ошибки</h4>
<table class="table table-bordered table-responsive table-sm">
    <thead>
    <tr>
        <td style="width: 2%;"></td>
        <td style="width: 49%;" class="text-center text-dark">A</td>
        <td style="width: 49%;" class="text-center text-dark">B</td>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $r => $rows)
        <tr>
            <td class="text-center text-dark">{{$r}}</td>
            @foreach($rows as $c => $col)
                @if(isset($errors[$r][$c]))
                    <td data-toggle="tooltip" data-placement="top" title="{{$errors[$r][$c]}}"
                        class="text-center text-big text-white bg-danger">{{$col}}</td>
                @else
                    <td class="text-center text-big text-white bg-success">{{$col}}</td>
                @endif

            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>