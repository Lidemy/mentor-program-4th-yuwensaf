/* eslint-disable  no-plusplus */
/* eslint-disable consistent-return */
/* eslint-disable indent */
/* eslint-disable no-use-before-define */
/* eslint-disable no-unused-vars */
const request = require('request');
const process = require('process');

const apiEndpoint = 'https://lidemy-book-store.herokuapp.com';
const args = process.argv;
const action = args[2];
const param = args[3];

switch (action) {
  case 'list':
    listBooks();
    break;
  case 'read':
    readABook(param);
    break;
  case 'delete':
    deleteABook(param);
    break;
  case 'create':
    createABook(param);
    break;
  case 'update':
    updateABook(param, args[4]);
    break;
  default:
    console.log('Available commands: list, read, delete, create and update');
}


// 印出前二十本書的 id 與書名
function listBooks() {
  request(`${apiEndpoint}/books?_limit=20`,
    (error, response, body) => {
      /*
      * 把 return 寫在最上面，因為：有錯誤就儘早 return，
      * 就不用浪費時間去執行後面的程式碼
      */
      if (error) {
        return console.log('抓取失敗', error);
      }
      /*
      * 這裡不需要使用 try...catch 是因為：如果有 error，在前一句就已經 return 了。
      * 如果會執行到這裡，就代表沒有 error
      */
      const obj = JSON.parse(body);
      for (let i = 0; i < obj.length; i++) {
        console.log(`${obj[i].id} ${obj[i].name}`);
      }
    });
}

// 輸出 id 為 xx 的書籍
function readABook(id) {
  request(`${apiEndpoint}/books/${id}`,
    (error, response, body) => {
      if (error) {
        return console.log('抓取失敗', error);
      }
      const obj = JSON.parse(body);
      console.log(obj.name);
    });
}

// 刪除 id 為 xx 的書籍
function deleteABook(id) {
  request.delete(`${apiEndpoint}/books/${id}`,
    (err, res, body) => {
      if (err) {
        return console.log('刪除失敗', err);
      }
      console.log('刪除成功！');
    });
}

// 新增一本名為 xxxxx 的書
function createABook(bookName) {
  request.post(
    {
      url: `${apiEndpoint}/books`,
      form: { name: `${bookName}` },
    },
    (err, res) => {
      if (err) {
        return console.log('新增失敗', err);
      }
      console.log('新增成功！');
    },
  );
}

// 更新 id 為 xx 的書名為 ooooo
function updateABook(id, newName) {
  request.patch(
    {
      url: `${apiEndpoint}/books/${id}`,
      form: { name: newName },
    },
    (err, res) => {
      if (err) {
        return console.log('更新失敗', err);
      }
      console.log('更新成功！');
    },
  );
}
