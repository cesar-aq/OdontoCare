<?php
require_once __DIR__ . '/../config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/view/consulta/listar.php');
}

$acao = $_POST['acao'] ?? '';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

try {
    if ($acao === 'excluir') {
        $consulta = new Consulta();
        $consulta->id = $id ?: null;
        if (!$consulta->excluir()) {
            throw new RuntimeException('Não foi possível excluir a consulta.');
        }
        $_SESSION['mensagem'] = 'Consulta excluída com sucesso.';
        redirect('/view/consulta/listar.php');
    }

    $consulta = new Consulta();
    $consulta->paciente_id = (int)($_POST['paciente_id'] ?? 0);
    $consulta->dentista_id = (int)($_POST['dentista_id'] ?? 0);
    $consulta->data_hora = str_replace('T', ' ', $_POST['data_hora'] ?? '') . ':00';
    $consulta->valor_total = (float)($_POST['valor_total'] ?? 0);
    $consulta->valor_pago = (float)($_POST['valor_pago'] ?? 0);
    $consulta->forma_pagamento = $_POST['forma_pagamento'] ?? '';
    $consulta->procedimentos_realizados = trim($_POST['procedimentos_realizados'] ?? '') ?: null;
    $consulta->procedimentos_arealizar = trim($_POST['procedimentos_arealizar'] ?? '') ?: null;
    $consulta->descricao = trim($_POST['descricao'] ?? '') ?: null;
    $consulta->medicacao = trim($_POST['medicacao'] ?? '') ?: null;

    if ($consulta->paciente_id < 1 || $consulta->dentista_id < 1 || !$consulta->data_hora || $consulta->forma_pagamento === '') {
        throw new InvalidArgumentException('Preencha os campos obrigatórios.');
    }
    if ($consulta->valor_total < 0 || $consulta->valor_pago < 0 || $consulta->valor_pago > $consulta->valor_total) {
        throw new InvalidArgumentException('Confira os valores: o valor pago não pode ser maior que o valor total.');
    }

    if ($acao === 'cadastrar') {
        $consulta->cadastrar();
        $_SESSION['mensagem'] = 'Consulta cadastrada com sucesso.';
    } elseif ($acao === 'alterar' && $id) {
        $consulta->id = $id;
        if (!Consulta::buscarPorId($id)) {
            throw new RuntimeException('Consulta não encontrada.');
        }
        $consulta->alterar();
        $_SESSION['mensagem'] = 'Consulta alterada com sucesso.';
    } else {
        throw new InvalidArgumentException('Ação inválida.');
    }

    redirect('/view/consulta/listar.php');
} catch (Throwable $erro) {
    $_SESSION['erro'] = $erro instanceof PDOException
        ? 'Não foi possível concluir a operação. Verifique a conexão e os dados informados.'
        : $erro->getMessage();
    redirect('/view/consulta/listar.php');
}
