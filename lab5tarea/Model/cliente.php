<?php
class Cliente
{
    private $pdo;
    public $idCliente;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;

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
            $stm = $this->pdo->prepare("SELECT * FROM cliente");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($idCliente)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM cliente WHERE idCliente = ?");
            $stm->execute(array($idCliente));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($idCliente)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM cliente WHERE idCliente = ?");
            $stm->execute(array($idCliente));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Actualizar($data)
    {
        try {
            $sql = "UPDATE cliente SET nombre = ?, direccion = ?, telefono = ?, email = ? WHERE idCliente = ?";
            $this->pdo->prepare($sql)->execute(
                array($data->nombre, $data->direccion, $data->telefono, $data->email, $data->idCliente)
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Cliente $data)
    {
        try {
            $sql = "INSERT INTO cliente (idCliente, nombre, direccion, telefono, email) VALUES (?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)->execute(
                array($data->idCliente, $data->nombre, $data->direccion, $data->telefono, $data->email)
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}