@extends('layouts.admin-centro')

@section('title', 'Editar Horario Médico')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-indigo-700">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Horario Médico</h2>
        </div>

        <form action="{{ route('horarios.update', $horario->id_horario) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="id_personal_medico" class="block text-lg font-semibold text-gray-700">Personal Médico:</label>
                <select name="id_personal_medico" id="id_personal_medico" disabled
                    class="w-full p-3 border-2 border-black rounded-lg bg-indigo-200">
                    <option value="">Seleccione</option>
                    @foreach ($personalMedico as $medico)
                        <option value="{{ $medico->id_personal_medico }}"
                            {{ $horario->id_personal_medico == $medico->id_personal_medico ? 'selected' : '' }}>
                            {{ $medico->usuario->nombre }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 text-sm">El personal médico no puede ser modificado.</p>
            </div>

            <div>
                <label for="dia_semana" class="block text-lg font-semibold text-gray-700">Día de la Semana:</label>
                <select name="dia_semana" id="dia_semana"
                    class="w-full p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                    <option value="">Seleccione</option>
                    @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                        <option value="{{ $dia }}" {{ $horario->dia_semana == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                    @endforeach
                </select>
                @error('dia_semana') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Hora Inicio:</label>
                <div class="flex gap-2">
                    <select name="hora_inicio_hora"
                        class="w-1/3 p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                        <option value="">Hora</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ intval(date('h', strtotime($horario->hora_inicio))) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <select name="hora_inicio_minuto"
                        class="w-1/3 p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                        <option value="">Minutos</option>
                        @for ($i = 0; $i < 60; $i++)
                            <option value="{{ $i }}" {{ intval(date('i', strtotime($horario->hora_inicio))) == $i ? 'selected' : '' }}>
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                    <select name="hora_inicio_periodo"
                        class="w-1/3 p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                        <option value="AM" {{ date('A', strtotime($horario->hora_inicio)) == 'AM' ? 'selected' : '' }}>AM</option>
                        <option value="PM" {{ date('A', strtotime($horario->hora_inicio)) == 'PM' ? 'selected' : '' }}>PM</option>
                    </select>
                </div>
                @error('hora_inicio_hora') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                @error('hora_inicio_minuto') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                @error('hora_inicio_periodo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Hora Fin:</label>
                <div class="flex gap-2">
                    <select name="hora_fin_hora"
                        class="w-1/3 p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                        <option value="">Hora</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ intval(date('h', strtotime($horario->hora_fin))) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <select name="hora_fin_minuto"
                        class="w-1/3 p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                        <option value="">Minutos</option>
                        @for ($i = 0; $i < 60; $i++)
                            <option value="{{ $i }}" {{ intval(date('i', strtotime($horario->hora_fin))) == $i ? 'selected' : '' }}>
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                    <select name="hora_fin_periodo"
                        class="w-1/3 p-3 border-2 border-black rounded-lg bg-indigo-100 focus:ring-2 focus:ring-indigo-500">
                        <option value="AM" {{ date('A', strtotime($horario->hora_fin)) == 'AM' ? 'selected' : '' }}>AM</option>
                        <option value="PM" {{ date('A', strtotime($horario->hora_fin)) == 'PM' ? 'selected' : '' }}>PM</option>
                    </select>
                </div>
                @error('hora_fin_hora') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                @error('hora_fin_minuto') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                @error('hora_fin_periodo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-12 py-3 bg-indigo-500 text-white rounded-lg border-2 border-indigo-500 hover:bg-indigo-400">
                    Guardar Cambios
                </button>
                <a href="{{ route('horarios.index') }}" class="px-12 py-3 bg-indigo-500 text-white rounded-lg border-2 border-indigo-500 hover:bg-indigo-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
