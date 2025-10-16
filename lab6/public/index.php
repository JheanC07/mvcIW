<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
if ($_SERVER['REQUEST_METHOD']=='OPTIONS'){
    header("Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS");
    exit(0);
}

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';


require_once __DIR__ . '/../src/controllers/autores.php';
require_once __DIR__ . '/../src/controllers/editoriales.php';
require_once __DIR__ . '/../src/controllers/libros.php';
require_once __DIR__ . '/../src/controllers/miembros.php';
require_once __DIR__ . '/../src/controllers/prestamos.php';
require_once __DIR__ . '/../src/controllers/autores_libro.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$parts = array_values(array_filter(explode('/', $path)));


if (isset($parts[1]) && $parts[0] === 'api') {
    $resource = $parts[1];
    $id = $parts[2] ?? null;
    switch ($resource) {
        case 'autores':
            AutoresController::handle($method, $id);
            break;
        case 'editoriales':
            EditorialesController::handle($method, $id);
            break;
        case 'libros':
            if ($method === 'GET' && isset($_GET['q'])) {
                $db = Database::getConnection();
                $q = '%' . $_GET['q'] . '%';
                $stmt = $db->prepare('SELECT b.*, p.name as editorial FROM books b LEFT JOIN publishers p ON b.publisher_id = p.id WHERE b.title LIKE ? OR b.id IN (SELECT ab.book_id FROM authors_books ab INNER JOIN authors a ON ab.author_id = a.id WHERE a.name LIKE ?) OR p.name LIKE ?');
                $stmt->execute([$q, $q, $q]);
                $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($libros as &$libro) {
                    $stmt2 = $db->prepare('SELECT a.id, a.name FROM authors a INNER JOIN authors_books ab ON a.id = ab.author_id WHERE ab.book_id = ?');
                    $stmt2->execute([$libro['id']]);
                    $libro['autores'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                }
                http_response_code(200);
                echo json_encode($libros);
                break;
            }
            LibrosController::handle($method, $id);
            break;
        case 'miembros':
            MiembrosController::handle($method, $id);
            break;
        case 'prestamos':
            PrestamosController::handle($method, $id);
            break;
        case 'autores_libro':
            $id_libro = $id;
            $id_autor = $parts[3] ?? null;
            AutoresLibroController::handle($method, $id_libro, $id_autor);
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Recurso no encontrado']);
    }
    exit;
}

echo json_encode([
    'message' => 'API Biblioteca disponible en /api/{recurso}',
    'recursos' => ['autores', 'editoriales', 'libros', 'miembros', 'prestamos', 'autores_libro']
]);
function getJsonInput(){
    $data=json_decode(file_get_contents('php://input'),true);
    return $data?:[];
}
$scriptName=dirname($_SERVER['SCRIPT_NAME']);
$uri=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$path=substr($uri,strlen($scriptName));
$parts=array_values(array_filter(explode('/',$path)));
$resource=$parts[0]??null;
$method=$_SERVER['REQUEST_METHOD'];
$allowed=['departments','instructors','students','courses','enrollments'];
if(!$resource){
    echo json_encode(['message'=>'REST API PHP - Recursos: ' . implode(', ',$allowed)]);
    exit;
}
if (!in_array($resorce,$allowed)) {
    http_response_code(404);
    echo json_encode(['error'=>'Recurso no encontrado']);
    exit;
}
require_once __DIR__ . "/../src/controllers/{$resource}.php";
switch ($$resource) {
    case 'students':
        routeStudents($method,$id,getJsonInput());
        break;
    case 'instructors':
        routeInstructors($method,$id,getJsonInput());
        break;
    case 'departments':
        routeDepartments($method,$id,getJsonInput());
        break;
    case 'courses':
        routeCourses($method,$id,getJsonInput());
        break;
    case 'enrollments':
        routeEnrollments($method,$id,getJsonInput());
        break;
    default:
        http_response_code(404);
        echo json_encode(['error'=>'Recurso no implementado']);
        break;
}