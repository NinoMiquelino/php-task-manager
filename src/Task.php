<?php

class Task {
    private string $id;
    private string $title;
    private bool $completed;

    public function __construct(string $title, string $id = null, bool $completed = false) {
        // Se o ID não for fornecido (nova tarefa), gera um ID único.
        $this->id = $id ?? uniqid();
        $this->title = $title;
        $this->completed = $completed;
    }

    // Método para obter o array de dados para salvar na sessão ou enviar ao cliente
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'completed' => $this->completed
        ];
    }

    // --- Getters ---
    public function getId(): string {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function isCompleted(): bool {
        return $this->completed;
    }

    // --- Setters (para atualizações) ---
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setCompleted(bool $completed): void {
        $this->completed = $completed;
    }
}
