<h2>
  {{ __('Timecard') }}
</h2>
<p>
  {{$user->name}}さん

  @if($startedRest)
  退勤済み
  @elseif($startedWork)
  出勤済み
  @else
  出勤ボタンを押してください
  @endif
</p>

<form action="{{ route('workstart') }}" method="post">
  @csrf
  <button type="submit" @if($startedWork) disabled @endif>出勤</button>
</form>

<form action="{{ route('workfinish') }}" method="post">
  @csrf
  <button type="submit" @if($finishedWork) disabled @endif>退勤</button>
</form>

<form action="{{ route('reststart') }}" method="post">
  @csrf
  <button type="submit" @if($startedRest) disabled @endif>休憩開始</button>
</form>

<form action="{{ route('restfinish') }}" method="post">
  @csrf
  <button type="submit" @if($finishedRest) disabled @endif>休憩終了</button>
</form>

<div>
  <a href="{{route('logout')}}">{{ __('Logout') }}</a>
</div>