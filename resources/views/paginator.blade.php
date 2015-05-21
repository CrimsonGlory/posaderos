@if ($paginator != null && ($paginator->hasPrevPage || $paginator->hasNextPage))
    <div class="panel-body">
        <table width="100%">
            <tr>
                <td align="right">
                    <nav>
                        <ul class="pagination">
                            {!! $paginator->renderBootstrap('<', '>') !!}
                        </ul>
                    </nav>
                </td>
            </tr>
        </table>
    </div>
@endif
