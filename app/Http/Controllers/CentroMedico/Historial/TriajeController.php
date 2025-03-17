<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use App\Models\Triaje;
use App\Models\HistorialClinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TriajeController extends Controller
{
    // Mostrar registros de triaje con buscador por DNI
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $triajes = [];

        if ($dni) {
            $paciente = HistorialClinico::whereHas('paciente', function ($query) use ($dni) {
                $query->where('dni', $dni)->where('id_centro', Auth::user()->id_centro);
            })->with('triaje')->first();

            if ($paciente) {
                $triajes = $paciente->triaje;
            }
        }

        return view('admin.centro.historial.triajes.index', compact('paciente', 'triajes', 'dni'));
    }

    // Formulario para crear un triaje
    public function create($idHistorial)
    {
        $historial = HistorialClinico::where('id_historial', $idHistorial)
            ->where('id_centro', Auth::user()->id_centro)
            ->with('paciente')
            ->firstOrFail();

        return view('admin.centro.historial.triajes.create', compact('historial'));
    }

    // Almacenar un registro de triaje
    public function store(Request $request, $idHistorial)
    {
        try {
            Log::info('Iniciando proceso de creación de Triaje', ['request' => $request->all()]);

            // Validaciones con mensajes personalizados
            $request->validate([
                'presion_arterial' => 'required|string|max:20',
                'temperatura' => 'required|numeric|min:30|max:45',
                'frecuencia_cardiaca' => 'required|numeric|min:40|max:200',
                'frecuencia_respiratoria' => 'required|numeric|min:10|max:60',
                'peso' => 'required|numeric|min:1|max:300',
                'talla' => 'required|numeric|min:0.5|max:2.5',
                'fecha_triaje' => 'required|date',
            ], [
                'presion_arterial.required' => 'Debe ingresar la presión arterial.',
                'temperatura.required' => 'Debe ingresar la temperatura.',
                'temperatura.min' => 'La temperatura debe ser al menos 30°C.',
                'temperatura.max' => 'La temperatura no debe ser mayor a 45°C.',
                'frecuencia_cardiaca.required' => 'Debe ingresar la frecuencia cardíaca.',
                'frecuencia_cardiaca.min' => 'La frecuencia cardíaca debe ser al menos 40 LPM.',
                'frecuencia_cardiaca.max' => 'La frecuencia cardíaca no debe ser mayor a 200 LPM.',
                'frecuencia_respiratoria.required' => 'Debe ingresar la frecuencia respiratoria.',
                'frecuencia_respiratoria.min' => 'La frecuencia respiratoria debe ser al menos 10 RPM.',
                'frecuencia_respiratoria.max' => 'La frecuencia respiratoria no debe ser mayor a 60 RPM.',
                'peso.required' => 'Debe ingresar el peso del paciente.',
                'peso.min' => 'El peso debe ser al menos 1 kg.',
                'peso.max' => 'El peso no debe ser mayor a 300 kg.',
                'talla.required' => 'Debe ingresar la talla del paciente.',
                'talla.min' => 'La talla debe ser al menos 0.5 m.',
                'talla.max' => 'La talla no debe ser mayor a 2.5 m.',
                'fecha_triaje.required' => 'Debe ingresar la fecha del triaje.',
            ]);

            // Calcular el IMC
            $imc = $request->peso / ($request->talla * $request->talla);

            // Crear el registro
            Triaje::create([
                'id_historial' => $idHistorial,
                'presion_arterial' => $request->presion_arterial,
                'temperatura' => $request->temperatura,
                'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
                'peso' => $request->peso,
                'talla' => $request->talla,
                'imc' => round($imc, 2),
                'fecha_triaje' => $request->fecha_triaje,
            ]);

            Log::info('Triaje creado exitosamente');

            return redirect()->route('triajes.index', ['dni' => $request->dni])
                ->with('success', 'Triaje registrado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear Triaje', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error al registrar el triaje. Por favor, intente nuevamente.']);
        }
    }

    // Formulario para editar un registro de triaje
    public function edit($idHistorial, $idTriaje)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)->findOrFail($idHistorial);
        $triaje = Triaje::where('id_historial', $idHistorial)->findOrFail($idTriaje);

        return view('admin.centro.historial.triajes.edit', compact('historial', 'triaje'));
    }

    // Actualizar un registro de triaje
    public function update(Request $request, $idHistorial, $idTriaje)
    {
        try {
            Log::info('Iniciando proceso de actualización de Triaje', ['request' => $request->all()]);

            // Validaciones dinámicas
            $validatedData = $request->validate([
                'presion_arterial' => 'nullable|string|max:20',
                'temperatura' => 'nullable|numeric|min:30|max:45',
                'frecuencia_cardiaca' => 'nullable|numeric|min:40|max:200',
                'frecuencia_respiratoria' => 'nullable|numeric|min:10|max:60',
                'peso' => 'nullable|numeric|min:1|max:300',
                'talla' => 'nullable|numeric|min:0.5|max:2.5',
                'fecha_triaje' => 'nullable|date',
            ]);

            // Encontrar el registro de triaje
            $triaje = Triaje::where('id_historial', $idHistorial)
                ->whereHas('historialClinico', function ($query) {
                    $query->where('id_centro', Auth::user()->id_centro);
                })
                ->findOrFail($idTriaje);

            // Preparar los datos para actualizar
            $dataToUpdate = array_filter($validatedData, function ($value) {
                return $value !== null;
            });

            // Calcular el IMC solo si se proporcionan peso y talla
            if (isset($dataToUpdate['peso']) && isset($dataToUpdate['talla'])) {
                $dataToUpdate['imc'] = $dataToUpdate['peso'] / ($dataToUpdate['talla'] * $dataToUpdate['talla']);
            }

            $triaje->update($dataToUpdate);

            Log::info('Triaje actualizado exitosamente');

            return redirect()->route('triajes.index', ['dni' => $request->dni])
                ->with('success', 'Triaje actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar Triaje', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error al actualizar el triaje. Por favor, intente nuevamente.']);
        }
    }

    // Eliminar un registro de triaje
    public function destroy($idHistorial, $idTriaje)
    {
        try {
            $triaje = Triaje::where('id_historial', $idHistorial)
                ->whereHas('historialClinico', function ($query) {
                    $query->where('id_centro', Auth::user()->id_centro);
                })
                ->findOrFail($idTriaje);

            $triaje->delete();

            return redirect()->back()->with('success', 'Triaje eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar Triaje', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error al eliminar el triaje. Por favor, intente nuevamente.']);
        }
    }
}
