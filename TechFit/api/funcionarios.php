<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../Modal/Funcionario.php';
require_once __DIR__ . '/../Modal/FuncionarioDAO.php';

$method = $_SERVER['REQUEST_METHOD'];
$dao = new FuncionarioDAO();

try {
    switch ($method) {
        case 'GET':
            // Buscar todos os funcionários
            $funcionarios = $dao->lerFuncionario();
            $result = [];
            foreach ($funcionarios as $funcionario) {
                $result[] = [
                    'id' => $funcionario->getIdFuncionario(),
                    'nome' => $funcionario->getNomeFuncionario(),
                    'cpf' => $funcionario->getCpfFuncionario(),
                    'cargo' => $funcionario->getCargo(),
                    'salario' => $funcionario->getSalario(),
                    'cargaHoraria' => $funcionario->getCargaHoraria(),
                    'email' => $funcionario->getEmailFuncionario(),
                    'telefone' => $funcionario->getTelefoneFuncionario(),
                    'senha' => $funcionario->getSenhaFuncionario()
                ];
            }
            echo json_encode(['success' => true, 'data' => array_values($result)]);
            break;

        case 'POST':
            // Criar novo funcionário
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['nome']) || !isset($data['cpf']) || !isset($data['cargo']) || 
                !isset($data['salario']) || !isset($data['cargaHoraria']) || !isset($data['email']) || 
                !isset($data['telefone']) || !isset($data['senha'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
                break;
            }

            $funcionario = new Funcionario(
                null,
                $data['nome'],
                $data['cpf'],
                $data['cargo'],
                $data['salario'],
                $data['cargaHoraria'],
                $data['email'],
                $data['telefone'],
                $data['senha']
            );

            try {
                $dao->criarFuncionario($funcionario);
                echo json_encode(['success' => true, 'message' => 'Funcionário criado com sucesso']);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erro ao criar funcionário: ' . $e->getMessage()]);
            }
            break;

        case 'PUT':
            // Atualizar funcionário
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id']) || !isset($data['nome'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID e nome são obrigatórios']);
                break;
            }

            // Buscar funcionário original para obter o nome
            $funcionarios = $dao->lerFuncionario();
            $funcionarioOriginal = null;
            foreach ($funcionarios as $f) {
                if ($f->getIdFuncionario() == $data['id']) {
                    $funcionarioOriginal = $f;
                    break;
                }
            }

            if (!$funcionarioOriginal) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Funcionário não encontrado']);
                break;
            }

            $dao->atualizarFuncionario(
                $funcionarioOriginal->getNomeFuncionario(),
                $data['nome'],
                $data['cpf'] ?? $funcionarioOriginal->getCpfFuncionario(),
                $data['cargo'] ?? $funcionarioOriginal->getCargo(),
                $data['salario'] ?? $funcionarioOriginal->getSalario(),
                $data['cargaHoraria'] ?? $funcionarioOriginal->getCargaHoraria(),
                $data['email'] ?? $funcionarioOriginal->getEmailFuncionario(),
                $data['telefone'] ?? $funcionarioOriginal->getTelefoneFuncionario(),
                $data['senha'] ?? $funcionarioOriginal->getSenhaFuncionario()
            );

            echo json_encode(['success' => true, 'message' => 'Funcionário atualizado com sucesso']);
            break;

        case 'DELETE':
            // Deletar funcionário
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID é obrigatório']);
                break;
            }

            // Buscar funcionário para obter o nome
            $funcionarios = $dao->lerFuncionario();
            $funcionarioParaDeletar = null;
            foreach ($funcionarios as $f) {
                if ($f->getIdFuncionario() == $data['id']) {
                    $funcionarioParaDeletar = $f;
                    break;
                }
            }

            if (!$funcionarioParaDeletar) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Funcionário não encontrado']);
                break;
            }

            $dao->deletarFuncionario($funcionarioParaDeletar->getNomeFuncionario());
            echo json_encode(['success' => true, 'message' => 'Funcionário deletado com sucesso']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>

