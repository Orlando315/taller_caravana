<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{ToCollection};

class RepuestoImport implements ToCollection
{
    /**
     * Forrmato de la informacion importada
     *
     * @var array
     */
    private $data = [];

    /**
     * Filas con informacion valida
     *
     * @var float
     */
    private $costo_total = 0;


    /**
     * Constantes
     *
     * @var array
     */
    private $const = [
      'dolar' => null,
      'gasto_general' => null,
      'impuestos' => null,
      'envio1' => null,
      'envio2' => null,
      'comision' => null,
    ];

    /**
     * Establecer si el archivo contiene algun error
     * que no permita procesar la informacion
     *
     * @var bool
     */
    private $error = false;

    /**
     * @param Collection $row
     * @return void
     */
    public function collection(Collection $rows)
    {
      $this->mapVariables($rows);

      // Si hay algun error, detener
      if($this->hasError()){
        return false;
      }

      // Filtrar para obtener solos los Repuestos con los datos necesarios
      // Y acumular el costo total
      $filtered = $rows->splice(8, 10)
                      ->filter(function ($repuesto, $key){
                        if($repuesto[0] && $repuesto[1] && $repuesto[2]){
                          $precio = $repuesto[1] ?? 0;
                          $cantidad = $repuesto[2] ?? 0;
                          $this->costo_total += $precio * $cantidad;
                          return true;
                        }

                        return false;
                      });
      
      $filtered->each(function ($repuesto, $key) {
        $precio = $repuesto[1] ?? 0;
        $cantidad = $repuesto[2] ?? 0;
        $costo = $precio * $cantidad;
        $porcentaje = $costo / $this->costo_total;
        $envio1 = $this->const['envio1'] * $porcentaje;
        $envio2 = $this->const['envio2'] * $porcentaje;
        $costoConEnvio = $costo + $envio1 + $envio2;
        $impuestos = $costoConEnvio * $this->const['impuestos'];
        $costoTotal = $impuestos + (($this->const['comision'] * $porcentaje) / $this->const['dolar']);
        $gastoGeneral = $costoTotal * $this->const['gasto_general'];
        $venta = ($gastoGeneral * $this->const['dolar']) / $cantidad;

        $this->data[] = [
          'descripcion' => $repuesto[0],
          'precio' => round($precio, 2),
          'cantidad' => $cantidad,
          'costo' => round($costo, 2),
          'porcentaje' => round($porcentaje, 2),
          'envio1' => round($envio1, 2),
          'envio2' => round($envio2, 2),
          'costo_envio' => round($costoConEnvio, 2),
          'impuestos' => round($impuestos, 2),
          'costo_total' => round($costoTotal, 2),
          'gasto_general' => round($gastoGeneral, 2),
          'venta' => round($venta, 2),
        ];
      });
    }

    /**
     * Obtener la informacion importada
     * 
     * @return array
     */
    public function getData()
    {
      return $this->data;
    }

    /**
     * Obtener la informacion de las constantes
     * 
     * @return array
     */
    public function getConst()
    {
      return $this->const;
    }

    /**
     * Obtener la informacion importada
     * 
     * @return mixed
     */
    public function mapVariables($rows)
    {
      if($rows[0][1]){
        $this->const['dolar'] = $rows[0][1];
      }else{
        $this->const['dolar'] = 0;
        $this->error = true;
      }

      $this->const['gasto_general'] = $rows[1][1] ?? 0;
      $this->const['impuestos'] = $rows[2][1] ?? 0;
      $this->const['envio1'] = $rows[3][1] ?? 0;
      $this->const['envio2'] = $rows[4][1] ?? 0;
      $this->const['comision'] = $rows[5][1] ?? 0;
    }

    /**
     * Evaluar si los datos tienen erroes
     * 
     * @return bool
     */
    public function hasError()
    {
      return $this->error;
    }
}
