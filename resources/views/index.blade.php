<h2>
  {{ __('Timecard') }}
</h2>
<p>
  {{$user->name}}さん
  @if ($startedWork)
  出勤済み
  @else
  出勤ボタンを押して下さい
  @endif
</p>

<form action="{{ route('workstart') }}" method="post">
  @csrf
  <button type="submit" 
  @if ($startedWork)
    disabled
  @endif
  >出勤</button>
</form>

<form action="{{ route('workfinish') }}" method="post">
  @csrf
  <button type="submit">退勤</button>
</form>

<div>
  <a href="{{route('logout')}}">{{ __('Logout') }}</a>
</div>