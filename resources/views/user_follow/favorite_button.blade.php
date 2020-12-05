@if (Auth::id() != $micropost->user_id)
    @if (Auth::user()->is_favorite($micropost->id))
        {{-- お気に入り登録を外すボタンのフォーム --}}
        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-success btn-sm-2"]) !!}
        {!! Form::close() !!}
    @else
        {{-- お気に入り登録ボタンのフォーム --}}
        {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
            {!! Form::submit('favorite', ['class' => "btn btn-light btn-sm-2"]) !!}
        {!! Form::close() !!}
    @endif
@endif