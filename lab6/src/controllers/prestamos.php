<?php
require_once __DIR__ . '/../Database.php';

class PrestamosController {
    public static function handle($method, $id = null) {
        $db = Database::getConnection();
        switch ($method) {
            case 'GET':
                if ($id) {
                    $stmt = $db->prepare('SELECT l.*, m.name as miembro, b.title as libro FROM loans l LEFT JOIN members m ON l.member_id = m.id LEFT JOIN books b ON l.book_id = b.id WHERE l.id = ?');
                    $stmt->execute([$id]);
                    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($prestamo) {
                        http_response_code(200);
                        echo json_encode($prestamo);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Préstamo no encontrado']);
                    }
                } else {
                    $stmt = $db->query('SELECT l.*, m.name as miembro, b.title as libro FROM loans l LEFT JOIN members m ON l.member_id = m.id LEFT JOIN books b ON l.book_id = b.id');
                    http_response_code(200);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
            case 'POST': // Prestar un libro
                $data = json_decode(file_get_contents('php://input'), true);
                if (!isset($data['member_id'], $data['book_id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Faltan campos obligatorios']);
                    return;
                }
                $stmt = $db->prepare('SELECT * FROM loans WHERE book_id = ? AND returned_at IS NULL');
                $stmt->execute([$data['book_id']]);
                if ($stmt->fetch()) {
                    http_response_code(409);
                    echo json_encode(['error' => 'El libro ya está prestado']);
                    return;
                }
                $stmt = $db->prepare('INSERT INTO loans (member_id, book_id, loaned_at) VALUES (?, ?, CURRENT_TIMESTAMP)');
                try {
                    $stmt->execute([$data['member_id'], $data['book_id']]);
                    http_response_code(201);
                    echo json_encode(['id' => $db->lastInsertId()]);
                } catch (PDOException $e) {
                    http_response_code(409);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            case 'PUT':
            case 'PATCH': // Devolver libro
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el ID del préstamo']);
                    return;
                }
                $stmt = $db->prepare('UPDATE loans SET returned_at = CURRENT_TIMESTAMP WHERE id = ? AND returned_at IS NULL');
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Libro devuelto']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Préstamo no encontrado o ya devuelto']);
                }
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el ID']);
                    return;
                }
                $stmt = $db->prepare('DELETE FROM loans WHERE id = ?');
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    http_response_code(204);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Préstamo no encontrado']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
