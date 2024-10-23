<x-layout>
    <link rel="stylesheet" href="{{ asset('css/resultados.css') }}">


    <div class="grid-resultados" id="eventos-container"></div>

    <script src="{{ asset('js/resultados.js') }}"></script>
    <script>
        setInterval(() => actualizarResultados("https://forocacao.adso.com.co/resultados/eventos"), 1000);
        actualizarResultados("https://forocacao.adso.com.co/resultados/eventos");
    </script>
</x-layout>
