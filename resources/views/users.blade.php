@foreach($users as $key => $user)
<tr>
    <td>{{$key + 1}}</td>
     <td>{{$user->username}}</td>
     <td>
         <form action="/chat" method="post">
            @csrf
            <input type="hidden" name="username" value="{{$user->username}}">
            <button class="btn btn-dark">start chat</button>    
        </form>
     </td>
</tr>
@endforeach