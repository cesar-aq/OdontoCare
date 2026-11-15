<?php
require_once __DIR__ . '/../../config/bootstrap.php';
$titulo = 'Cadastrar consulta';
$pacientes = Consulta::listarPacientes();
$dentistas = Consulta::listarDentistas();
include __DIR__ . '/../includes/cabecalho.php';
include __DIR__ . '/../includes/menu.php';
?>
<main class="container page-content">
    <h2 class="mb-4">Cadastrar consulta</h2>
    <?php if (!$pacientes || !$dentistas): ?>
        <div class="alert alert-warning">Cadastre ao menos um paciente e um dentista no banco de dados antes de registrar uma consulta.</div>
    <?php endif; ?>
    <form method="post" action="<?= BASE_URL ?>/action/action_consulta.php" class="row g-3">
        <input type="hidden" name="acao" value="cadastrar">
        <div class="col-md-6">
            <label class="form-label">Paciente *</label>
            <select name="paciente_id" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= (int)$paciente['id'] ?>"><?= e($paciente['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Dentista *</label>
            <select name="dentista_id" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach ($dentistas as $dentista): ?>
                    <option value="<?= (int)$dentista['id'] ?>"><?= e($dentista['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Data e hora *</label><input type="datetime-local" name="data_hora" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Valor total (R$) *</label><input type="number" name="valor_total" min="0" step="0.01" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Valor pago (R$) *</label><input type="number" name="valor_pago" min="0" step="0.01" value="0" class="form-control" required></div>
        <div class="col-md-6">
            <label class="form-label">Forma de pagamento *</label>
            <select name="forma_pagamento" class="form-select" required>
                <option value="">Selecione</option><option>DINHEIRO</option><option>PIX</option><option>CARTÃO DE DEBITO</option><option>CARTÃO DE CREDITO</option>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label">Procedimentos realizados</label><input name="procedimentos_realizados" class="form-control" maxlength="255"></div>
        <div class="col-md-6"><label class="form-label">Procedimentos a realizar</label><input name="procedimentos_arealizar" class="form-control" maxlength="255"></div>
        <div class="col-md-6"><label class="form-label">Medicação</label><input name="medicacao" class="form-control" maxlength="255"></div>
        <div class="col-12"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control" rows="3" maxlength="255"></textarea></div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Salvar consulta</button> <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/view/consulta/listar.php">Cancelar</a></div>
    </form>
</main>
<?php include __DIR__ . '/../includes/rodape.php'; ?>
