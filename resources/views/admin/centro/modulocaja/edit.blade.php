@extends($layout)

@section('title', 'Editar Transacción')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Encabezado -->
        <div style="background: linear-gradient(to right, #10b981, #059669); padding: 20px;">
            <h2 style="color: #ffffff; margin: 0; text-align: center; font-size: 1.5rem;">
                Editar Transacción
            </h2>
        </div>

        <!-- Contenido del Formulario -->
        <form action="{{ route('modulocaja.update', $transaccion->id_transaccion) }}" method="POST" style="padding: 20px;">
            @csrf
            @method('PUT')

            <!-- Tipo de Transacción -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Tipo de Transacción
                </label>
                <select name="tipo_transaccion" id="tipo_transaccion"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; appearance: none;"
                    required>
                    <option value="INGRESO" {{ $transaccion->tipo_transaccion == 'INGRESO' ? 'selected' : '' }}>Ingreso</option>
                    <option value="EGRESO" {{ $transaccion->tipo_transaccion == 'EGRESO' ? 'selected' : '' }}>Egreso</option>
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
                        value="{{ $transaccion->monto }}"
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
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; min-height: 100px; resize: vertical;">{{ $transaccion->descripcion }}</textarea>
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
                    Guardar Cambios
                </button>
                <a href="{{ route('modulocaja.index') }}"
                    style="background-color: #6b7280; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; display: inline-block;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
