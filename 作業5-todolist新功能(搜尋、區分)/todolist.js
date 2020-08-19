const byId = (id) => document.getElementById(id);
const todoInput = byId('todoInput');
const todoAdd = byId('todoAdd');
const todoList = byId('todoList');
const todoInput_search = byId('todoInput_search');
const todoSearch = byId('todoSearch');

let data = [
  { id: 111, text: '吃飯飯', status: true, editStatus: true },
  { id: 2222, text: '睡覺覺', status: true, editStatus: false },
];

const changeComplete = (btnId) => {
  for (let i = 0; i < data.length; i++) {
    // 記得把id轉數字
    if (data[i].id === +btnId) {
      data[i].status = !data[i].status;
    }
  }
};

const saveData = (btnId, value) => {
  for (let i = 0; i < data.length; i++) {
    if (data[i].id === +btnId) {
      data[i].text = value;
      data[i].editStatus = false;
    }
  }
};

const changeEdit = (editBtnId) => {
  for (let i = 0; i < data.length; i++) {
    // 先將其他正在編輯的物件關閉
    data[i].editStatus = false;
    if (data[i].id == +editBtnId) {
      data[i].editStatus = true;
    }
  }
};

const delItem = (delBtnId) => {
  // const updateData = [];
  // for (let i = 0; i < data.length; i++) {
  //   if (data[i].id !== +delBtnId) {
  //     updateData.push(data[i]);
  //   }
  // }
  // data = [];
  // data = updateData;
  const updateData = data.filter((item) => item.id !== +delBtnId);
  data = [...updateData];
};

// 畫面渲染,並依序加掛事件監聽
function render() {
  let display = '';
  for (let i = 0; i < data.length; i++) {
    if (data[i].editStatus) {
      display += `<li>
    <input value="${data[i].text}" id="editInput" />
    <button class="saveBtn" data-id="${data[i].id}">儲存</button>
    <button class="statusBtn" data-id="${data[i].id}">完成狀態切換</button>
    <button class="delBtn" data-id="${data[i].id}">刪除</button></li>`;
    } else {
      data[i].status
        ? (display += `<li>
      <del><span class="todo-item" data-id="${data[i].id}">${data[i].text}</span></del>
      <button class="editBtn" data-id="${data[i].id}">編輯</button>
      <button class="statusBtn" data-id="${data[i].id}">完成狀態切換</button>
      <button class="delBtn" data-id="${data[i].id}">刪除</button></li>`)
        : (display += `<li class="todo-item">
      <span class="todo-item" data-id="${data[i].id}">${data[i].text}</span>
      <button class="editBtn" data-id="${data[i].id}">編輯</button>
      <button class="statusBtn" data-id="${data[i].id}">完成狀態切換</button>
      <button class="delBtn" data-id="${data[i].id}">刪除</button></li>`);
    }
  }

  todoList.innerHTML = `<ul>${display}</ul>`;
  // 完成的事件監聽加掛
  const statusBtn = document.getElementsByClassName('statusBtn');
  for (let i = 0; i < data.length; i++) {
    statusBtn[i].addEventListener('click', (event) => {
      changeComplete(event.target.dataset.id);
      render();
    });
  }
  // 刪除的事件監聽加掛
  const delBtn = document.getElementsByClassName('delBtn');
  for (let i = 0; i < delBtn.length; i++) {
    delBtn[i].addEventListener('click', (event) => {
      delItem(event.target.dataset.id);
      render();
    });
  }
  // 編輯的事件監聽加掛
  const editBtn = document.getElementsByClassName('editBtn');
  for (let i = 0; i < editBtn.length; i++) {
    editBtn[i].addEventListener('click', (event) => {
      changeEdit(event.target.dataset.id);
      render();
    });
  }
  // 雙擊編輯
  const dblBtn = document.getElementsByClassName('todo-item');
  for (let i = 0; i < dblBtn.length; i++) {
    dblBtn[i].addEventListener('dblclick', (event) => {
      changeEdit(event.target.dataset.id);
      render();
    });
  }
  // 儲存的事件監聽加掛
  const saveBtn = document.getElementsByClassName('saveBtn');
  for (let i = 0; i < saveBtn.length; i++) {
    saveBtn[i].addEventListener('click', (event) => {
      saveData(
        event.target.dataset.id,
        document.getElementById('editInput').value
      );
      render();
    });
  }
}

todoAdd.addEventListener('click', () => {
  const item = {
    id: +new Date(),
    text: todoInput.value,
    status: false,
  };
  if (todoInput.value.trim()) {
    data.unshift(item);
    todoInput.value = '';
    render();
  }
  console.log(data);
});

todoInput.addEventListener('keypress', (event) => {
  if (event.key === 'Enter') {
    const item = {
      id: +new Date(),
      text: todoInput.value,
      status: false,
    };
    if (todoInput.value.trim()) {
      data.unshift(item);
      todoInput.value = '';
      render();
    }
    console.log(data);
  }
});

todoSearch.addEventListener('click', () => {
  search_Words = todoInput_search.value;
  searchRender();
});

render();

// 搜尋功能
let search_Words = '';
const searchRender = () => {
  const searchString = data.map((item) => {
    if (!item.text.includes(search_Words)) return;
    let displayString = '';

    // 先判斷是否進入編輯狀態
    if (item.edited) {
      displayString = `<li><input type="text" id="todo-item-edit" value="${item.text}" />
    <button class="todo-save" data-id="${item.id}">儲存</button>
    <button class="todo-complete" data-id="${item.id}">完成</button>
    <button class="todo-delete" data-id="${item.id}">刪除</button>
     </li>`;
    } else {
      // 再判斷是否為完成狀態
      displayString = item.completed
        ? `<li>
       <del>
       <span class="todo-item" data-id="${item.id}">${item.text}</span>
       </del>
       <button class="todo-edit" data-id="${item.id}">編輯</button>
       <button class="todo-complete" data-id="${item.id}">完成</button>
       <button class="todo-delete" data-id="${item.id}">刪除</button>
      </li>`
        : `<li>
       <span class="todo-item" data-id="${item.id}"> ${item.text}</span>
       <button class="todo-edit" data-id="${item.id}">編輯</button>
       <button class="todo-complete" data-id="${item.id}">完成</button>
       <button class="todo-delete" data-id="${item.id}">刪除</button>
       </li>`;
    }
    return displayString;
  });
  todoList.innerHTML = `<ul>${searchString.join('')}</ul>`;
  console.log(search_Words);
};
