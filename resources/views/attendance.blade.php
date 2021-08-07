<h2>
  {{ __('Attendance') }}
</h2>


<p>昨日{{$subDay}}</p>
<p>{{$day}}</p>
<p>明日{{$addDay}}</p>




<table>
  <tr>
    <th>名前</th>
    <th>開始</th>
    <th>終了</th>
    <th>休憩</th>
    <th>勤務時間</th>
  </tr>
  @foreach($items as $item)
  <tr>
    <td>{{$item->user->name}}</td>
    <td>{{$item->work_start}}</td>
    <td>{{$item->work_finish}}</td>
    <td></td>
    <td></td>
  </tr>
  @endforeach
</table>
