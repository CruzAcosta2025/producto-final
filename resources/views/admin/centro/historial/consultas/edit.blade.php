@extends('layouts.admin-centro')

@section('title', 'Editar Consulta')

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2 class="form-title">Editar Consulta</h2>

        <form action="{{ route('consultas.update', [$historial->id_historial, $consulta->id_consulta]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="motivo_consulta">Motivo de la Consulta:</label>
                <textarea
                    name="motivo_consulta"
                    id="motivo_consulta"
                    rows="3"
                    required>{{ $consulta->motivo_consulta }}</textarea>
            </div>

            <div class="form-group">
                <label for="sintomas">Síntomas:</label>
                <textarea
                    name="sintomas"
                    id="sintomas"
                    rows="3"
                    required>{{ $consulta->sintomas }}</textarea>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones:</label>
                <textarea
                    name="observaciones"
                    id="observaciones"
                    rows="3">{{ $consulta->observaciones }}</textarea>
            </div>

            <div class="form-buttons">
                <a href="{{ route('historial.show', $historial->id_historial) }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Consulta</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Contenedor principal */
    .form-container {
        padding: 20px;
        max-width: 100%;
    }

    /* Tarjeta del formulario */
    .form-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 25px;
        margin: 0 auto;
        max-width: 800px;
        width: 100%;
    }

    /* Título del formulario */
    .form-title {
        color: #333;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e0e0e0;
    }

    /* Grupos de formulario */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #444;
    }

    /* Estilos para inputs y textareas */
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group textarea:focus {
        border-color: #4caf50;
        outline: none;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
    }

    /* Contenedor de botones */
    .form-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Estilos de botones */
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #4caf50;
        color: white;
    }

    .btn-primary:hover {
        background-color: #45a049;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 10px;
        }

        .form-card {
            padding: 15px;
        }

        .form-title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .form-buttons {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            margin: 5px 0;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 5px;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-group textarea {
            padding: 8px;
        }
    }
</style>
@endsection
