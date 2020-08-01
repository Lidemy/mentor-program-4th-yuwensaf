/* eslint-disable  no-plusplus */
const request = require('request');
const process = require('process');

const apiEndpoint = 'https://lidemy-book-store.herokuapp.com/books';

// 印出前二十本書的 id 與書名
if (process.argv[2] === 'list') {
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
if (process.argv[2] === 'read') {
  request(`${apiEndpoint}/${process.argv[3]}`,
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
if (process.argv[2] === 'delete') {
  request.delete(`${apiEndpoint}/${process.argv[3]}`);
}

// 新增一本名為 xxxxx 的書
if (process.argv[2] === 'create') {
  request.post(
    `${apiEndpoint}`,
    { form: { name: `${process.argv[3]}` } },
  );
}

// 更新 id 為 xx 的書名為 ooooo
if (process.argv[2] === 'update') {
  request.patch(
    `${apiEndpoint}/${process.argv[3]}`,
    { form: { name: `${process.argv[4]}` } },
  );
}
