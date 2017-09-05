@if(count($errors))
    <div class="error" role="alert">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </div>
@endif