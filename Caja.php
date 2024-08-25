<?php
$inicio_tiempo = microtime(true);
$filas = 20;
$columnas = 20;

// Se llena automáticamente
$caja = array_fill(0, $filas, array_fill(0, $columnas, "*"));
imprimir_caja($caja, $filas, $columnas);

echo("\n<<<<<<<Construir Caja>>>>>>>>>>\n");

$construir_caja_vacia = new Caja($filas, $columnas, $caja);
imprimir_caja($construir_caja_vacia->construir_caja(), $filas, $columnas);

echo("\n<<<<<<<Construir X>>>>>>>>>>\n");
$caja_x = $construir_caja_vacia->construir_x();
imprimir_caja($caja_x->init(), $filas, $columnas);

function imprimir_caja($caja, $filas, $columnas) {
    for($i = 0; $i < $filas; $i++) {
        for($j = 0; $j < $columnas; $j++)
            echo($caja[$i][$j] . " ");
        echo("\n");
    }
}

class Caja 
{
	private $filas, $columnas;
	private $caja;
	const ASTERISCO = "*";
	
	public function __construct($filas, $columnas, $caja) {
		$this->filas = $filas;
		$this->columnas = $columnas;
		$this->caja = $caja;
	}
	
	public function construir_caja() {
		for($i = 0; $i < $this->filas; $i++) {
			$this->caja[$i] = [];
			for($j = 0; $j < $this->columnas; $j++) {
				$this->caja[$i][$j] = ($i === 0 || $j === 0) ? self::ASTERISCO : " ";
				if($this->caja[$i][$j] === "*") continue;
				$this->caja[$i][$j] = ($i === (sizeof($this->caja) - 1) || $j === (sizeof($this->caja) - 1)) ? self::ASTERISCO : " ";
			}
		}
		return $this->caja;
	}
	
	public function construir_x() {
		
		$caja_x = new class($this->caja, $this->filas, $this->columnas) extends Caja {
			private $filas, $columnas;
			private $caja;
			const ASTERISCO = "*";
			
			public function __construct($caja, $filas, $columnas) {
				$this->caja = $caja;
				$this->filas = $filas;
				$this->columnas = $columnas;
			}
			
			public function init() {
				for($i = 0, $j = (count($this->caja) - 1); $i < $this->filas; $i++, $j--) {
					$this->caja[$i][$i] = self::ASTERISCO;
					$this->caja[$i][$j] = self::ASTERISCO;
				}
				return $this->caja;
			}
		};
		
		return $caja_x;
	}

}


$fin_tiempo = microtime(true);
$tiempo_ejecucion = round(($fin_tiempo - $inicio_tiempo), 6);
echo("Tiempo de ejecución: $tiempo_ejecucion");

?>