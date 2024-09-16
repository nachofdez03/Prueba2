<?php

//Script para ir probando los metodos del primer DAO

require_once 'DaoSituaciones.php';

$dao = new DaoSituaciones("Tema2Blobs");



$dao->listar();

foreach ($dao->situaciones as $situ) {
    echo $situ->__get("Id") . " " . $situ->__get("Nombre") . "<br>";
}

$Id = 4;

$situ = $dao->obtener($Id);

echo "El nombre de la situación con Id: $Id es " . $situ->__get("Nombre");


$Id = 5;

$dao->Borrar($Id);


$situ = new Situacion();

$situ->__set("Id", 5);
$situ->__set("Nombre", "Despedido");

$dao->insertar($situ);



$situ = new Situacion();

$situ->__set("Id", 5);
$situ->__set("Nombre", "Echado");

$dao->actualizar($situ);




?>