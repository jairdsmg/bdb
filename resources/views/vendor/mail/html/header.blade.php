<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Aplicação Teste') <!-- se o nome do app.name cadastrado no .env for diferente, nao trará o logo no email, mas somente o nome da aplicação-->
<img src="http://localhost:8000/img/logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
