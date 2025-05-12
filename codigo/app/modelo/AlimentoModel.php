<?php
include_once 'ConnectionDB.php';

class Alimento
{
    public $id_alimento;
    public $calorieking_id;
    public $nombre;
    public $marca;
    public $porcion_estandar;
    public $calorias;
    public $proteinas;
    public $carbohidratos;
    public $grasas;
    public $fibra;
    public $sodio;
    public $ultima_actualizacion;

    public function __construct($id_alimento, $calorieking_id, $nombre, $marca, $porcion_estandar, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $sodio, $ultima_actualizacion)
    {
        $this->id_alimento = $id_alimento;
        $this->calorieking_id = $calorieking_id;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->porcion_estandar = $porcion_estandar;
        $this->calorias = $calorias;
        $this->proteinas = $proteinas;
        $this->carbohidratos = $carbohidratos;
        $this->grasas = $grasas;
        $this->fibra = $fibra;
        $this->sodio = $sodio;
        $this->ultima_actualizacion = $ultima_actualizacion;
    }

    /**
     * Get the value of id_alimento
     */ 
    public function getId_alimento()
    {
        return $this->id_alimento;
    }

    /**
     * Set the value of id_alimento
     *
     * @return  self
     */ 
    public function setId_alimento($id_alimento)
    {
        $this->id_alimento = $id_alimento;

        return $this;
    }

    /**
     * Get the value of calorieking_id
     */ 
    public function getCalorieking_id()
    {
        return $this->calorieking_id;
    }

    /**
     * Set the value of calorieking_id
     *
     * @return  self
     */ 
    public function setCalorieking_id($calorieking_id)
    {
        $this->calorieking_id = $calorieking_id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of marca
     */ 
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set the value of marca
     *
     * @return  self
     */ 
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get the value of porcion_estandar
     */ 
    public function getPorcion_estandar()
    {
        return $this->porcion_estandar;
    }

    /**
     * Set the value of porcion_estandar
     *
     * @return  self
     */ 
    public function setPorcion_estandar($porcion_estandar)
    {
        $this->porcion_estandar = $porcion_estandar;

        return $this;
    }

    /**
     * Get the value of calorias
     */ 
    public function getCalorias()
    {
        return $this->calorias;
    }

    /**
     * Set the value of calorias
     *
     * @return  self
     */ 
    public function setCalorias($calorias)
    {
        $this->calorias = $calorias;

        return $this;
    }

    

    /**
     * Get the value of proteinas
     */ 
    public function getProteinas()
    {
        return $this->proteinas;
    }

    /**
     * Set the value of proteinas
     *
     * @return  self
     */ 
    public function setProteinas($proteinas)
    {
        $this->proteinas = $proteinas;

        return $this;
    }

    /**
     * Get the value of carbohidratos
     */ 
    public function getCarbohidratos()
    {
        return $this->carbohidratos;
    }

    /**
     * Set the value of carbohidratos
     *
     * @return  self
     */ 
    public function setCarbohidratos($carbohidratos)
    {
        $this->carbohidratos = $carbohidratos;

        return $this;
    }

    /**
     * Get the value of grasas
     */ 
    public function getGrasas()
    {
        return $this->grasas;
    }

    /**
     * Set the value of grasas
     *
     * @return  self
     */ 
    public function setGrasas($grasas)
    {
        $this->grasas = $grasas;

        return $this;
    }

    /**
     * Get the value of fibra
     */ 
    public function getFibra()
    {
        return $this->fibra;
    }

    /**
     * Set the value of fibra
     *
     * @return  self
     */ 
    public function setFibra($fibra)
    {
        $this->fibra = $fibra;

        return $this;
    }

    /**
     * Get the value of sodio
     */ 
    public function getSodio()
    {
        return $this->sodio;
    }

    /**
     * Set the value of sodio
     *
     * @return  self
     */ 
    public function setSodio($sodio)
    {
        $this->sodio = $sodio;

        return $this;
    }
}

class AlimentoModel
{
    public static function buscar_alimento($nombre)
    {
    }

    public static function get_alimento_by_id($id_alimento)
    {
    }
}