/* eslint-disable max-len */
/* eslint-disable no-plusplus */
/* eslint-disable arrow-body-style */
const today = new Date();
const date = today.getDate();
const options = { month: 'short' };
const month = new Intl.DateTimeFormat('en-US', options).format(today);
const ul = document.querySelector('.todo-block');

// escape html special characters
const escapeHtml = (unsafe) => {
  return unsafe
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
};

// 每當重新整理頁面時
const refreshPage = () => {
  // 更新左上角的日期
  document.querySelector('.date').innerText = date;
  document.querySelector('.month').innerText = month;
  // 先 render 出「未完成的 to-do」
  const getNotFinished = window.localStorage.getItem('todoNotFinished');
  if (getNotFinished) {
    const notFinishedParse = JSON.parse(getNotFinished);
    const notFinishedArray = Object.values(notFinishedParse);
    const notFinishedLength = notFinishedArray.length;
    for (let i = 0; i < notFinishedLength; i++) {
      const notFinishedValue = notFinishedArray[i];
      const liNotFinished = document.createElement('li');
      liNotFinished.classList.add('todo-item');
      liNotFinished.setAttribute('data-content', notFinishedValue);
      liNotFinished.innerHTML = `
      <div class="todo-item-check"></div>
      <div class="todo-item-content">${escapeHtml(notFinishedValue)}</div>
      <div class="todo-item-delete"></div>
  `;
      ul.appendChild(liNotFinished);
    }
  }

  // 然後再 render 出「已完成的 to-do」
  const getFinished = window.localStorage.getItem('todoFinished');
  if (getFinished) {
    const getFinishedParse = JSON.parse(getFinished);
    const finishedArray = Object.values(getFinishedParse);
    const finishedLength = finishedArray.length;
    for (let i = 0; i < finishedLength; i++) {
      const finishedValue = finishedArray[i];
      const liFinished = document.createElement('li');
      liFinished.classList.add('todo-item');
      liFinished.classList.add('item-done');
      liFinished.setAttribute('data-content', finishedValue);
      liFinished.innerHTML = `
      <div class="todo-item-check"></div>
      <div class="todo-item-content">${escapeHtml(finishedValue)}</div>
      <div class="todo-item-delete"></div>
  `;
      ul.appendChild(liFinished);
    }
  }
};
// 先執行一次 refreshPage 函式
refreshPage();

// 儲存到 local storage 裡面
const setLocalStorage = () => {
  const dataNotFinished = {}; // 儲存「未完成的 to-do」
  const dataFinished = {}; // 儲存「已完成的 to-do」
  const todoItems = document.querySelectorAll('.todo-item');
  for (let i = 0; i < todoItems.length; i++) {
    if (!todoItems[i].classList.contains('item-done')) { // 如果是「未完成的 to-do」
      dataNotFinished[`${i}`] = todoItems[i].getAttribute('data-content');
    } else { // 如果是「已完成的 to-do」
      dataFinished[`${i}`] = todoItems[i].getAttribute('data-content');
    }
  }
  const dataNotFinishedString = JSON.stringify(dataNotFinished);
  const dataFinishedString = JSON.stringify(dataFinished);
  window.localStorage.setItem('todoNotFinished', dataNotFinishedString);
  window.localStorage.setItem('todoFinished', dataFinishedString);
};

// 把「已完成的 to-do」移到最下方
const moveFinished = () => {
  const itemFinished = document.querySelectorAll('.item-done');
  for (let i = 0; i < itemFinished.length; i++) {
    ul.removeChild(itemFinished[i]);
    ul.appendChild(itemFinished[i]);
  }
};

// 在畫面上新增一個 to-do
const addTodo = (e) => {
  const inputValue = e.target.value;
  const li = document.createElement('li');
  li.classList.add('todo-item');
  li.setAttribute('data-content', inputValue);
  li.innerHTML = `
        <div class="todo-item-check"></div>
        <div class="todo-item-content">${escapeHtml(inputValue)}</div>
        <div class="todo-item-delete"></div>
    `;
  ul.appendChild(li);

  document.querySelector('.add-todo').value = '';
  /*
  清空 input 欄位。
  如果寫成 inputValue = '' 就只是「把 inputValue 這個變數的值設為 ''」而已（把 inputValue 這個變數的內容清空），跟 input 欄位本身沒有任何關係，因此這樣是無法清空 input 欄位的
  （前面所寫的 let inputValue = e.target.value 也只是把 inputValue 這個變數的值設為 e.target.value 而已，跟 input 欄位本身也沒有任何關係）
  因此，一定要用 querySelector 再完整的選擇一次 input 元素，瀏覽器才知道我是要設定這個 input 元素的 value 為空，而不是要設定 inputValue 這個變數的值為空
  */

  moveFinished(); // 把「已完成的 to-do」移到最下方
  setLocalStorage(); // 每新增一個 to-do，就重新把全部的 to-do 都存到 local storage 裡面
};

// 每當 user 在 input 輸入內容，按下 Enter 時
document.querySelector('.add-todo').addEventListener('keydown', (e) => {
  if (!e.target.value) { // 如果 user 輸入的是空值
    return; // 就直接 return
  }
  if (e.keyCode === 13) {
    addTodo(e); // 在畫面上新增一個 to-do
  }
});

// 每當 ul 有點擊事件發生時
ul.addEventListener('click', (e) => {
  // check/uncheck 那個 to-do
  if (e.target.classList.contains('todo-item-check')) {
    e.target.parentNode.classList.toggle('item-done'); //
    /*
    把「要切換的 class name（.item-done）」只加在 to-do 的外層元素（li）上面，藉由 li 去動態調整內層子元素的 css
    好處是：只需要 toggle 一個 class name，就可以動態調整內層多個子元素的 css，很方便
    */

    // 讓「已完成的 to-do」移到最下方
    const itemFinished = e.target.parentNode;
    ul.removeChild(itemFinished); // 先移除 to-do
    ul.appendChild(itemFinished); // 再 append 到最下方
  }

  // 刪除那個 to-do
  if (e.target.classList.contains('todo-item-delete')) {
    e.target.parentNode.remove(); // 找到自己的父層（.todo-item）然後移除
  }
  moveFinished(); // 再把「所有已完成的 to-do」移到最下方
  setLocalStorage(); // 重新把全部的 to-do 都存到 local storage 裡面
});
