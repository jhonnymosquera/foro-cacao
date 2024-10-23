<x-layout>
    <link rel="stylesheet" href="{{ asset('css/resultados.css') }}">


    <div class="grid-resultados" id="eventos-container"></div>

    <script src="{{ asset('js/resultados.js') }}"></script>
    <script>
        setInterval(() => actualizarResultados("{{ route('resultados.eventos') }}"), 1000);
        actualizarResultados("{{ route('resultados.eventos') }}");
    </script>
</x-layout>
