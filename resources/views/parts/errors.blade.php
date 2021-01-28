@if ($errors->{ $errorBag ?? 'default' }->any())
    <ul class="list-reset field mt-3">
        @foreach($errors->{ $errorBag ?? 'default' }->all() as $error)
            <li class="text-sm text-red">{{ $error }}</li>
        @endforeach
    </ul>
@endif
