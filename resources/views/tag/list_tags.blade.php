<?php $tags=""; ?>
@foreach ($tagNames as $tag)
   <?php $tags.="<a href=\"".url('/tag/'.$tag)."\">".$tag."</a>, "; ?>
@endforeach
{!! rtrim($tags,", ") !!}
