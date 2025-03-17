@extends($layout)

@section('title', 'Triajes')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px; width: 95%;">
    <div style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div style="background: linear-gradient(to right, #10b981, #059669); padding: 20px;">
            <h2 style="color: #ffffff; font-size: clamp(20px, 4vw, 28px); margin: 0;">Listado de Triajes</h2>
        </div>
        <div style="padding: 20px;">
            <!-- Buscador DNI -->
            <form method="GET" action="{{ route('triajes.index') }}" style="margin-bottom: 20px;">
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <input
                        type="text"
                        name="dni"
                        value="{{ $dni }}"
                        placeholder="Buscar por DNI"
                        style="flex: 1; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 16px;"
                    >
                    <button
                        type="submit"
                        style="padding: 10px 20px; background-color: #059669; color: #ffffff; border: none; border-radius: 6px; cursor: pointer; font-size: 16px;">
                        Buscar
                    </button>
                </div>
            </form>

            @if ($paciente)
                <h3 style="margin-bottom: 20px; font-size: clamp(16px, 3vw, 20px);">
                    Paciente: {{ $paciente->paciente->primer_nombre }} {{ $paciente->paciente->primer_apellido }}
                </h3>
                <a href="{{ route('triajes.create', $paciente->id_historial) }}"
                   style="display: inline-block; padding: 10px 20px; background-color: #059669; color: #ffffff; text-decoration: none; border-radius: 6px; margin-bottom: 20px;">
                    Nuevo Triaje
                </a>

                @if ($triajes->isEmpty())
                    <p style="color: #6b7280; font-size: clamp(14px, 2vw, 16px);">No hay registros de triaje.</p>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                            <thead>
                                <tr style="background-color: #f3f4f6;">
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Fecha</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Peso</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Talla</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">IMC</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Temperatura</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Presión Arterial</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Frecuencia Cardíaca</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Frecuencia Respiratoria</th>
                                    <th style="padding: 12px; border-bottom: 2px solid #e5e7eb; text-align: left;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($triajes as $triaje)
                                    <tr>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->fecha_triaje }}</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->peso }}</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->talla }}</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->imc }}</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->temperatura }}°C</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->presion_arterial }}</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->frecuencia_cardiaca }} LPM</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">{{ $triaje->frecuencia_respiratoria }} RPM</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">
                                            <div style="display: flex; justify-content: space-around;">
                                                <a href="{{ route('triajes.edit', [$triaje->id_historial, $triaje->id_triaje]) }}"
                                                   style="padding: 6px 12px; background-color: #f59e0b; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                                    Editar
                                                </a>

                                                <form method="POST" action="{{ route('triajes.destroy', [$triaje->id_historial, $triaje->id_triaje]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        style="padding: 6px 12px; background-color: #ef4444; color: #ffffff; border: none; border-radius: 6px; cursor: pointer;">
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
                @endif
            @elseif ($dni)
                <p style="color: #ef4444;">No se encontró ningún paciente con el DNI ingresado.</p>
            @else
                <p style="color: #6b7280;">Ingrese un DNI para buscar un paciente.</p>
            @endif
        </div>
    </div>
</div>
@endsection
