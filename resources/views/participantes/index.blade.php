<style>
    input {
        width: 80px !important;
    }

    .eventos {
        width: 300px;
        margin-bottom: 1rem;
    }

    .btn-eventos {}
</style>

<x-layout>
    <div class="mb-3">
        <form action="{{ route('eventos.completar', $evento->eve_id) }}" method="POST" class="formularioAlerta"
            data-form="save">
            @csrf
            <button class="btn btn-success btn-eventos">
                Completar {{ $evento->eve_nombre }} <i class="bi bi-check-circle"></i>
            </button>
        </form>
    </div>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th class="col-2">Nombre</th>
                <th class="col-1">Minutos</th>
                <th class="col-1">Segundos</th>
                <th class="col-8">Guardar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participantes as $p)
                @php
                    $registrado = $p->par_minutos > 0 || $p->par_segundos > 0;
                @endphp

                <tr>
                    <form action="{{ route('participantes.update', $p->par_id) }}" method="POST"
                        class="formularioAlerta" data-form="update">
                        @csrf
                        @method('PUT')

                        <td>{{ $p->equ_nombre }}</td>

                        <td class="form-group">
                            <div class="col-1">
                                @if ($registrado)
                                    <input class="form-control" type="number" name="minutos"
                                        value="{{ $p->par_minutos }}" min="0" max="59" readonly>
                                @else
                                    <input class="form-control" type="number" name="minutos"
                                        value="{{ $p->par_minutos }}" min="0" max="59">
                                @endif
                            </div>
                        </td>

                        <td class="form-group">
                            <div class="col-1">
                                @if ($registrado)
                                    <input class="form-control" type="number" name="segundos"
                                        value="{{ $p->par_segundos }}" min="0" max="59" readonly>
                                @else
                                    <input class="form-control" type="number" name="segundos"
                                        value="{{ $p->par_segundos }}" min="0" max="59">
                                @endif
                            </div>
                        </td>

                        <td>
                            @if ($registrado)
                                <button class="btn btn-success" disabled>
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            @else
                                <button class="btn btn-danger">
                                    <i class="bi bi-plus-circle"></i>
                                </button>
                            @endif
                        </td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
