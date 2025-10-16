<?php
require_once __DIR__ . '/../Database.php';

class EditorialesController {
    public static function handle($method, $id = null) {
        $db = Database::getConnection();
        switch ($method) {
            case 'GET':
                if ($id) {
                    $stmt = $db->prepare('SELECT * FROM publishers WHERE id = ?');
                    $stmt->execute([$id]);
                    $editorial = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($editorial) {
                        http_response_code(200);
                        echo json_encode($editorial);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Editorial no encontrada']);
                    }
                } else {
                    $stmt = $db->query('SELECT * FROM publishers');
                    http_response_code(200);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!isset($data['name'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el nombre']);
                    return;
                }
                $stmt = $db->prepare('INSERT INTO publishers (name, address) VALUES (?, ?)');
                try {
                    $stmt->execute([$data['name'], $data['address'] ?? null]);
                    http_response_code(201);
                    echo json_encode(['id' => $db->lastInsertId()]);
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
                $stmt = $db->prepare('UPDATE publishers SET name = ?, address = ? WHERE id = ?');
                $stmt->execute([$data['name'] ?? '', $data['address'] ?? '', $id]);
                if ($stmt->rowCount()) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Editorial actualizada']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Editorial no encontrada']);
                }
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el ID']);
                    return;
                }
                $stmt = $db->prepare('DELETE FROM publishers WHERE id = ?');
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    http_response_code(204);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Editorial no encontrada']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
