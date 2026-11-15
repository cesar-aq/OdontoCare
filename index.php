
<?php
require_once __DIR__ . '/config/bootstrap.php';
$titulo = 'Início | OdontoCare';
$consultas = Consulta::listar();
$totalConsultas = count($consultas);
$proximasConsultas = array_values(array_filter($consultas, function ($consulta) {
    return strtotime($consulta['data_hora']) >= strtotime('today');
}));
$proximasConsultas = array_slice($proximasConsultas, 0, 4);
include __DIR__ . '/view/includes/cabecalho.php';
include __DIR__ . '/view/includes/menu.php';
?>
<main class="container page-content home-content">
    <section class="hero-section">
        <div class="hero-copy">
            <span class="eyebrow">GESTÃO ODONTOLÓGICA</span>
            <h2>Seu sorriso merece <span>cuidado.</span></h2>
            <p>Organize os atendimentos, acompanhe os agendamentos e mantenha as informações das consultas em um só lugar.</p>
            <div class="hero-actions">
                <a class="btn btn-light btn-lg" href="<?= BASE_URL ?>/view/consulta/listar.php">Ver consultas <span aria-hidden="true">→</span></a>
                <a class="btn btn-outline-light btn-lg" href="<?= BASE_URL ?>/view/consulta/cadastrar.php">Cadastrar consulta</a>
            </div>
        </div>
        <div class="hero-art" aria-hidden="true">
            <div class="art-circle circle-one"></div><div class="art-circle circle-two"></div>
            <div class="tooth-card"><div class="tooth-icon">✦</div><strong>OdontoCare</strong><span>Atendimento organizado</span><div class="tooth-line"></div><div class="tooth-line short"></div></div>
            <div class="floating-note"><span class="note-dot"></span> Cuidado em cada consulta</div>
        </div>
    </section>
    <section class="dashboard-section">
        <div class="section-heading"><span class="eyebrow">PAINEL GERAL</span><h2>Bem-vindo ao OdontoCare</h2><p>Acesse rapidamente as principais funções do sistema.</p></div>
        <div class="row g-3 dashboard-cards">
            <div class="col-md-4"><a class="dashboard-card" href="<?= BASE_URL ?>/view/consulta/listar.php"><span class="card-icon icon-teal">▤</span><span class="card-label">Consultas cadastradas</span><strong class="card-number"><?= $totalConsultas ?></strong><span class="card-link">Acessar listagem <b>→</b></span></a></div>
            <div class="col-md-4"><a class="dashboard-card" href="<?= BASE_URL ?>/view/consulta/cadastrar.php"><span class="card-icon icon-blue">＋</span><span class="card-label">Novo atendimento</span><strong class="card-number">Cadastrar</strong><span class="card-link">Registrar consulta <b>→</b></span></a></div>
            <div class="col-md-4"><a class="dashboard-card" href="<?= BASE_URL ?>/view/consulta/listar.php"><span class="card-icon icon-gold">◷</span><span class="card-label">Próximas consultas</span><strong class="card-number"><?= count($proximasConsultas) ?></strong><span class="card-link">Conferir agenda <b>→</b></span></a></div>
        </div>
    </section>
    <section class="appointments-preview">
        <div class="section-heading inline-heading"><div><span class="eyebrow">ACOMPANHAMENTO</span><h2>Próximos atendimentos</h2></div><a class="text-link" href="<?= BASE_URL ?>/view/consulta/listar.php">Ver todas as consultas →</a></div>
        <?php if (!$proximasConsultas): ?>
            <div class="empty-state"><div class="empty-icon">▦</div><strong>Nenhum próximo atendimento encontrado</strong><p>Cadastre uma consulta para começar a organizar a agenda.</p><a href="<?= BASE_URL ?>/view/consulta/cadastrar.php" class="btn btn-primary">Cadastrar consulta</a></div>
        <?php else: ?>
            <div class="appointment-list">
                <?php foreach ($proximasConsultas as $consulta): ?>
                    <div class="appointment-item"><div class="appointment-date"><strong><?= date('d', strtotime($consulta['data_hora'])) ?></strong><span><?= date('M', strtotime($consulta['data_hora'])) ?></span></div><div class="appointment-info"><strong><?= e($consulta['paciente_nome']) ?></strong><span><?= e($consulta['dentista_nome']) ?></span></div><div class="appointment-time"><?= date('H:i', strtotime($consulta['data_hora'])) ?></div><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/view/consulta/editar.php?id=<?= (int)$consulta['id'] ?>">Detalhes</a></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php include __DIR__ . '/view/includes/rodape.php'; ?>
