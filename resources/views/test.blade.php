@extends('layouts.layout')
@section('title', '日付ページ')

<style>
  th, td {
    border-top: 1px solid gray;
    line-height: 50px;
    text-align: center;
  }

  .attendance-table {
    width: 100%;
    margin: 40px auto;
    border-collapse: collapse;
    table-layout: fixed;
  }
@media screen and (max-width: 480px){
  .attendance-table {
    font-size: 12px;
  }
}

  .button-date {
    border: 1px solid#005FFF;
    padding: 2px 7px;
    color: #005FFF;
    background-color: #fff;
  }
</style>

@section('content')

<div class="content-title mb-20">
  <a class="button-date" href="?date={{$day->copy()->subDay()->format('Ymd')}}">＜</a>
  <h3 class="content-title">{{$day->format('Y-m-d')}}</h3>
  <a class="button-date" href="?date={{$day->copy()->addDay()->format('Ymd')}}">＞</a>
</div>

<p>name</p>
<form action="test" method="post">
  <select name="name" id="name">
@foreach ($items as $item)

    <option value="">{{$item->user->name}}</option>

@endforeach
  </select> 
</form>

<table class="attendance-table">
  <tr>
    {{-- <th>名前</th> --}}
    <th>勤務開始</th>
    <th>勤務終了</th>
    <th>休憩時間</th>
    <th>勤務時間</th>
  </tr>

  @foreach ($items as $item)
  <tr>
    {{-- <td>{{$item->user->name}}</td> --}}
    <td>{{$item->work_start->format('H:i:s')}}</td>
    <td>{{$item->work_finish->format('H:i:s')}}</td>
    <td>{{$item->getRestTime()}}</td>
    <td>{{$item->getWorkTime()}}</td>
  </tr>
@endforeach
</table>
{{$items->appends(request()->input())->links()}}
@endsection