/* eslint-disable prefer-arrow-callback */
/* eslint-disable comma-dangle */
/* eslint-disable no-useless-return */
const apiUrl = 'https://dvwhnbka7d.execute-api.us-east-1.amazonaws.com/default/lottery';
const errMsg = '系統不穩定，請再試一次';

// 負責處理資料
function getPrize(cb) {
  const request = new XMLHttpRequest();
  request.onload = () => {
    if (request.status >= 200 && request.status < 400) { // 第一個錯誤處理：檢查 status code 是否是 2xx 或 3xx
      // 第二個錯誤處理：檢查是否有成功 parse 成物件
      let data;
      try {
        data = JSON.parse(request.responseText);
      } catch (err) {
        cb(errMsg);
        return;
      }

      // 第三個錯誤處理：檢查 data.prize 是否有東西
      if (!data.prize) { // 如果 data.prize 沒有東西
        cb(errMsg);
        return;
      }

      // 如果 data.prize 有東西
      cb(null, data);
    } else { // 如果 status code 不是 2xx 或 3xx
      cb(errMsg);
      return;
    }
  };

  request.onerror = () => {
    cb(errMsg);
    return;
  };

  request.open('GET', apiUrl, true);
  request.send();
}

// 負責處理畫面
document.querySelector('.lottery-btn').addEventListener('click', () => {
  getPrize(function (err, data) {
    if (err) { // 如果有傳來 errMsg，就跳出 alert 然後跳出 function
      alert(err);
      return;
    }

    // 如果沒有傳來 errMsg，就可以把 data 顯示在畫面上
    const prizes = {
      FIRST: {
        classname: 'first-prize',
        title: '恭喜你中頭獎了！日本東京來回雙人遊！'
      },
      SECOND: {
        classname: 'second-prize',
        title: '二獎！90 吋電視一台！'
      },
      THIRD: {
        classname: 'third-prize',
        title: '恭喜你抽中三獎：知名 YouTuber 簽名握手會入場券一張，bang！'
      },
      NONE: {
        classname: 'none',
        title: '銘謝惠顧'
      }
    };

    const { classname, title } = prizes[data.prize];
    document.querySelector('.lottery-block').classList.add('hide'); // 隱藏原有內容
    document.querySelector('.prize-result').classList.remove('hide'); // 出現結果
    document.querySelector('.lottery').classList.add(classname); // 替換背景圖片
    document.querySelector('.prize-result__title').innerText = title; // 替換中獎文字
  });
});
