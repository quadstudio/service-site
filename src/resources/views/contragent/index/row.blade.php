<tr>
    <td>
        <a href="{{ route('contragents.show', $contragent) }}">{{ $contragent->name }}</a>
    </td>
    <td>
        <a href="{{ route('users.show', $contragent->user) }}">{{ $contragent->user->name }}</a>
    </td>
    <td>
        {{ $contragent->inn }}
    </td>
    <td>{{ $contragent->id }}</td>
</tr>