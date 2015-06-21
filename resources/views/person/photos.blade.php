@extends('app')

@section('header')
    <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/css/blueimp-gallery.css">
    <link rel="stylesheet" href="/css/bootstrap-image-gallery.min.css">
    <link rel="stylesheet" href="/css/reset.css">{{-- Sin esto se enciman los botones  --}}
@endsection

@section('content')
    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="setavatar">x</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <table width="100%">
                            <tr>
                                <td align="left">
                                    <button type="button" class="btn btn-primary prev">
                                        <i class="glyphicon glyphicon-chevron-left"></i>
                                    </button>
                                </td>
                                @if (Auth::user()->can('add-files-to-people') || $person->created_by == Auth::user()->id)
                                    <td align="middle">
                                        {!! Form::open(['id' => 'set_avatar', 'name' => 'set_avatar', 'class' => 'reset-this', 'method'=> 'POST', 'action' => ['PersonController@setAvatar',$person->id]]) !!}
                                            <input type="hidden" name="fileentry_id" class="fileentry_id_class" value="">
                                            <button type="submit" class="btn btn-default setavatar">
                                                <i class="glyphicon glyphicon-user"></i>
                                                {{ trans('messages.useAsProfile') }}
                                            </button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif
                                <td align="right">
                                    <button type="button" class="btn btn-primary next">
                                        <i class="glyphicon glyphicon-chevron-right"></i>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="links">
        <?php
            if(Agent::isDesktop())
            {
                $big = 720;
                $thumb = 205;
            }
            else
            {
                $big = 320;
                $thumb = 72;
            }
        ?>
        @foreach ($images as $image)
            <a href="{{ action("FileEntryController@resize",[$big,$image->id]) }}" title="" data-gallery>
                <img src="{{ action("FileEntryController@thumb",[$thumb,$image->id]) }}" alt=""  style="max-width:205px; max-height:205px;"/>
            </a>
        @endforeach
    </div>

@endsection

@section('footer')
    <script src="/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="/js/bootstrap-image-gallery.min.js"></script>
    <script type="text/javascript">
        document.getElementById('links').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                    link = target.src ? target.parentNode : target,
                    options = {index: link, event: event, onslide: function (index, slide) {
                                  completefileentryinput(index);
                              },},
                    links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };

        {{-- Changes the value of all fileentry_id_class textbox --}}
        function completefileentryinput(index) {
            $( ".fileentry_id_class" ).val(fileentries_ids[index]);
        }

        {{-- Array of FileEntry's ids --}}
        var fileentries_ids = [
            @foreach( $images as $image)
            {{ $image->id }},
            @endforeach
        ];
    </script>
@endsection
