<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Kafeyin')
                <img src="{{asset('assets/images/logo.png')}}" class="logo" alt="">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
