/* eslint-disable no-plusplus */
const request = require('request');

request('https://lidemy-book-store.herokuapp.com/books?_limit=10',
  (error, response, body) => {
    let obj;
    try {
      obj = JSON.parse(body);
    } catch (e) {
      console.log(e);
    }

    for (let i = 0; i < obj.length; i++) {
      console.log(`${obj[i].id} ${obj[i].name}`);
    }
  });
