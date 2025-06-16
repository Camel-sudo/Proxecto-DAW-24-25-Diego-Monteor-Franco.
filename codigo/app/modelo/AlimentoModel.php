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

    public function __construct($id_alimento, $calorieking_id=null, $nombre=null, $marca=null, $porcion_estandar=null, $calorias=null, $proteinas=null, $carbohidratos=null, $grasas=null, $fibra=null, $sodio=null, $ultima_actualizacion=null)
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

    // getters y setters omitidos por brevedad (los podés agregar igual)
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

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

        $query = $db->prepare("
            INSERT INTO alimento (
                calorieking_id, nombre, marca, porcion_estandar, calorias,
                proteinas, carbohidratos, grasas, fibra, sodio, ultima_actualizacion
            ) VALUES (
                :calorieking_id, :nombre, :marca, :porcion_estandar, :calorias,
                :proteinas, :carbohidratos, :grasas, :fibra, :sodio, :ultima_actualizacion
            )
        ");

        $query->bindParam(':calorieking_id', $alimento->calorieking_id);
        $query->bindParam(':nombre', $alimento->nombre);
        $query->bindParam(':marca', $alimento->marca);
        $query->bindParam(':porcion_estandar', $alimento->porcion_estandar);
        $query->bindParam(':calorias', $alimento->calorias);
        $query->bindParam(':proteinas', $alimento->proteinas);
        $query->bindParam(':carbohidratos', $alimento->carbohidratos);
        $query->bindParam(':grasas', $alimento->grasas);
        $query->bindParam(':fibra', $alimento->fibra);
        $query->bindParam(':sodio', $alimento->sodio);
        $query->bindParam(':ultima_actualizacion', $alimento->ultima_actualizacion);

        $success = $query->execute();

        if ($success) {
            return $db->lastInsertId();
        } else {
            throw new Exception("Error al guardar el alimento.");
        }
    }

    public static function get_alimento_by_id($id_alimento)
    {
        $db = ConnectionDB::get();
        $query = $db->prepare("SELECT * FROM alimento WHERE id_alimento = :id_alimento");
        $query->bindParam(':id_alimento', $id_alimento);
        $query->execute();
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

    public static function buscarPorNombre($nombre)
    {
        $db = ConnectionDB::get();
        $stmt = $db->prepare("SELECT id_alimento, nombre AS descripcion, calorias, proteinas, carbohidratos, grasas FROM alimento WHERE nombre LIKE :nombre");
        $like = "%".$nombre."%";
        $stmt->bindParam(':nombre', $like);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarCombinado($query)
    {
        $db = ConnectionDB::get();
        $stmt = $db->prepare("SELECT id_alimento, nombre AS descripcion, calorias, proteinas, carbohidratos, grasas FROM alimento WHERE nombre LIKE :query");
        $like = "%".$query."%";
        $stmt->bindParam(':query', $like);
        $stmt->execute();
        $locales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $api_url = 'https://world.openfoodfacts.org/cgi/search.pl?' . http_build_query([
            'search_terms' => $query,
            'search_simple' => 1,
            'action' => 'process',
            'json' => 1,
            'fields' => 'product_name,nutriments,code',
            'page_size' => 5
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        curl_close($ch);

        $api_result = json_decode($response, true);
        $externos = [];

        if (isset($api_result['products']) && is_array($api_result['products'])) {
            foreach ($api_result['products'] as $producto) {
                $externos[] = [
                    'id_alimento' => null,
                    'descripcion' => $producto['product_name'] ?? 'Sin nombre',
                    'calorias' => $producto['nutriments']['energy-kcal_100g'] ?? null,
                    'proteinas' => $producto['nutriments']['proteins_100g'] ?? null,
                    'carbohidratos' => $producto['nutriments']['carbohydrates_100g'] ?? null,
                    'grasas' => $producto['nutriments']['fat_100g'] ?? null,
                    'codigo' => $producto['code'] ?? null
                ];
            }
        }

        return array_merge($locales, $externos);
    }
}
