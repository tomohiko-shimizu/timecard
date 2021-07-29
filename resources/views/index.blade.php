<h2>
  {{ __('Timecard') }}
</h2>
<p>
  {{$user}}さん
</p>
<p>

</p>
<form action="{{ route('workstart') }}" method="post">
  @csrf
  <button type="submit">出勤</button>
</form>

<form action="{{ route('workfinish') }}" method="post">
  @csrf
  <button type="submit">退勤</button>
</form>