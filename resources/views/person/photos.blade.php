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
                                <!--<td align="middle">
                                    {!! Form::open(['name'=>'id','class' => 'reset-this', 'method'=> 'POST', 'action' => ['PersonController@setAvatar',$person->id]]) !!}
                                        <input type="hidden" name="fileentry_id"  value="">
                                        <button type="button submit" class="btn btn-default setavatar">
                                            <i class="glyphicon glyphicon-user"></i>
                                            Usar como perfil
                                        </button>
                                    {!! Form::close() !!}
                                </td>-->
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
        @foreach ($images as $image)
            <a href="/file/{{$image->id}}" title="" data-gallery>
                <img src="/file/{{$image->id}}" alt=""  style="max-width:300px; max-height:300px;"/>
            </a>
        @endforeach
    </div>

@endsection

@section('footer')
    <script src="/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="/js/bootstrap-image-gallery.min.js"></script>
    <script type="text/javascript">
        $( "formm" ).submit(function(){
            alert(2);
            // Let's find the input to check
            var $input = $(this).find("input[name=fileentry_id]");
            // Value is falsey (i.e. null), lets set a new one
            $input.val("whatever you want");
        });
    </script>

@endsection
