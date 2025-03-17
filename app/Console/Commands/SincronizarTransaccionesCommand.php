<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Factura;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;

class SincronizarTransaccionesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'caja:sincronizar-transacciones';

    /**
     * The console command description.
     */
    protected $description = 'Sincroniza las facturas pagadas con las transacciones de caja';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $facturas = Factura::where('estado_pago', 'PAGADA')
            ->doesntHave('transaccionCaja')
            ->where('id_centro', Auth::user()->id_centro)
            ->get();

        foreach ($facturas as $factura) {
            Caja::create([
                'id_centro' => $factura->id_centro,
                'id_factura' => $factura->id_factura,
                'fecha_transaccion' => $factura->fecha_factura,
                'monto' => $factura->total,
                'tipo_transaccion' => 'INGRESO',
                'descripcion' => "Factura ID: {$factura->id_factura} sincronizada automáticamente.",
            ]);
        }

        $this->info('Transacciones sincronizadas correctamente.');
    }
}
