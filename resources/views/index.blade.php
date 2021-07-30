<h2>
  {{ __('Timecard') }}
</h2>
<p>
  {{$user}}さん
</p>

<form action="{{ route('workstart') }}" method="post">
  @csrf
  <button type="submit">出勤</button>
</form>

<form action="{{ route('workfinish') }}" method="post">
  @csrf
  <button type="submit">退勤</button>
</form>

<div>
  <a href="{{route('logout')}}">{{ __('Logout') }}</a>
</div>