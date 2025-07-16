<?php
const DATA_FILE = __DIR__ . '/data.json';

function lerTarefas() {
    $json = file_get_contents(DATA_FILE);
    return json_decode($json, true);
}

function salvarTarefas(array $tarefas) {
    $json = json_encode($tarefas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(DATA_FILE, $json);
}

function listarTarefas() {
    $tarefas = lerTarefas();
    foreach ($tarefas as $t) {
        $status = $t['concluida'] ? '✔️' : '❌';
        echo "{$t['id']}: {$t['tarefa']} [{$status}]\n";
    }
}

function adicionarTarefa(string $texto) {
    $tarefas = lerTarefas();
    $ids = array_column($tarefas, 'id');
    $novoId = $ids ? max($ids) + 1 : 1;
    $tarefas[] = ['id' => $novoId, 'tarefa' => $texto, 'concluida' => false];
    salvarTarefas($tarefas);
    echo "Tarefa adicionada!\n";
}

function atualizarTarefa(int $id, string $novoTexto) {
    $tarefas = lerTarefas();
    foreach ($tarefas as &$t) {
        if ($t['id'] === $id) {
            $t['tarefa'] = $novoTexto;
            salvarTarefas($tarefas);
            echo "Tarefa {$id} atualizada!\n";
            return;
        }
    }
    echo "ID não encontrado.\n";
}

function removerTarefa(int $id) {
    $tarefas = lerTarefas();
    $novas = array_filter($tarefas, fn($t) => $t['id'] !== $id);
    if (count($novas) < count($tarefas)) {
        salvarTarefas(array_values($novas));
        echo "Tarefa removida!\n";
    } else {
        echo "ID não encontrado.\n";
    }
}

function concluirTarefa(int $id) {
    $tarefas = lerTarefas();
    foreach ($tarefas as &$t) {
        if ($t['id'] === $id) {
            if (!$t['concluida']) {
                $t['concluida'] = true;
                salvarTarefas($tarefas);
                echo "Tarefa {$id} marcada como concluída!\n";
            } else {
                echo "Tarefa {$id} já está concluída.\n";
            }
            return;
        }
    }
    echo "ID não encontrado.\n";
}

// Só para demonstração inicial
if (PHP_SAPI === 'cli' && basename(__FILE__) === basename($_SERVER['PHP_SELF'])) {
    echo "Listando tarefas iniciais:\n";
    listarTarefas();
}
