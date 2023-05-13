<div class="alert alert-danger" role="alert">
    @if ($messages)
        <ul class="mb-0">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>
