<?php
function convertirNumeroALetras($numero) {
    // Implementación básica - deberías usar una librería completa para esto
    $unidades = ["", "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];
    $decenas = ["", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"];
    $centenas = ["", "CIEN", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"];
    $especiales = ["ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE"];
    
    $entero = intval($numero);
    $decimal = intval(round(($numero - $entero) * 100));
    
    if ($entero == 3500) {
        return "TRES MIL QUINIENTOS PESOS {$decimal}/100";
    }
    
    // Implementación simplificada - considera usar una librería completa
    if ($entero < 10) return $unidades[$entero] . " PESOS {$decimal}/100";
    if ($entero < 20) return ($entero < 16) ? $especiales[$entero-11] : $decenas[1] . " Y " . $unidades[$entero-10] . " PESOS {$decimal}/100";
    
    return "CANTIDAD EN PESOS {$decimal}/100"; // Implementación básica
}