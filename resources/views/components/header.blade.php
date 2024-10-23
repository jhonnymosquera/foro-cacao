<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbard {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .nav-item {
        margin-right: 1rem;
    }

    .nav-link {
        color: var(--first-color-light);
        font-size: 1.25rem;
        transition: .3s;
    }

    .nav-link:hover {
        color: var(--white-color);
    }

    .active {
        color: var(--white-color);
    }
</style>

@php
    $eventos = DB::table('eventos')->get();
@endphp

<header class="header" id="header">
    <div class="header_toggle">
        <i class='bx bx-menu' id="header-toggle"></i>
    </div>

    <ul class="navbard mt-2">
        @foreach ($eventos as $e)
            <form action="{{ route('eventos.ver', $e->eve_id) }}" method="POST">
                @csrf
                <button class="btn {{ $e->eve_completado ? 'btn-success' : 'btn-danger' }} rounded p-1">
                    {{ $e->eve_nombre }} </button>
            </form>
        @endforeach
    </ul>


    <div class="row">
        <p>Foro Cacao</p>
    </div>
</header>
