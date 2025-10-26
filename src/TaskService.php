<?php

// Requer as dependências para uso
require_once 'Task.php';
require_once 'TaskRepository.php';

class TaskService {
    private TaskRepository $repository;

    public function __construct() {
        $this->repository = new TaskRepository();
    }

    /**
     * Cria uma nova tarefa.
     * @param string $title
     * @return Task
     */
    public function create(string $title): Task {
        if (empty(trim($title))) {
            throw new Exception("O título da tarefa não pode estar vazio.", 400);
        }
        $task = new Task($title);
        $this->repository->save($task);
        return $task;
    }

    /**
     * Obtém todas as tarefas.
     * @return array
     */
    public function getAll(): array {
        $tasks = $this->repository->findAll();
        // Converte a lista de objetos Task em array para envio ao JSON
        return array_map(fn($task) => $task->toArray(), $tasks);
    }

    /**
     * Atualiza o título e/ou status de uma tarefa.
     * @param string $id
     * @param string|null $title
     * @param bool|null $completed
     * @return Task
     */
    public function update(string $id, ?string $title, ?bool $completed): Task {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new Exception("Tarefa com ID '{$id}' não encontrada.", 404);
        }

        if ($title !== null) {
            if (empty(trim($title))) {
                throw new Exception("O título não pode estar vazio durante a atualização.", 400);
            }
            $task->setTitle($title);
        }

        if ($completed !== null) {
            $task->setCompleted($completed);
        }

        $this->repository->save($task);
        return $task;
    }

    /**
     * Alterna o status de conclusão da tarefa (Toggle).
     * @param string $id
     * @return Task
     */
    public function toggleCompleted(string $id): Task {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new Exception("Tarefa com ID '{$id}' não encontrada.", 404);
        }

        $task->setCompleted(!$task->isCompleted());
        $this->repository->save($task);
        return $task;
    }

    /**
     * Deleta uma tarefa.
     * @param string $id
     */
    public function delete(string $id): void {
        $task = $this->repository->findById($id);
        
        if (!$task) {
            throw new Exception("Tarefa com ID '{$id}' não encontrada para exclusão.", 404);
        }
        $this->repository->delete($id);
    }
}
