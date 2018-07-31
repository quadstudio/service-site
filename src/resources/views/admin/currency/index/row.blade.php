<tr>
    <td></td>
    <td><a href="{{route('admin.currencies.show', $currency)}}">{{ $currency->name }}</a></td>
    <td class="d-none d-sm-table-cell">{{ $currency->title }}</td>
    <td class="text-right">{{ $currency->rates }}</td>
    <td class="d-none d-sm-table-cell text-center">{{ $currency->id }}</td>
</tr>