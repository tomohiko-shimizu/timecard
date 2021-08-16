<h2>
  {{ __('Attendance') }}
</h2>

<div>

<a href="{{route('test/{subDay}', ['subDay' => $subDay->format('Y-m-d')])}}">◀</a>

{{$day->format('Y-m-d')}}

{{-- <a href="{{route('attendance/{addDay}', ['day' => $addDay->format('Y-m-d')])}}">◀</a> --}}

</div>

<table>
  <tr>
    <th>name</th>
    <th>start</th>
    <th>finish</th>
    <th>rest</th>
    <th>time worked</th>

    <th>reststart</th>
    <th>restfinish</th>
  </tr>


  @foreach ($items as $item)
  <tr>
    <td>{{$item->user->name}}</td>
    <td>{{$item->work_start}}</td>
    <td>{{$item->work_finish}}</td>
    <td>{{$item->rest->getRestTime()}}</td>
    <td>{{$item->getWorkTime()}}</td>

    <td>{{$item->rest->rest_start}}</td>
    <td>{{$item->rest->rest_finish}}</td>
  </tr>
@endforeach
</table>

<style>
  th, td {
    border-bottom: 1px solid;
    border-right: 1px solid;
  }
</style>