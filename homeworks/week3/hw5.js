/* eslint-disable no-plusplus */
/* eslint-disable no-use-before-define */
/* eslint-disable no-param-reassign */
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
  const n = Number(lines[0]);
  for (let i = 1; i <= n; i++) {
    const [a, b, k] = lines[i].split(' ');
    console.log(compare(a, b, k));
  }
}

function compare(a, b, k) {
  if (a === b) {
    return 'DRAW';
  }

  // 如果是要比小，就把 a, b 的值對調
  // eslint-disable-next-line
  if (k == -1) {
    // eslint-disable-next-line
    let temp = a;
    a = b;
    b = temp;
  }

  // 假設都是比大
  // 如果 a, b 的長度不同，就是「長度比較多的贏」
  if (a.length !== b.length) {
    return a.length > b.length ? 'A' : 'B';
  }

  // 如果 a, b 的長度相同，就直接比較「字典序」即可
  return a > b ? 'A' : 'B';
}
