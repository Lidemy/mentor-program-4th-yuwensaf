/* eslint-disable no-undef */
/* eslint-disable no-continue */
/* eslint-disable no-restricted-syntax */
/* eslint-disable max-len */
document.querySelector('.register-form').addEventListener('submit', (e) => {
  const elements = document.querySelectorAll('.required-block');
  let hasError = false; // 記錄整個表單上是否有任何的 error-text （true: 有 error-text，不能送出表單）（false: 沒有任何的 error-text，可以送出表單了）
  const values = {}; // 儲存 user 所填寫的內容
  for (element of elements) {
    const input = element.querySelector('input.input-box');
    const radios = element.querySelectorAll('input[type=radio]');
    let isValid = true; // 記錄該欄位的填寫狀態 （true: 有填寫）（false: 沒有填寫）

    if (input) { // 如果有找到 input 欄位
      if (!input.value) { // 如果該欄位沒有填寫
        isValid = false;
      } else { // 如果該欄位有填寫
        values[input.name] = input.value; // 把那個 input 的值放進去 values 物件
      }
    } else if (radios.length) { // 如果有找到 radios
      isValid = [...radios].some(radio => radio.checked);
      if (isValid) {
        const r = document.querySelector('input[type=radio]:checked'); // 選出「被勾選的那個 radio」
        values[r.name] = r.value; // 把那個 radio 的值放進去 values 物件
      }
    } else { // 如果沒有找到 input，也沒有找到 radios，就跳到下一個 element
      continue;
    }

    if (!isValid) { // 如果該欄位沒有填寫
      element.classList.remove('hide-error-text'); // 就顯示出 error-text
      e.preventDefault(); // 阻止表單送出
      hasError = true;
    } else { // 如果該欄位有填寫
      element.classList.add('hide-error-text'); // 就隱藏 error-text
    }
  }
  if (!hasError) { // 如果「表單上沒有任何的 error-text」，就用 alert 顯示出 user 填寫的資料
    const data = JSON.stringify(values); // 先把 values 物件轉成 JSON 格式的字串
    alert(data);
  }
});
