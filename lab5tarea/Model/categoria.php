<?php
class Categoria
{
    private $pdo;
    public $idCategoria;
    public $nombre;
    public $descripcion;

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
            $stm = $this->pdo->prepare("SELECT * FROM categoria");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($idCategoria)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM categoria WHERE idCategoria = ?");
            $stm->execute(array($idCategoria));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($idCategoria)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM categoria WHERE idCategoria = ?");
            $stm->execute(array($idCategoria));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Actualizar($data)
    {
        try {
            $sql = "UPDATE categoria SET nombre = ?, descripcion = ? WHERE idCategoria = ?";
            $this->pdo->prepare($sql)->execute(array($data->nombre, $data->descripcion, $data->idCategoria));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Categoria $data)
    {
        try {
            $sql = "INSERT INTO categoria (idCategoria, nombre, descripcion) VALUES (?, ?, ?)";
            $this->pdo->prepare($sql)->execute(array($data->idCategoria, $data->nombre, $data->descripcion));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}