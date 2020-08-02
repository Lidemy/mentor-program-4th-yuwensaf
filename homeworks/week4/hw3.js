/* eslint-disable no-plusplus */
const request = require('request');
const process = require('process');

request(
  `https://restcountries.eu/rest/v2/name/${process.argv[2]}?fields=name;capital;currencies;callingCodes`,
  (err, res, body) => {
    let obj;
    try {
      obj = JSON.parse(body);
    } catch (error) {
      console.log(error);
    }

    for (let i = 0; i < obj.length; i++) {
      console.log(
        `
        國家：${obj[i].name}
        首都：${obj[i].capital}
        貨幣：${obj[i].currencies[0].code}
        國碼：${obj[i].callingCodes}
        `,
      );
    }
    if (res.statusCode < 200 || res.statusCode >= 300) {
      console.log('找不到國家資訊');
    }
  },
);
