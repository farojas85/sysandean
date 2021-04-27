<?php
namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;

use App\Models\Lote;

class ReporteComposer {

    protected $alumnos;
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function __construct( $alumnos)
    {
        // Dependencies automatically resolved by service container...
        $this->alumnos = $alumnos;
    }

    public function compose(View $view)
    {
        
        $lote = Lote::select('fecha_registro','maduros','pinton','verde','podrido','enanas')
                    ->first();
        
        $view->with([
            'lote' => $lote
        ]);
    }
}