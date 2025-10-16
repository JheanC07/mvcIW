<?php
require_once 'Model/categoria.php';

class CategoriaController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Categoria();
    }

    public function Index()
    {
        require_once 'view/header.php';
        require_once 'view/categoria/categoria.php';
        require_once 'view/footer.php';
    }

    public function Crud()
    {
        $cat = new Categoria();
        
        if(isset($_REQUEST['idCategoria'])){
            $cat = $this->model->Obtener($_REQUEST['idCategoria']);
        }
        
        require_once 'view/header.php';
        require_once 'view/categoria/categoria-editar.php';
        require_once 'view/footer.php';
    }

    public function Nuevo()
    {
        $cat = new Categoria();
        require_once 'view/header.php';
        require_once 'view/categoria/categoria-nuevo.php';
        require_once 'view/footer.php';
    }

    public function Guardar()
    {
        $cat = new Categoria();
        $cat->idCategoria = $_REQUEST['idCategoria'];
        $cat->nombre = $_REQUEST['nombre'];
        $cat->descripcion = $_REQUEST['descripcion'];
        
        $this->model->Registrar($cat);
        header('Location: index.php?c=categoria');
    }

    public function Editar()
    {
        $cat = new Categoria();
        $cat->idCategoria = $_REQUEST['idCategoria'];
        $cat->nombre = $_REQUEST['nombre'];
        $cat->descripcion = $_REQUEST['descripcion'];
        
        $this->model->Actualizar($cat);
        header('Location: index.php?c=categoria');
    }

    public function Eliminar()
    {
        $this->model->Eliminar($_REQUEST['idCategoria']);
        header('Location: index.php?c=categoria');
    }
}