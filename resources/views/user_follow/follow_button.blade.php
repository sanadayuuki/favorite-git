@if(Auth::id() != $user->id)
    @if(Auth::user()->is_followings($user->id))
        {{--アンフォローのボタンフォーム--}}
        {!! Form::open(['route' => ['user.unfollow', $user->id],'method' => 'delete'])!!}
            {!! Form::submit('Unfollow',['class' => "btn btn-danger btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {{--フォローボタンのフォーム--}}
        {!! Form::submit('Follow',['class' => "btn btn-primary btn-block"]) !!}
            {!! Form::submit('Follow',['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif
@endif