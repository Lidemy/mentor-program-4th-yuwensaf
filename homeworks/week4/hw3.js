/* eslint-disable no-plusplus */
/* eslint-disable consistent-return */
const request = require('request');
const process = require('process');

const args = process.argv;
const API_ENDPOINT = 'https://restcountries.eu/rest/v2';
const countryName = args[2]; // 輸入的國家名稱

if (!countryName) {
  console.log('請輸入國家名稱');
}

/*
* 在參考解答中，這裡沒有 function，為什麼可以 return 呢？
if (!countryName) {
  return console.log('請輸入國家名稱');
}
*/

request(
  `${API_ENDPOINT}/name/${countryName}?fields=name;capital;currencies;callingCodes`,
  (err, res, body) => {
    if (err) {
      return console.log('抓取失敗', err);
    }

    if (res.statusCode === 404) {
      return console.log('找不到國家資訊');
    }

    const obj = JSON.parse(body);
    for (let i = 0; i < obj.length; i++) {
      console.log(
        `
        ============
        國家：${obj[i].name}
        首都：${obj[i].capital}
        貨幣：${obj[i].currencies[0].code}
        國碼：${obj[i].callingCodes[0]}
        `,
      );
    }
  },
);
