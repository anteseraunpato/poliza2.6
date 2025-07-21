<?php
require_once __DIR__ . '/app/controllers/PolizaController.php';

use App\Controllers\PolizaController;

$items = PolizaController::buscarPolizas();

include 'buscar_poliza_view.php';  // Aquí cargas la vista separada