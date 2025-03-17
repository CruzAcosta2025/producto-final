<?php

namespace App\Http\Controllers\CentroMedico\Sangre;

use App\Http\Controllers\Controller;
use App\Models\DonadorSangre;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\ReniecService;

class DonadoresController extends Controller
{

    protected $reniecService;

    public function __construct(ReniecService $reniecService)
    {
        $this->reniecService = $reniecService;
    }

    public function buscarDni(Request $request)
    {
        $request->validate(['dni' => 'required|digits:8']);
        $datos = $this->reniecService->consultarDni($request->dni);

        if (isset($datos['error'])) {
            return response()->json(['error' => $datos['error']], 400);
        }

        return response()->json($datos);
    }

    public function index(Request $request)
    {
        Log::info('Iniciando DonadoresController@index');

        $dni = $request->input('dni');
        $paciente = null;
        $mensaje = null;

        $donadores = DonadorSangre::where('id_centro', Auth::user()->id_centro);

        if ($dni) {
            // Primero buscamos si el donador existe con ese DNI en la tabla donadores_sangre
            $donadores = $donadores->where('dni', $dni)->get();

            if ($donadores->isEmpty()) {
                // Si no se encuentra en donadores, buscamos en la tabla de pacientes
                $paciente = Paciente::where('id_centro', Auth::user()->id_centro)
                    ->where('dni', $dni)
                    ->first();

                if (!$paciente) {
                    $mensaje = 'No se encontró ningún registro con este DNI. Registre al donador manualmente.';
                }
            }
        } else {
            // Si no se está buscando por DNI, paginamos los donadores
            $donadores = $donadores->paginate(10);
        }

        return view('admin.centro.sangre.donadores.index', compact('donadores', 'paciente', 'mensaje', 'dni'));
    }


    public function create()
    {
        Log::info('Iniciando DonadoresController@create');
        return view('admin.centro.sangre.donadores.create');
    }

    public function store(Request $request)
    {
        Log::info('Datos recibidos en DonadoresController@store', $request->all());

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:donadores_sangre,dni',
            'tipo_sangre' => 'required|string|max:5',
            'telefono' => 'nullable|string|max:15',
            'estado' => 'required|in:POR_EXAMINAR,APTO,NO_APTO',
            'ultima_donacion' => 'nullable|date',
        ]);

        DonadorSangre::create([
            'id_centro' => Auth::user()->id_centro,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'tipo_sangre' => $request->tipo_sangre,
            'telefono' => $request->telefono,
            'estado' => $request->estado,
            'ultima_donacion' => $request->ultima_donacion,
        ]);

        Log::info('Donador creado exitosamente');

        return redirect()->route('sangre.donadores.index')->with('success', 'Donador registrado correctamente.');
    }

    public function registrarPacienteComoDonador($id)
    {
        $paciente = Paciente::where('id_centro', Auth::user()->id_centro)->findOrFail($id);

        if (DonadorSangre::where('dni', $paciente->dni)->exists()) {
            return redirect()->route('sangre.donadores.index')
                ->with('error', 'El paciente ya está registrado como donador.');
        }

        DonadorSangre::create([
            'id_centro' => Auth::user()->id_centro,
            'id_paciente' => $paciente->id_paciente,
            'nombre' => $paciente->primer_nombre,
            'apellido' => $paciente->primer_apellido,
            'dni' => $paciente->dni,
            'tipo_sangre' => $paciente->grupo_sanguineo,
            'telefono' => $paciente->telefono,
            'estado' => 'POR_EXAMINAR',
        ]);

        $paciente->update(['es_donador' => 'SI']);

        Log::info('Paciente registrado como donador');

        return redirect()->route('sangre.donadores.index')->with('success', 'El paciente ha sido registrado como donador.');
    }

    public function edit($id)
    {
        Log::info("Iniciando DonadoresController@edit para el ID: $id");

        $donador = DonadorSangre::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $editable = $donador->id_paciente === null;

        return view('admin.centro.sangre.donadores.edit', compact('donador', 'editable'));
    }

    public function update(Request $request, $id)
    {
        Log::info("Datos recibidos en DonadoresController@update para el ID: $id", $request->all());

        $donador = DonadorSangre::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $rules = [
            'telefono' => 'nullable|string|max:15',
            'estado' => 'required|in:POR_EXAMINAR,APTO,NO_APTO',
            'ultima_donacion' => 'nullable|date',
        ];

        if ($donador->id_paciente === null) {
            $rules['nombre'] = 'required|string|max:255';
            $rules['apellido'] = 'required|string|max:255';
            $rules['tipo_sangre'] = 'required|string|max:5';
        }

        $request->validate($rules);

        $donador->update($request->all());

        Log::info('Donador actualizado exitosamente');

        return redirect()->route('sangre.donadores.index')->with('success', 'Donador actualizado correctamente.');
    }

    public function destroy($id)
    {
        Log::info("Iniciando DonadoresController@destroy para el ID: $id");

        $donador = DonadorSangre::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $donador->delete();

        Log::info('Donador eliminado exitosamente');

        return redirect()->route('sangre.donadores.index')->with('success', 'Donador eliminado correctamente.');
    }
}
