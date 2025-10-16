<?php
class Venta
{
    private $pdo;
    public $idVenta;
    public $idCliente;
    public $fecha;
    public $total;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::Conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Listar()
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT v.*, c.nombre as cliente 
                FROM venta v 
                INNER JOIN cliente c ON v.idCliente = c.idCliente
                ORDER BY v.fecha DESC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($idVenta)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM venta WHERE idVenta = ?");
            $stm->execute(array($idVenta));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Venta $data)
    {
        try {
            $sql = "INSERT INTO venta (idVenta, idCliente, fecha, total) VALUES (?, ?, NOW(), ?)";
            $this->pdo->prepare($sql)->execute(array($data->idVenta, $data->idCliente, $data->total));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}