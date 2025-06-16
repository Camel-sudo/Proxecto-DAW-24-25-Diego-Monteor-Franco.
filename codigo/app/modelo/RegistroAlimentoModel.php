<?php
class RegistroAlimentoModel
{
    public static function modificarAlimento(array $data): bool
    {
        $db = ConnectionDB::get();

        $sql = "UPDATE registro_alimento 
                SET cantidad = :cantidad, calorias = :calorias, proteinas = :proteinas, carbohidratos = :carbohidratos, grasas = :grasas
                WHERE id_registro_alimento = :id";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':cantidad', $data['cantidad'], PDO::PARAM_INT);
        $stmt->bindValue(':calorias', $data['calorias'], PDO::PARAM_INT);
        $stmt->bindValue(':proteinas', $data['proteinas'], PDO::PARAM_INT);
        $stmt->bindValue(':carbohidratos', $data['carbohidratos'], PDO::PARAM_INT);
        $stmt->bindValue(':grasas', $data['grasas'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error modificando alimento: " . $e->getMessage());
            return false;
        }
    }

    public static function eliminarAlimento(int $id): bool
    {
        $db = ConnectionDB::get();

        $sql = "DELETE FROM registro_alimento WHERE id_registro_alimento = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error eliminando alimento: " . $e->getMessage());
            return false;
        }
    }
}
