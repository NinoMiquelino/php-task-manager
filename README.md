## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 📋 Gerenciador de Tarefas (CRUD com PHP/AJAX e Sessão)

![Made with PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Frontend JavaScript](https://img.shields.io/badge/Frontend-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-38B2AC?logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/php-task-manager?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/php-task-manager?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/php-task-manager)

Este projeto implementa um sistema completo de Lista de Tarefas (To-Do List) que demonstra o padrão de arquitetura de múltiplas camadas (Service/Repository) e utiliza a sessão do PHP (`$_SESSION`) para persistência temporária de dados, simulando um banco de dados simples.

Toda a interação do usuário (Criar, Ler, Marcar como Concluído, Deletar) é feita via requisições assíncronas (AJAX), garantindo uma experiência de usuário moderna e fluida.

---

## 🚀 Arquitetura e Destaques

* **Persistência em Sessão (`$_SESSION`):** Os dados são mantidos enquanto o navegador estiver aberto e a sessão PHP estiver ativa, permitindo que as tarefas persistam entre reloads da página.
* **PHP POO (CRUD):** A lógica de negócios é isolada em:
    * `Task`: O modelo de dados (entidade).
    * `TaskRepository`: Gerencia a leitura/escrita de tarefas na `$_SESSION`.
    * `TaskService`: Aplica a lógica de negócios e validações para as operações CRUD.
* **AJAX com Métodos HTTP:** O `api.php` atua como um *router* para o backend, usando métodos HTTP apropriados:
    * `GET`: Obter a lista completa.
    * `POST`: Criar nova tarefa.
    * `PUT`/`PATCH`: Atualizar o título ou o status (`completed`).
    * `DELETE`: Excluir uma tarefa.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 7.4+ (POO, `$_SESSION`, Lógica CRUD, `json_encode/decode`).
* **Frontend:** HTML5, JavaScript Vanilla (`fetch` API), Tailwind CSS.

---

## 🧩 Estrutura do Projeto

```
php-task-manager/
├── index.html
├── README.md
├── .gitignore
└── 📁 src/
         ├── Task.php
         ├── TaskRepository.php
         ├── TaskService.php
         └── api.php
```
---

## ⚙️ Configuração e Instalação

### Pré-requisitos

1.  Um ambiente de servidor web com PHP.

### Execução

1.  Crie a estrutura de pastas e os arquivos conforme a estrutura do projeto.
2.  Execute o servidor embutido do PHP (a partir da raiz do projeto):
    ```bash
    php -S localhost:8001
    ```
3.  Acesse a aplicação no navegador: `http://localhost:8001/public/index.html`.

## 📝 Instruções de Uso

1.  **Adicionar Tarefa:** Digite o título no campo e clique em "Adicionar". O `POST` via AJAX será enviado, e o elemento será adicionado dinamicamente.
2.  **Marcar Concluído (Toggle):** Clique no texto do título da tarefa. Isso enviará uma requisição `PUT` para alternar o status (`completed`).
3.  **Excluir Tarefa:** Clique no ícone de lixeira (🗑️). Isso enviará uma requisição `DELETE` com o ID da tarefa.
4.  **Persistência:** Recarregue a página. As tarefas devem permanecer visíveis, pois estão armazenadas na `$_SESSION`.

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/php-task-manager/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/php-task-manager/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---
