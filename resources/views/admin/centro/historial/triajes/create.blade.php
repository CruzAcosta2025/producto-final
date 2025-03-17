@extends($layout)

@section('title', 'Registrar Triaje')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 20px; width: 95%;">
    <div style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Encabezado -->
        <div style="background: linear-gradient(to right, #3b82f6, #1e40af); padding: 20px;">
            <h2 style="color: #ffffff; font-size: clamp(20px, 4vw, 24px); margin: 0;">Registrar Triaje</h2>
        </div>

        <!-- Contenido del Formulario -->
        <div style="padding: 20px;">
            <form id="triaje-form" action="{{ route('triajes.store', $historial->id_historial) }}" method="POST" novalidate>
                @csrf

                <!-- Paciente -->
                <div style="margin-bottom: 20px;">
                    <p><strong>Paciente:</strong> {{ $historial->paciente->primer_nombre }} {{ $historial->paciente->primer_apellido }}</p>
                </div>

                <!-- Presión Arterial -->
                <div style="margin-bottom: 20px;">
                    <label for="presion_arterial" style="display: block; font-weight: bold; margin-bottom: 8px; color: #374151;">
                        Presión Arterial
                    </label>
                    <input
                        type="text"
                        name="presion_arterial"
                        id="presion_arterial"
                        value="{{ old('presion_arterial') }}"
                        placeholder="Ejemplo: 120/80"
                        style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >
                    <p id="presion_arterial-error" style="color: red; font-size: 14px; display: none;"></p>
                </div>

                <!-- Campos Numéricos -->
                @php
                    $fields = [
                        'temperatura' => ['label' => 'Temperatura (°C)', 'type' => 'number', 'min' => 30, 'max' => 45, 'placeholder' => 'Ejemplo: 36.5'],
                        'frecuencia_cardiaca' => ['label' => 'Frecuencia Cardíaca (LPM)', 'type' => 'number', 'min' => 40, 'max' => 200, 'placeholder' => 'Ejemplo: 72'],
                        'frecuencia_respiratoria' => ['label' => 'Frecuencia Respiratoria (RPM)', 'type' => 'number', 'min' => 10, 'max' => 60, 'placeholder' => 'Ejemplo: 16'],
                        'peso' => ['label' => 'Peso (Kg)', 'type' => 'number', 'min' => 1, 'max' => 300, 'placeholder' => 'Ejemplo: 70.5'],
                        'talla' => ['label' => 'Talla (m)', 'type' => 'number', 'min' => 0.5, 'max' => 2.5, 'placeholder' => 'Ejemplo: 1.75']
                    ];
                @endphp

                @foreach ($fields as $name => $field)
                    <div style="margin-bottom: 20px;">
                        <label for="{{ $name }}" style="display: block; font-weight: bold; margin-bottom: 8px; color: #374151;">
                            {{ $field['label'] }}
                        </label>
                        <input
                            type="{{ $field['type'] }}"
                            name="{{ $name }}"
                            id="{{ $name }}"
                            value="{{ old($name) }}"
                            placeholder="{{ $field['placeholder'] }}"
                            style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #d1d5db; border-radius: 6px;"
                            data-min="{{ $field['min'] }}"
                            data-max="{{ $field['max'] }}"
                        >
                        <p id="{{ $name }}-error" style="color: red; font-size: 14px; display: none;"></p>
                    </div>
                @endforeach

                <!-- Fecha del Triaje -->
                <div style="margin-bottom: 20px;">
                    <label for="fecha_triaje" style="display: block; font-weight: bold; margin-bottom: 8px; color: #374151;">
                        Fecha del Triaje
                    </label>
                    <input
                        type="date"
                        name="fecha_triaje"
                        id="fecha_triaje"
                        value="{{ old('fecha_triaje') }}"
                        style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >
                    <p id="fecha_triaje-error" style="color: red; font-size: 14px; display: none;"></p>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <a href="{{ route('triajes.index', ['dni' => $historial->paciente->dni]) }}"
                        style="padding: 10px 20px; background-color: #6b7280; color: #ffffff; text-decoration: none; border-radius: 4px;">
                        Cancelar
                    </a>
                    <button type="submit"
                        style="padding: 10px 20px; background-color: #1e40af; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('triaje-form');
        const fields = ['temperatura', 'frecuencia_cardiaca', 'frecuencia_respiratoria', 'peso', 'talla'];
        const idPersonalMedico = document.getElementById('id_personal_medico');

        form.addEventListener('submit', (e) => {
            let valid = true;

            // Validar los campos numéricos
            fields.forEach(field => {
                const input = document.getElementById(field);
                const errorElement = document.getElementById(`${field}-error`);
                const value = parseFloat(input.value);
                const min = parseFloat(input.getAttribute('data-min'));
                const max = parseFloat(input.getAttribute('data-max'));

                if (isNaN(value) || value < min || value > max) {
                    valid = false;
                    errorElement.style.display = 'block';
                    errorElement.textContent = `El valor debe estar entre ${min} y ${max}.`;
                } else {
                    errorElement.style.display = 'none';
                }
            });

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
