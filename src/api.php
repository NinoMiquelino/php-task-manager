<?php
require_once 'TaskService.php';

// Configuração inicial e CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$response = ['success' => false, 'data' => null, 'error' => ''];
$service = new TaskService();

// Lida com requisições OPTIONS (preflight CORS)
if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    switch ($method) {
        // --- READ (Leitura) ---
        case 'GET':
            $tasks = $service->getAll();
            $response['success'] = true;
            $response['data'] = $tasks;
            break;

        // --- CREATE (Criação) ---
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $title = $input['title'] ?? '';

            if (empty($title)) {
                throw new Exception("O campo 'title' é obrigatório para criar uma tarefa.", 400);
            }

            $newTask = $service->create($title);
            $response['success'] = true;
            $response['data'] = $newTask->toArray();
            http_response_code(201); // 201 Created
            break;

        // --- UPDATE (Atualização: Toggle e Edição) ---
        case 'PUT':
        case 'PATCH':
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $title = $input['title'] ?? null;
            $completed = isset($input['completed']) ? (bool)$input['completed'] : null;

            if (!$id) {
                throw new Exception("O ID da tarefa é obrigatório para atualização.", 400);
            }
            
            // Alterna o status se apenas o campo 'completed' for enviado (Toggle)
            if ($title === null && $completed !== null) {
                $updatedTask = $service->toggleCompleted($id);
            } else {
                // Atualiza título e/ou status
                $updatedTask = $service->update($id, $title, $completed);
            }
            
            $response['success'] = true;
            $response['data'] = $updatedTask->toArray();
            break;

        // --- DELETE (Exclusão) ---
        case 'DELETE':
            // Assume que o ID está no corpo ou em uma query string
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? ($_GET['id'] ?? null);

            if (!$id) {
                throw new Exception("O ID da tarefa é obrigatório para exclusão.", 400);
            }

            $service->delete($id);
            $response['success'] = true;
            $response['data'] = ['message' => 'Tarefa excluída com sucesso.', 'id' => $id];
            http_response_code(204); // 204 No Content
            break;

        default:
            http_response_code(405);
            throw new Exception("Método não permitido.", 405);
    }
} catch (Exception $e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    $response['success'] = false;
    $response['error'] = $e->getMessage();
}

// O DELETE (204) não retorna corpo. Apenas retornamos se o código não for 204.
if (http_response_code() !== 204) {
    echo json_encode($response);
}
