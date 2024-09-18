// Seleção de elementos
const todoForm = document.querySelector("#todo-form");
const todoInput = document.querySelector("#todo-input");
const todoList = document.querySelector("#todo-list");
const editForm = document.querySelector("#edit-form");
const editInput = document.querySelector("#edit-input");
const cancelEditBtn = document.querySelector("#cancel-edit-btn");
const searchInput = document.querySelector("#search-input");
const eraseBtn = document.querySelector("#erase-button");
const filterBtn = document.querySelector("#filter-select");

let oldInputValue;

// Funções
const saveTodo = async (text, done = 0, save = 1, id = null) => {
  const todo = document.createElement("div");
  todo.classList.add("todo");

  const todoTitle = document.createElement("h3");
  todoTitle.innerText = text;
  todo.appendChild(todoTitle);

  const doneBtn = document.createElement("button");
  doneBtn.classList.add("finish-todo");
  doneBtn.innerHTML = '<i class="fa-solid fa-check"></i>';
  todo.appendChild(doneBtn);

  const editBtn = document.createElement("button");
  editBtn.classList.add("edit-todo");
  editBtn.innerHTML = '<i class="fa-solid fa-pen"></i>';
  todo.appendChild(editBtn);

  const deleteBtn = document.createElement("button");
  deleteBtn.classList.add("remove-todo");
  deleteBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
  todo.appendChild(deleteBtn);

  // Adiciona id do todo no DOM
  todo.dataset.id = id;

  if (done) {
    todo.classList.add("done");
  }

  todoList.appendChild(todo);
  todoInput.value = "";

  if (save) {
    // Envia requisição POST para salvar tarefa
    const response = await fetch('tarefas.php', {
      method: 'POST',
      body: new URLSearchParams({ text })
    });
    const newTodo = await response.json();
    if (newTodo.id) {
      todo.dataset.id = newTodo.id; // Atualiza o id do DOM com o ID do banco de dados
    }
  }
};

const loadTodos = async () => {
  const response = await fetch('tarefas.php');
  const todos = await response.json();
  todos.forEach((todo) => saveTodo(todo.text, todo.done, 0, todo.id));
};

const updateTodo = async (id, text) => {
  const todos = document.querySelectorAll(".todo");
  todos.forEach((todo) => {
    let todoTitle = todo.querySelector("h3");
    if (todo.dataset.id == id) {
      todoTitle.innerText = text;
    }
  });

  // Atualiza no banco de dados
  await fetch('tarefas.php', {
    method: 'PUT',
    body: new URLSearchParams({ id, text })
  });
};

const removeTodo = async (id, element) => {
  element.remove();
  await fetch('tarefas.php', {
    method: 'DELETE',
    body: new URLSearchParams({ id })
  });
};

// Eventos
todoForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const inputValue = todoInput.value;
  if (inputValue) {
    saveTodo(inputValue);
  }
});

document.addEventListener("click", async (e) => {
  const targetEl = e.target;
  const parentEl = targetEl.closest("div");
  const todoId = parentEl?.dataset.id;

  if (targetEl.classList.contains("finish-todo")) {
    parentEl.classList.toggle("done");
    const done = parentEl.classList.contains("done") ? 1 : 0;
    await fetch('tarefas.php', {
      method: 'PATCH',
      body: new URLSearchParams({ id: todoId, done })
    });
  }

  if (targetEl.classList.contains("remove-todo")) {
    removeTodo(todoId, parentEl);
  }

  if (targetEl.classList.contains("edit-todo")) {
    toggleForms();
    editInput.value = parentEl.querySelector("h3").innerText;
    oldInputValue = parentEl.querySelector("h3").innerText;
  }
});

editForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const editInputValue = editInput.value;
  const todos = document.querySelectorAll(".todo");
  const todo = Array.from(todos).find(t => t.querySelector("h3").innerText === oldInputValue);
  const todoId = todo?.dataset.id;

  if (editInputValue && todoId) {
    updateTodo(todoId, editInputValue);
  }
  toggleForms();
});

loadTodos();
