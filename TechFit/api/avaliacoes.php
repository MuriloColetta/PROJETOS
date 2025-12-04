<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../Modal/AvaliacaoFisicaDAO.php';

$method = $_SERVER['REQUEST_METHOD'];
$dao = new AvaliacaoFisicaDAO();

try {
    switch ($method) {
        case 'GET':
            $avaliacoes = $dao->lerAvaliacoes();
            echo json_encode(['success' => true, 'data' => $avaliacoes]);
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
                $id = $dao->criarAvaliacao($data);
                echo json_encode(['success' => true, 'message' => 'Avaliação criada com sucesso', 'id' => $id]);
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

            $sucesso = $dao->atualizarAvaliacao($data['id'], $data);
            if ($sucesso) {
                echo json_encode(['success' => true, 'message' => 'Avaliação atualizada com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Avaliação não encontrada']);
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID é obrigatório']);
                break;
            }

            $sucesso = $dao->deletarAvaliacao($data['id']);
            if ($sucesso) {
                echo json_encode(['success' => true, 'message' => 'Avaliação deletada com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Avaliação não encontrada']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("Erro em avaliacoes.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>

