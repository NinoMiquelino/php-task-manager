<?php

class TaskRepository {
    private const SESSION_KEY = 'tasks';

    public function __construct() {
        // Garante que a sessão está iniciada.
        // Em um ambiente de produção, isso seria gerenciado por um front controller.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Inicializa o array de tarefas na sessão se ele não existir
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    /**
     * Carrega todas as tarefas da sessão e as retorna como objetos Task.
     * @return Task[]
     */
    public function findAll(): array {
        $taskArrays = $_SESSION[self::SESSION_KEY];
        $tasks = [];
        
        foreach ($taskArrays as $data) {
            // Recria o objeto Task a partir dos dados persistidos
            $tasks[] = new Task(
                $data['title'],
                $data['id'],
                $data['completed']
            );
        }
        return $tasks;
    }

    /**
     * Salva uma tarefa na sessão.
     * @param Task $task
     */
    public function save(Task $task): void {
        $data = $task->toArray();
        $id = $data['id'];
        
        // Encontra a chave da tarefa existente ou prepara para adicionar
        $found = false;
        foreach ($_SESSION[self::SESSION_KEY] as $key => $existingTaskData) {
            if ($existingTaskData['id'] === $id) {
                // Atualiza a tarefa existente
                $_SESSION[self::SESSION_KEY][$key] = $data;
                $found = true;
                break;
            }
        }
        
        // Se não encontrou, é uma nova tarefa, adiciona ao final
        if (!$found) {
            $_SESSION[self::SESSION_KEY][] = $data;
        }
    }

    /**
     * Encontra uma tarefa por ID na sessão.
     * @param string $id
     * @return Task|null
     */
    public function findById(string $id): ?Task {
        foreach ($_SESSION[self::SESSION_KEY] as $data) {
            if ($data['id'] === $id) {
                return new Task(
                    $data['title'],
                    $data['id'],
                    $data['completed']
                );
            }
        }
        return null;
    }

    /**
     * Deleta uma tarefa por ID.
     * @param string $id
     */
    public function delete(string $id): void {
        foreach ($_SESSION[self::SESSION_KEY] as $key => $data) {
            if ($data['id'] === $id) {
                // Remove o item do array
                unset($_SESSION[self::SESSION_KEY][$key]);
                // Reindexa o array para evitar buracos (opcional, mas boa prática)
                $_SESSION[self::SESSION_KEY] = array_values($_SESSION[self::SESSION_KEY]);
                return;
            }
        }
    }
}
