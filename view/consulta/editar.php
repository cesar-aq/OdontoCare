<?php
require_once __DIR__ . '/../../config/bootstrap.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$consulta = $id ? Consulta::buscarPorId($id) : null;
if (!$consulta) {
    $_SESSION['erro'] = 'Consulta não encontrada.';
    redirect('/view/consulta/listar.php');
}
$titulo = 'Alterar consulta';
$pacientes = Consulta::listarPacientes();
$dentistas = Consulta::listarDentistas();
include __DIR__ . '/../includes/cabecalho.php';
include __DIR__ . '/../includes/menu.php';
$dataHora = date('Y-m-d\TH:i', strtotime($consulta['data_hora']));
?>
<main class="container page-content">
    <h2 class="mb-4">Alterar consulta #<?= (int)$consulta['id'] ?></h2>
    <form method="post" action="<?= BASE_URL ?>/action/action_consulta.php" class="row g-3">
        <input type="hidden" name="acao" value="alterar"><input type="hidden" name="id" value="<?= (int)$consulta['id'] ?>">
        <div class="col-md-6"><label class="form-label">Paciente *</label><select name="paciente_id" class="form-select" required>
            <?php foreach ($pacientes as $paciente): ?><option value="<?= (int)$paciente['id'] ?>" <?= $paciente['id'] == $consulta['paciente_id'] ? 'selected' : '' ?>><?= e($paciente['nome']) ?></option><?php endforeach; ?>
        </select></div>
        <div class="col-md-6"><label class="form-label">Dentista *</label><select name="dentista_id" class="form-select" required>
            <?php foreach ($dentistas as $dentista): ?><option value="<?= (int)$dentista['id'] ?>" <?= $dentista['id'] == $consulta['dentista_id'] ? 'selected' : '' ?>><?= e($dentista['nome']) ?></option><?php endforeach; ?>
        </select></div>
        <div class="col-md-4"><label class="form-label">Data e hora *</label><input type="datetime-local" name="data_hora" value="<?= e($dataHora) ?>" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Valor total (R$) *</label><input type="number" name="valor_total" min="0" step="0.01" value="<?= e($consulta['valor_total']) ?>" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Valor pago (R$) *</label><input type="number" name="valor_pago" min="0" step="0.01" value="<?= e($consulta['valor_pago']) ?>" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Forma de pagamento *</label><select name="forma_pagamento" class="form-select" required>
            <?php foreach (['DINHEIRO','PIX','CARTÃO DE DEBITO','CARTÃO DE CREDITO'] as $forma): ?><option value="<?= e($forma) ?>" <?= $forma === $consulta['forma_pagamento'] ? 'selected' : '' ?>><?= e($forma) ?></option><?php endforeach; ?>
        </select></div>
        <div class="col-md-6"><label class="form-label">Procedimentos realizados</label><input name="procedimentos_realizados" value="<?= e($consulta['procedimentos_realizados']) ?>" class="form-control" maxlength="255"></div>
        <div class="col-md-6"><label class="form-label">Procedimentos a realizar</label><input name="procedimentos_arealizar" value="<?= e($consulta['procedimentos_arealizar']) ?>" class="form-control" maxlength="255"></div>
        <div class="col-md-6"><label class="form-label">Medicação</label><input name="medicacao" value="<?= e($consulta['medicacao']) ?>" class="form-control" maxlength="255"></div>
        <div class="col-12"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control" rows="3" maxlength="255"><?= e($consulta['descricao']) ?></textarea></div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Salvar alterações</button> <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/view/consulta/listar.php">Cancelar</a></div>
    </form>
</main>
<?php include __DIR__ . '/../includes/rodape.php'; ?>
