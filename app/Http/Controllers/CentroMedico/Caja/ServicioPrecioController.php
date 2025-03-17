<?php

namespace App\Http\Controllers\CentroMedico\Caja;

use App\Http\Controllers\Controller;
use App\Models\ServicioPrecio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioPrecioController extends Controller
{
    /**
     * Listar servicios disponibles en el centro médico.
     */
    public function index()
    {
        $servicios = ServicioPrecio::where('id_centro', Auth::user()->id_centro)
            ->paginate(10); // Paginación de 10 servicios por página

        return view('admin.centro.caja.servicios.index', compact('servicios'));
    }

    /**
     * Mostrar el formulario para crear un nuevo servicio.
     */
    public function create()
    {
        return view('admin.centro.caja.servicios.create');
    }

    /**
     * Almacenar un nuevo servicio en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'categoria_servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        ServicioPrecio::create([
            'id_centro' => Auth::user()->id_centro,
            'nombre_servicio' => $request->nombre_servicio,
            'categoria_servicio' => $request->categoria_servicio,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'estado' => $request->estado,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    /**
     * Mostrar el formulario para editar un servicio existente.
     */
    public function edit($id)
    {
        $servicio = ServicioPrecio::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        return view('admin.centro.caja.servicios.edit', compact('servicio'));
    }

    /**
     * Actualizar un servicio existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $servicio = ServicioPrecio::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'categoria_servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $servicio->update([
            'nombre_servicio' => $request->nombre_servicio,
            'categoria_servicio' => $request->categoria_servicio,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'estado' => $request->estado,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    /**
     * Eliminar un servicio existente de la base de datos.
     */
    public function destroy($id)
    {
        $servicio = ServicioPrecio::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado exitosamente.');
    }
}
