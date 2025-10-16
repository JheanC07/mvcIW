<?php
require_once __DIR__ . '/../Database.php';

class LibrosController {
    public static function handle($method, $id = null) {
        $db = Database::getConnection();
        switch ($method) {
            case 'GET':
                if ($id) {
                    $stmt = $db->prepare('SELECT b.*, p.name as editorial FROM books b LEFT JOIN publishers p ON b.publisher_id = p.id WHERE b.id = ?');
                    $stmt->execute([$id]);
                    $libro = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($libro) {
                        $stmt2 = $db->prepare('SELECT a.id, a.name FROM authors a INNER JOIN authors_books ab ON a.id = ab.author_id WHERE ab.book_id = ?');
                        $stmt2->execute([$id]);
                        $libro['autores'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        http_response_code(200);
                        echo json_encode($libro);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Libro no encontrado']);
                    }
                } else {
                    $stmt = $db->query('SELECT b.*, p.name as editorial FROM books b LEFT JOIN publishers p ON b.publisher_id = p.id');
                    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($libros as &$libro) {
                        $stmt2 = $db->prepare('SELECT a.id, a.name FROM authors a INNER JOIN authors_books ab ON a.id = ab.author_id WHERE ab.book_id = ?');
                        $stmt2->execute([$libro['id']]);
                        $libro['autores'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    }
                    http_response_code(200);
                    echo json_encode($libros);
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!isset($data['isbn'], $data['title'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Faltan campos obligatorios']);
                    return;
                }
                $stmt = $db->prepare('INSERT INTO books (isbn, title, publisher_id, publication_year, pages) VALUES (?, ?, ?, ?, ?)');
                try {
                    $stmt->execute([
                        $data['isbn'],
                        $data['title'],
                        $data['publisher_id'] ?? null,
                        $data['publication_year'] ?? null,
                        $data['pages'] ?? null
                    ]);
                    $libro_id = $db->lastInsertId();
                    if (!empty($data['autores']) && is_array($data['autores'])) {
                        $stmt2 = $db->prepare('INSERT INTO authors_books (book_id, author_id) VALUES (?, ?)');
                        foreach ($data['autores'] as $autor_id) {
                            $stmt2->execute([$libro_id, $autor_id]);
                        }
                    }
                    http_response_code(201);
                    echo json_encode(['id' => $libro_id]);
                } catch (PDOException $e) {
                    http_response_code(409);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            case 'PUT':
            case 'PATCH':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el ID']);
                    return;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $db->prepare('UPDATE books SET isbn = ?, title = ?, publisher_id = ?, publication_year = ?, pages = ? WHERE id = ?');
                $stmt->execute([
                    $data['isbn'] ?? '',
                    $data['title'] ?? '',
                    $data['publisher_id'] ?? null,
                    $data['publication_year'] ?? null,
                    $data['pages'] ?? null,
                    $id
                ]);
                if (isset($data['autores']) && is_array($data['autores'])) {
                    $db->prepare('DELETE FROM authors_books WHERE book_id = ?')->execute([$id]);
                    $stmt2 = $db->prepare('INSERT INTO authors_books (book_id, author_id) VALUES (?, ?)');
                    foreach ($data['autores'] as $autor_id) {
                        $stmt2->execute([$id, $autor_id]);
                    }
                }
                if ($stmt->rowCount()) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Libro actualizado']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Libro no encontrado']);
                }
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el ID']);
                    return;
                }
                $stmt = $db->prepare('DELETE FROM books WHERE id = ?');
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    http_response_code(204);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Libro no encontrado']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
