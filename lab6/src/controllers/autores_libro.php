<?php
require_once __DIR__ . '/../Database.php';

class AutoresLibroController {
    public static function handle($method, $id_libro = null, $id_autor = null) {
        $db = Database::getConnection();
        switch ($method) {
            case 'GET':
                if ($id_libro && $id_autor) {
                    $stmt = $db->prepare('SELECT * FROM authors_books WHERE book_id = ? AND author_id = ?');
                    $stmt->execute([$id_libro, $id_autor]);
                    $rel = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($rel) {
                        http_response_code(200);
                        echo json_encode($rel);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Relación no encontrada']);
                    }
                } else {
                    $stmt = $db->query('SELECT * FROM authors_books');
                    http_response_code(200);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!isset($data['book_id'], $data['author_id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Faltan campos obligatorios']);
                    return;
                }
                $stmt = $db->prepare('INSERT INTO authors_books (book_id, author_id) VALUES (?, ?)');
                try {
                    $stmt->execute([$data['book_id'], $data['author_id']]);
                    http_response_code(201);
                    echo json_encode(['message' => 'Relación creada']);
                } catch (PDOException $e) {
                    http_response_code(409);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            case 'DELETE':
                if (!$id_libro || !$id_autor) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Faltan IDs']);
                    return;
                }
                $stmt = $db->prepare('DELETE FROM authors_books WHERE book_id = ? AND author_id = ?');
                $stmt->execute([$id_libro, $id_autor]);
                if ($stmt->rowCount()) {
                    http_response_code(204);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Relación no encontrada']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
