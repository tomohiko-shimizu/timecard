<h2>
  {{ __('Attendance') }}
</h2>

<div>
<a href="{{ route('test') }}">◀</a>
{{$day->format('Y-m-d')}}
<a href="">▶</a>
</div>

<table>
  <tr>
    <th>name</th>
    <th>start</th>
    <th>finish</th>
    {{-- <th>rest</th> --}}
    <th>time worked</th>
  </tr>


  @foreach ($time_worked as $timeworked)
  @foreach ($items as $item)
  <tr>
    <td>{{$item->user->name}}</td>
    <td>{{$item->work_start}}</td>
    <td>{{$item->work_finish}}</td>
    {{-- <td></td> --}}
    <td>{{$timeworked}}</td>
  </tr>
  @endforeach
@endforeach
</table>

<style>
  th, td {
    border-bottom: 1px solid;
    border-right: 1px solid;
  }
</style>