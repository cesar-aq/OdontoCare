<?php
require_once __DIR__ . '/../../config/bootstrap.php';
$titulo = 'Lista de consultas';
$consultas = Consulta::listar();
include __DIR__ . '/../includes/cabecalho.php';
include __DIR__ . '/../includes/menu.php';
?>
<main class="container page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div><h2 class="mb-1">Consultas cadastradas</h2><p class="text-muted mb-0">Total: <?= count($consultas) ?> consulta(s)</p></div>
        <a class="btn btn-primary" href="<?= BASE_URL ?>/view/consulta/cadastrar.php">Nova consulta</a>
    </div>
    <?php if (!empty($_SESSION['mensagem'])): ?><div class="alert alert-success"><?= e($_SESSION['mensagem']) ?></div><?php unset($_SESSION['mensagem']); endif; ?>
    <?php if (!empty($_SESSION['erro'])): ?><div class="alert alert-danger"><?= e($_SESSION['erro']) ?></div><?php unset($_SESSION['erro']); endif; ?>
    <?php if (!$consultas): ?>
        <div class="alert alert-info">Nenhuma consulta cadastrada. Use o botão “Nova consulta” para começar.</div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark"><tr><th>Paciente</th><th>Dentista</th><th>Data e hora</th><th>Valor total</th><th>Valor pago</th><th>Pagamento</th><th>Ações</th></tr></thead>
            <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= e($consulta['paciente_nome']) ?></td><td><?= e($consulta['dentista_nome']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?></td>
                    <td>R$ <?= number_format((float)$consulta['valor_total'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format((float)$consulta['valor_pago'], 2, ',', '.') ?></td>
                    <td><?= e($consulta['forma_pagamento']) ?></td>
                    <td class="text-nowrap">
                        <a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/view/consulta/editar.php?id=<?= (int)$consulta['id'] ?>">Editar</a>
                        <form class="d-inline" method="post" action="<?= BASE_URL ?>/action/action_consulta.php" onsubmit="return confirm('Deseja realmente excluir esta consulta?');">
                            <input type="hidden" name="acao" value="excluir"><input type="hidden" name="id" value="<?= (int)$consulta['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
                <tr class="details-row"><td colspan="7"><strong>Realizados:</strong> <?= e($consulta['procedimentos_realizados'] ?: '—') ?> &nbsp; <strong>A realizar:</strong> <?= e($consulta['procedimentos_arealizar'] ?: '—') ?> &nbsp; <strong>Descrição:</strong> <?= e($consulta['descricao'] ?: '—') ?> &nbsp; <strong>Medicação:</strong> <?= e($consulta['medicacao'] ?: '—') ?></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../includes/rodape.php'; ?>
