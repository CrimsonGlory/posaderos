    <script>
        $('#tags').select2({
        placeholder: 'Elegir etiquetas',
        @if (Auth::user()->can('create-tags'))
                tags: true
        @else
                tags: false
        @endif
        });
    </script>

