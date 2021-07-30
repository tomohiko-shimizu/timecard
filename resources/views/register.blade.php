<p>test</p>
@if(count($errors) > 0)
<p>入力に問題があります</p>
@endif
<form action="/register" method="post">
  <table>
    @csrf

    @if($errors->has('name'))
    <tr>
      <th>ERROR</th>
      <td>
        {{$errors->first('name')}}
      </td>
    </tr>
    @endif

    <tr>
      <th>name: </th>
      <td><input type="text" name="name"></td>
    </tr>

    @if($errors->has('email'))
    <tr>
      <th>ERROR</th>
      <td>
        {{$errors->first('email')}}
      </td>
    </tr>
    @endif

    <tr>
      <th>mail: </th>
      <td><input type="text" name="email"></td>
    </tr>

    @if($errors->has('password'))
    <tr>
      <th>ERROR</th>
      <td>
        {{$errors->first('password')}}
      </td>
    </tr>
    @endif

    <tr>
      <th>pass: </th>
      <td><input type="password" name="password"></td>
    </tr>
    <tr>
      <th>confirm: </th>
      <td><input type="password" name="password_confirmation"></td>
    </tr>
    <tr>
      <th></th>
      <td><input type="submit" value="send"></td>
    </tr>
  </table>
</form>

<div>
  <a href="/login">{{ __('登録済みの場合はログイン') }}</a>
</div>