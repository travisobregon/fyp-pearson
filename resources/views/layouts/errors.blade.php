@if (count($errors))
    <div class="ui error message visible" style="margin-top: 0">
        <div class="header">Whoops!</div>

        <ul class="list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif