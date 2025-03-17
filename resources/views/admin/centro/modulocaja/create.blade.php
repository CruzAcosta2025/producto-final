@extends($layout)

@section('title', 'Registrar Transacción')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Encabezado -->
        <div style="background: linear-gradient(to right, #10b981, #059669); padding: 20px;">
            <h2 style="color: #ffffff; margin: 0; text-align: center; font-size: 1.5rem;">
                Registrar Nueva Transacción
            </h2>
        </div>

        <!-- Contenido del Formulario -->
        <form action="{{ route('modulocaja.store') }}" method="POST" style="padding: 20px;">
            @csrf
            <!-- Tipo de Transacción -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Tipo de Transacción
                </label>
                <select name="tipo_transaccion" id="tipo_transaccion"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; appearance: none;"
                    required>
                    <option value="">Seleccione...</option>
                    <option value="INGRESO">Ingreso</option>
                    <option value="EGRESO">Egreso</option>
                </select>
                @error('tipo_transaccion')
                    <span style="color: #ef4444; font-size: 0.875rem; display: block; margin-top: 5px;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Monto -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Monto
                </label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 10px; top: 12px; color: #6b7280;">S/</span>
                    <input type="number" step="0.01" name="monto" id="monto"
                        style="width: 100%; padding: 10px 10px 10px 30px; border: 1px solid #d1d5db; border-radius: 4px;"
                        required>
                </div>
                @error('monto')
                    <span style="color: #ef4444; font-size: 0.875rem; display: block; margin-top: 5px;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Descripción -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Descripción
                </label>
                <textarea name="descripcion" id="descripcion"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; min-height: 100px; resize: vertical;"
                    placeholder="Ingrese una descripción detallada..."></textarea>
                @error('descripcion')
                    <span style="color: #ef4444; font-size: 0.875rem; display: block; margin-top: 5px;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Botones -->
            <div style="display: flex; justify-content: center; gap: 15px; margin-top: 20px;">
                <button type="submit"
                    style="background-color: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;">
                    Registrar
                </button>
                <a href="{{ route('modulocaja.index') }}"
                    style="background-color: #6b7280; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; display: inline-block;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Validación adicional del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const tipoTransaccion = document.getElementById('tipo_transaccion');
        const monto = document.getElementById('monto');
        const descripcion = document.getElementById('descripcion');

        let valid = true;

        if (!tipoTransaccion.value) {
            tipoTransaccion.style.borderColor = '#ef4444';
            valid = false;
        } else {
            tipoTransaccion.style.borderColor = '#d1d5db';
        }

        if (!monto.value || parseFloat(monto.value) <= 0) {
            monto.style.borderColor = '#ef4444';
            valid = false;
        } else {
            monto.style.borderColor = '#d1d5db';
        }

        if (!descripcion.value.trim()) {
            descripcion.style.borderColor = '#ef4444';
            valid = false;
        } else {
            descripcion.style.borderColor = '#d1d5db';
        }

        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos correctamente.');
        }
    });
</script>
@endsection
