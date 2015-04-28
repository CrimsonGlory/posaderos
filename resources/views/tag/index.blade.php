@extends('app')

@section('content')
<h1>Etiquetas</h1>
<div class="form-group">
    @if  (count($tags) > 0 )
        <ul>
            @foreach ($tags as $tag)
                <div class="form-group">
                    <li> 
                        <a href="{{ action('TagController@show',$tag) }}">
                            {{ucfirst($tag)}}
                        </a>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif
</div>

@endsection
