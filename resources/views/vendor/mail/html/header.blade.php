<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://boxit.staging.app/img/logo2581-1.png" class="mail-logo" alt="Boxit Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
