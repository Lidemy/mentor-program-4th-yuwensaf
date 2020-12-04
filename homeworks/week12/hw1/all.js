/* eslint-disable no-undef */
/* eslint-disable no-restricted-syntax */
/* eslint-disable arrow-parens */
/* eslint-disable no-shadow */
/* eslint-disable no-use-before-define */
/* eslint-disable quotes */
/* eslint-disable no-useless-escape */

$(document).ready(() => {
  // 用 escape 修正 XSS 問題
  function escape(toOutput) {
    return toOutput.replace(/\&/g, '&amp;')
      .replace(/\</g, '&lt;')
      .replace(/\>/g, '&gt;')
      .replace(/\"/g, '&quot;')
      .replace(/\'/g, '&#x27')
      .replace(/\//g, '&#x2F');
  }

  // 把留言插入到 DOM 裡面
  function appendCommentToDOM(container, comment, isPrepend) {
    const html = `
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">${escape(comment.nickname)}</h5>
          <p class="card-text">${escape(comment.content)}</p>
        </div>
      </div>
    `;

    // 決定是要 prepend 還是 append
    if (isPrepend) {
      container.prepend(html);
    } else {
      container.append(html);
    }
  }

  const loadMoreButtonHTML = `<button class="btn btn-warning btn-load-more">載入更多</button>`;
  const siteKey = 'saffran';
  let lastID = null;
  let isEnd = false;

  const commentDOM = $('.comments'); // 要放留言進去的容器
  getComments();

  // 點擊「載入更多」按鈕
  commentDOM.on('click', '.btn-load-more', () => {
    getComments();
  });

  // 串接「新增留言的 api」
  $('.add-comment-form').submit(e => {
    e.preventDefault(); // 先阻止表單送出
    const newCommentData = {
      site_key: 'saffran',
      nickname: $('input[name=nickname]').val(),
      content: $('textarea[name=content]').val(),
    };

    $.ajax({
      type: 'POST',
      // url: 'http://localhost:8080/saffran/week12-board_api/api_add_comments.php',
      url: 'http://mentor-program.co/mtr04group4/saffran/week12-comment-board/api_add_comments.php',
      data: newCommentData,
    }).done((data) => {
      // 如果沒有成功新增留言
      if (!data.ok) {
        alert(data.message);
        return;
      }

      // 如果有成功新增留言
      $('input[name=nickname]').val(''); // 清空欄位
      $('textarea[name=content]').val(''); // 清空欄位
      appendCommentToDOM(commentDOM, newCommentData, true); // 把剛剛新增的留言顯示在最上面
    });
  });

  // 串接「抓取留言的 api」（只負責拿資料，不處理畫面）
  function getCommentsAPI(siteKey, before, cb) {
    // let url = `http://localhost:8080/saffran/week12-board_api/api_comments.php?site_key=${siteKey}`;
    let url = `http://mentor-program.co/mtr04group4/saffran/week12-comment-board/api_comments.php?site_key=${siteKey}`;
    if (before) {
      url += `&before=${before}`;
    }

    $.ajax({
      url,
    }).done((data) => {
      if (!data.ok) {
        alert(data.message);
        return;
      }
      // 如果有成功串接 api，就把資料傳回去
      cb(data);
    });
  }

  // 顯示留言（先 call api，然後處理畫面）
  function getComments() {
    $('.btn-load-more').hide();
    if (isEnd) {
      return;
    }
    getCommentsAPI(siteKey, lastID, obj => {
      const comments = obj.discussions;
      for (const comment of comments) {
        appendCommentToDOM(commentDOM, comment, null);
      }

      if (comments.length === 0) {
        isEnd = true;
        $('.btn-load-more').hide();
      } else {
        lastID = comments[comments.length - 1].id;
        commentDOM.append(loadMoreButtonHTML); // 把「載入更多」按鈕 append 到最後面
      }
    });
  }
});
