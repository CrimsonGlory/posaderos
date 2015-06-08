<script>
    $('#tags').select2({
    placeholder: 'Elegir etiquetas',
    @if (Auth::user()->can('add-tag'))
            tags: true
    @else
            tags: false
    @endif
    });
</script>
