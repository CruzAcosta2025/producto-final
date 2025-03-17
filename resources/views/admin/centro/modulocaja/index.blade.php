@extends($layout)

@section('title', 'Gestión de Caja')

@section('content')
    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
            <!-- Encabezado -->
            <!-- Encabezado -->
            <div
                style="background: linear-gradient(to right, #10b981, #059669); padding: 20px; display: flex; justify-content: space-between; align-items: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 1.5rem;">Gestión de Caja</h1>

                <!-- Botones de Acción -->
                <div style="display: flex; gap: 10px;">
                    <!-- Botón de Sincronización -->
                    <form action="{{ route('modulocaja.sincronizar') }}" method="POST">
                        @csrf
                        <button type="submit"
                            style="background-color: #ffffff; color: #059669; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                            Sincronizar Transacciones
                        </button>
                    </form>

                    <!-- Botón de Crear Transacción -->
                    <a href="{{ route('modulocaja.create') }}"
                        style="background-color: #ffffff; color: #059669; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; border: 1px solid #059669; display: inline-block;">
                        Crear Transacción
                    </a>
                </div>
            </div>


            <!-- Contenido -->
            <div style="padding: 20px;">
                <!-- Filtros -->
                <form method="GET" action="{{ route('modulocaja.index') }}" style="margin-bottom: 20px;">
                    <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; margin-bottom: 5px;">Tipo de Transacción</label>
                            <select name="tipo_transaccion"
                                style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;">
                                <option value="">Todos</option>
                                <option value="INGRESO" {{ request('tipo_transaccion') == 'INGRESO' ? 'selected' : '' }}>
                                    Ingreso</option>
                                <option value="EGRESO" {{ request('tipo_transaccion') == 'EGRESO' ? 'selected' : '' }}>
                                    Egreso</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; margin-bottom: 5px;">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio"
                                style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;"
                                value="{{ request('fecha_inicio') }}">
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; margin-bottom: 5px;">Fecha Fin</label>
                            <input type="date" name="fecha_fin"
                                style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;"
                                value="{{ request('fecha_fin') }}">
                        </div>
                        <div style="display: flex; align-items: flex-end; min-width: 200px;">
                            <button type="submit"
                                style="background-color: #10b981; color: #ffffff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tabla de Transacciones -->
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead>
                            <tr style="background-color: #f3f4f6;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Fecha</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Tipo</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Monto</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Descripción
                                </th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transacciones as $transaccion)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px;">{{ $transaccion->fecha_transaccion }}</td>
                                    <td style="padding: 12px;">
                                        <span
                                            style="padding: 5px 10px; border-radius: 4px;
                                        background-color: {{ $transaccion->tipo_transaccion == 'INGRESO' ? '#10b981' : '#ef4444' }};
                                        color: white; font-size: 0.8rem;">
                                            {{ $transaccion->tipo_transaccion }}
                                        </span>
                                    </td>
                                    <td
                                        style="padding: 12px; font-weight: bold;
                                    color: {{ $transaccion->tipo_transaccion == 'INGRESO' ? '#10b981' : '#ef4444' }};">
                                        {{ number_format($transaccion->monto, 2) }}
                                    </td>
                                    <td style="padding: 12px;">{{ $transaccion->descripcion }}</td>
                                    <td style="padding: 12px;">
                                        <div style="display: flex; gap: 10px;">
                                            <a href="{{ route('modulocaja.edit', $transaccion->id_transaccion) }}"
                                                style="background-color: #f59e0b; color: white; text-decoration: none; padding: 6px 12px; border-radius: 4px;">
                                                Editar
                                            </a>
                                            <form action="{{ route('modulocaja.destroy', $transaccion->id_transaccion) }}"
                                                method="POST" style="display:inline-block; margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background-color: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;"
                                                    onclick="return confirm('¿Está seguro de eliminar esta transacción?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: center; margin-top: 20px;">
                    {{ $transacciones->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
