<?php

// Para cada tabla se crea un objeto entidad, sobre ese objeto se crea el DAO correspondiente
// DAO(Data, Access, Object)
// CRUD(Create, Read, Update, Delete, Listar)

// Define la clase SITUACION que representa una entidad relacionado con la tabla situaciones de la BBDD

class Situacion
{

    private $id;
    private $nombre;

    public function __get($propiedad)
    {
        return $this->$propiedad;

    }

    public function __set($propiedad, $valor)
    {

        $this->$propiedad = $valor;


    }

}