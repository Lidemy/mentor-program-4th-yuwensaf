/* eslint-disable no-plusplus */
/* eslint-disable consistent-return */
const request = require('request');

const API_ENDPOINT = 'https://lidemy-book-store.herokuapp.com';

request(`${API_ENDPOINT}/books?_limit=10`,
  (error, response, body) => {
    if (error) {
      return console.log('抓取失敗', error);
    }
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
