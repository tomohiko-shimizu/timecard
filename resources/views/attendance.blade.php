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
  <a href="{{route('attendance/{subDay}', ['subDay' => $subDay->format('Y-m-d')])}}" class="button-date">＜</a>
    <h3 class="content-title">{{$day->format('Y-m-d')}}</h3>
  <a href="" class="button-date">＞</a>
</div>

<table class="attendance-table">
  <tr>
    <th>名前</th>
    <th>勤務開始</th>
    <th>勤務終了</th>
    <th>休憩時間</th>
    <th>勤務時間</th>
  </tr>

  @foreach ($items as $item)
  <tr>
    <td>{{$item->user->name}}</td>
    <td>{{$item->work_start->format('H:i:s')}}</td>
    <td>{{$item->work_finish->format('H:i:s')}}</td>
    <td>{{$item->rest->getRestTime()}}</td>
    <td>{{$item->getWorkTime()}}</td>
  </tr>
@endforeach
</table>
{{-- {{$items->links()}} --}}
@endsection