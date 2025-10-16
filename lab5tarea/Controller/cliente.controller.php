<?php
require_once 'Model/cliente.php';

class ClienteController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Cliente();
    }

    public function Index()
    {
        require_once 'view/header.php';
        require_once 'view/cliente/cliente.php';
        require_once 'view/footer.php';
    }

    public function Crud()
    {
        $cli = new Cliente();
        
        if(isset($_REQUEST['idCliente'])){
            $cli = $this->model->Obtener($_REQUEST['idCliente']);
        }
        
        require_once 'view/header.php';
        require_once 'view/cliente/cliente-editar.php';
        require_once 'view/footer.php';
    }

    public function Nuevo()
    {
        $cli = new Cliente();
        require_once 'view/header.php';
        require_once 'view/cliente/cliente-nuevo.php';
        require_once 'view/footer.php';
    }

    public function Guardar()
    {
        $cli = new Cliente();
        $cli->idCliente = $_REQUEST['idCliente'];
        $cli->nombre = $_REQUEST['nombre'];
        $cli->direccion = $_REQUEST['direccion'];
        $cli->telefono = $_REQUEST['telefono'];
        $cli->email = $_REQUEST['email'];
        
        $this->model->Registrar($cli);
        header('Location: index.php?c=cliente');
    }

    public function Editar()
    {
        $cli = new Cliente();
        $cli->idCliente = $_REQUEST['idCliente'];
        $cli->nombre = $_REQUEST['nombre'];
        $cli->direccion = $_REQUEST['direccion'];
        $cli->telefono = $_REQUEST['telefono'];
        $cli->email = $_REQUEST['email'];
        
        $this->model->Actualizar($cli);
        header('Location: index.php?c=cliente');
    }

    public function Eliminar()
    {
        $this->model->Eliminar($_REQUEST['idCliente']);
        header('Location: index.php?c=cliente');
    }
}