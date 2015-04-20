@extends('app')
@section('content')

    <form action="{{route('addentry', [])}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="file" name="filefield">
        <input type="submit">
    </form>

    <h1> Pictures list</h1>

    <div class="row">
        <ul class="thumbnails">
            @foreach($entries as $entry)
                <img src="{{ $entry->filename }}" alt="No Photo" class="img-responsive" style="width:100px; height:100px;"/>
                <div class="caption">
                    <p>{{$entry->filename}}</p>
                </div>
            @endforeach
        </ul>
    </div>

@endsection