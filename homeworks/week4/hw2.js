/* eslint-disable  no-plusplus */
const request = require('request');
const process = require('process');

const apiEndpoint = 'https://lidemy-book-store.herokuapp.com/books';
const action = process.argv[2];
const bookInfo = process.argv[3];
const bookNewName = process.argv[4];

// 印出前二十本書的 id 與書名
if (action === 'list') {
  request(`${apiEndpoint}?_limit=20`,
    (error, response, body) => {
      let obj;
      try {
        obj = JSON.parse(body);
      } catch (err) {
        console.log(err);
      }

      for (let i = 0; i < obj.length; i++) {
        console.log(`${obj[i].id} ${obj[i].name}`);
      }
    });
}

// 輸出 id 為 xx 的書籍
if (action === 'read') {
  request(`${apiEndpoint}/${bookInfo}`,
    (error, response, body) => {
      let obj;
      try {
        obj = JSON.parse(body);
      } catch (err) {
        console.log(err);
      }

      console.log(obj.name);
    });
}

// 刪除 id 為 xx 的書籍
if (action === 'delete') {
  request.delete(`${apiEndpoint}/${bookInfo}`);
}

// 新增一本名為 xxxxx 的書
if (action === 'create') {
  request.post(
    `${apiEndpoint}`,
    { form: { name: `${bookInfo}` } },
  );
}

// 更新 id 為 xx 的書名為 ooooo
if (action === 'update') {
  request.patch(
    `${apiEndpoint}/${bookInfo}`,
    { form: { name: `${bookNewName}` } },
  );
}
