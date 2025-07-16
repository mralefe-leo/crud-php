"# crud-php" 

Listar
php -r "require 'crud.php'; listarTarefas();"

Adicionar
php -r "require 'crud.php'; adicionarTarefa('Nova tarefa de teste');"

Atualizar (ex.: ID 1)
php -r "require 'crud.php'; atualizarTarefa(1, 'Texto modificado');"

Remover (ex.: ID 2)
php -r "require 'crud.php'; removerTarefa(2);"

Concluir (ex.: ID 1)
php -r "require 'crud.php'; concluirTarefa(1);"

Verificar
php -r "require 'crud.php'; listarTarefas();"
