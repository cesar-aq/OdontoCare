<?php
class Consulta {
    public ?int $id = null;
    public int $paciente_id;
    public int $dentista_id;
    public string $data_hora;
    public float $valor_total;
    public float $valor_pago;
    public string $forma_pagamento;
    public ?string $procedimentos_realizados = null;
    public ?string $procedimentos_arealizar = null;
    public ?string $descricao = null;
    public ?string $medicacao = null;

    private function dados(): array {
        return [
            $this->paciente_id,
            $this->dentista_id,
            $this->data_hora,
            $this->valor_total,
            $this->valor_pago,
            $this->forma_pagamento,
            $this->procedimentos_realizados,
            $this->procedimentos_arealizar,
            $this->descricao,
            $this->medicacao
        ];
    }

    public function cadastrar(): int {
        $db = new DataBase();
        $sql = 'INSERT INTO consulta
            (paciente_id, dentista_id, data_hora, valor_total, valor_pago,
             forma_pagamento, procedimentos_realizados, procedimentos_arealizar, descricao, medicacao)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->id = $db->insert($sql, $this->dados());
        return $this->id;
    }

    public function alterar(): bool {
        if (!$this->id) {
            return false;
        }
        $db = new DataBase();
        $sql = 'UPDATE consulta SET paciente_id = ?, dentista_id = ?, data_hora = ?,
            valor_total = ?, valor_pago = ?, forma_pagamento = ?, procedimentos_realizados = ?,
            procedimentos_arealizar = ?, descricao = ?, medicacao = ? WHERE id = ?';
        $values = $this->dados();
        $values[] = $this->id;
        return $db->execute($sql, $values)->rowCount() >= 0;
    }

    public function excluir(): bool {
        if (!$this->id) {
            return false;
        }
        $db = new DataBase();
        return $db->execute('DELETE FROM consulta WHERE id = ?', [$this->id])->rowCount() > 0;
    }

    public static function listar(): array {
        $db = new DataBase();
        $sql = 'SELECT c.*, p.nome AS paciente_nome, f.nome AS dentista_nome
                FROM consulta c
                INNER JOIN paciente p ON p.id = c.paciente_id
                INNER JOIN funcionario f ON f.id = c.dentista_id
                ORDER BY c.data_hora DESC';
        return $db->select($sql);
    }

    public static function buscarPorId(int $id): ?array {
        $db = new DataBase();
        return $db->selectOne('SELECT * FROM consulta WHERE id = ?', [$id]);
    }

    public static function listarPacientes(): array {
        return (new DataBase())->select('SELECT id, nome FROM paciente ORDER BY nome');
    }

    public static function listarDentistas(): array {
        return (new DataBase())->select("SELECT id, nome FROM funcionario WHERE perfil = 'dentista' ORDER BY nome");
    }
}
