@if(count($errors) > 0 )
<div class="bg-danger alert text-white alert-dismissible fade show" role="alert">
    <ul class="p-0 m-0" style="list-style: none;">
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
