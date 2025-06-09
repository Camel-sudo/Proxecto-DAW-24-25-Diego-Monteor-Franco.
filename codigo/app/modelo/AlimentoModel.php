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

    public function __construct($id_alimento, $calorieking_id=null, $nombre=null, $marca=null, $porcion_estandar=null, $calorias=null, $proteinas=null, $carbohidratos=null, $grasas=null, $fibra=null, $sodio, $ultima_actualizacion)
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
    public static function buscar_alimento($query)
{
    ob_clean();
    header('Content-Type: application/json');

    if (empty($query)) {
        echo json_encode(['error' => 'No se proporcionó una consulta de búsqueda.']);
        exit;
    }

    $api_url = 'https://world.openfoodfacts.org/cgi/search.pl?' . http_build_query([
        'search_terms' => $query,
        'search_simple' => 1,
        'action' => 'process',
        'json' => 1,
        'fields' => 'product_name,nutriments,code',
        'page_size' => 3
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // ⏱️ Límite de tiempo

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['error' => 'Error al conectar con la API: ' . curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    
    $data = json_decode($response, true);

    if (!isset($data['products'])) {
        echo json_encode(['error' => 'No se encontraron productos.']);
        exit;
    }

    $productos = [];

    foreach ($data['products'] as $producto) {
        $productos[] = [
            'descripcion' => $producto['product_name'] ?? 'Sin nombre',
            'calorias' => $producto['nutriments']['energy-kcal_100g'] ?? null,
            'proteinas' => $producto['nutriments']['proteins_100g'] ?? null,
            'carbohidratos' => $producto['nutriments']['carbohydrates_100g'] ?? null,
            'grasas' => $producto['nutriments']['fat_100g'] ?? null,
            'codigo' => $producto['code'] ?? null
        ];
    }

    echo json_encode($productos);
    exit();
}
public static function guardar(Alimento $alimento)
{
    $db = ConnectionDB::get();

    // Comprobamos si ya existe un alimento con el mismo nombre y marca
    $queryCheck = $db->prepare("SELECT id_alimento FROM alimento WHERE nombre = ? AND marca = ?");
    $queryCheck->execute([$alimento->nombre, $alimento->marca]);
    $existing = $queryCheck->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Ya existe, devolvemos su ID
        return $existing['id_alimento'];
    }

    // Insertamos un nuevo alimento
    $query = $db->prepare("
        INSERT INTO alimento (
            calorieking_id, nombre, marca, porcion_estandar, calorias,
            proteinas, carbohidratos, grasas, fibra, sodio, ultima_actualizacion
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $success = $query->execute([
        $alimento->calorieking_id,
        $alimento->nombre,
        $alimento->marca,
        $alimento->porcion_estandar,
        $alimento->calorias,
        $alimento->proteinas,
        $alimento->carbohidratos,
        $alimento->grasas,
        $alimento->fibra,
        $alimento->sodio,
        $alimento->ultima_actualizacion,
    ]);

    if ($success) {
        return $db->lastInsertId();
    } else {
        throw new Exception("Error al guardar el alimento.");
    }
}
public static function get_alimento_by_id($id_alimento)
{
    $db = ConnectionDB::get();
    $query = $db->prepare("SELECT * FROM alimento WHERE id_alimento = ?");
    $query->execute([$id_alimento]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    return new Alimento(
        $row['id_alimento'],
        $row['calorieking_id'],
        $row['nombre'],
        $row['marca'],
        $row['porcion_estandar'],
        $row['calorias'],
        $row['proteinas'],
        $row['carbohidratos'],
        $row['grasas'],
        $row['fibra'],
        $row['sodio'],
        $row['ultima_actualizacion']
    );
}

}