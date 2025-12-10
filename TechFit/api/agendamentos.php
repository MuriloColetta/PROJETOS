<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../Modal/AgendamentoAulaDAO.php';

$method = $_SERVER['REQUEST_METHOD'];
$dao = new AgendamentoAulaDAO();

try {
    switch ($method) {
        case 'GET':
            $agendamentos = $dao->lerAgendamentos();
            echo json_encode(['success' => true, 'data' => $agendamentos]);
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                break;
            }
            
            if (!isset($data['nome']) || empty(trim($data['nome']))) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Nome é obrigatório']);
                break;
            }

            try {
                $id = $dao->criarAgendamento($data);
                echo json_encode(['success' => true, 'message' => 'Agendamento criado com sucesso', 'id' => $id]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID é obrigatório']);
                break;
            }

            $sucesso = $dao->atualizarAgendamento($data['id'], $data);
            if ($sucesso) {
                echo json_encode(['success' => true, 'message' => 'Agendamento atualizado com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Agendamento não encontrado']);
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID é obrigatório']);
                break;
            }

            $sucesso = $dao->deletarAgendamento($data['id']);
            if ($sucesso) {
                echo json_encode(['success' => true, 'message' => 'Agendamento deletado com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Agendamento não encontrado']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("Erro em agendamentos.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>

