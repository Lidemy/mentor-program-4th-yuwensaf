/* eslint-disable no-plusplus */
/* eslint-disable no-use-before-define */
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
});

const lines = [];

// 讀取到一行，先把這一行加進去 lines 陣列，最後再一起處理
rl.on('line', (line) => {
  lines.push(line);
});

// 輸入結束，開始針對 lines 做處理
rl.on('close', () => {
  solve(lines);
});

// 上面都不用管，只需要完成這個 function 就好，可以透過 lines[i] 拿取內容
// eslint-disable-next-line
function solve(lines) {
  const input = lines[0].split(' ');
  const n = Number(input[0]);
  const m = Number(input[1]);
  for (let i = n; i <= m; i++) {
    if (isNarcissistic(i)) {
      console.log(i);
    }
  }
}

function isNarcissistic(number) {
  const str = JSON.stringify(number);
  const digits = str.length;
  let sum = 0;
  for (let i = 0; i < digits; i++) {
    // eslint-disable-next-line
    sum += Math.pow(Number(str[i]), digits);
  }
  return sum === number;
}


solve(['5 200']);
