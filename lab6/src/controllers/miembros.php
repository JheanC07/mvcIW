<?php
require_once __DIR__ . '/../Database.php';

class MiembrosController {
    public static function handle($method, $id = null) {
        $db = Database::getConnection();
        switch ($method) {
            case 'GET':
                if ($id) {
                    $stmt = $db->prepare('SELECT * FROM members WHERE id = ?');
                    $stmt->execute([$id]);
                    $miembro = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($miembro) {
                        http_response_code(200);
                        echo json_encode($miembro);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Miembro no encontrado']);
                    }
                } else {
                    $stmt = $db->query('SELECT * FROM members');
                    http_response_code(200);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!isset($data['name'], $data['email'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Faltan campos obligatorios']);
                    return;
                }
                $stmt = $db->prepare('INSERT INTO members (name, email, member_year) VALUES (?, ?, ?)');
                try {
                    $stmt->execute([$data['name'], $data['email'], $data['member_year'] ?? null]);
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
                $stmt = $db->prepare('UPDATE members SET name = ?, email = ?, member_year = ? WHERE id = ?');
                $stmt->execute([
                    $data['name'] ?? '',
                    $data['email'] ?? '',
                    $data['member_year'] ?? null,
                    $id
                ]);
                if ($stmt->rowCount()) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Miembro actualizado']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Miembro no encontrado']);
                }
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta el ID']);
                    return;
                }
                $stmt = $db->prepare('DELETE FROM members WHERE id = ?');
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    http_response_code(204);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Miembro no encontrado']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
