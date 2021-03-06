/* eslint-disable prefer-template */
/* eslint-disable prefer-arrow-callback */
/* eslint-disable no-restricted-syntax */
/* eslint-disable no-use-before-define */
/* eslint-disable no-shadow */
/* eslint-disable comma-dangle */
/* eslint-disable arrow-parens */
/* eslint-disable arrow-body-style */
/* eslint-disable function-paren-newline */
const getGamesApiUrl = 'https://api.twitch.tv/kraken/games/top';
const getStreamsApiUrl = 'https://api.twitch.tv/kraken/streams/';
const CLIENT_ID = 'ovn0u5ph1z8z2gngt8si4nogad7znx';
const STREAM_TEMPLATE = `
        <li class="streams-list__item">
          <div class="stream-image" style="background-image: url($preview)"></div>
          <div class="stream-info">
            <div class="stream-info__logo" style="background-image: url($logo)"></div>
            <div class="stream-info__content">
              <div class="status">$status</div>
              <div class="name">$name</div>
            </div>
          </div>
        </li>`;


// 負責去 api 拿資料（抓取前 5 名的遊戲名稱）：用 fetch
function getGames(cb) {
  fetch(
    getGamesApiUrl + '?limit=5', {
      method: 'GET',
      headers: {
        Accept: 'application/vnd.twitchtv.v5+json',
        'Client-ID': CLIENT_ID
      }
    }).then(response => {
    return response.json();
  }).then(json => {
    cb(json.top); // 把結果傳回去
  })
    .catch(err => {
      console.log('Error: ', err);
    });
}

// 負責顯示畫面（前 5 名的遊戲名稱）
getGames(function (games) {
  // 先在上方顯示出前 5 名的遊戲名稱
  for (const game of games) {
    const li = document.createElement('li');
    li.classList.add('games-list__item');
    li.innerText = game.game.name;
    document.querySelector('.games-list').appendChild(li);
  }
  // 當重新整理頁面時，就顯示第一個遊戲的名稱和實況
  changeGame(games[0].game.name);
});

// 負責顯示畫面（前 20 個實況）
// 當我點擊 navbar 的其中一個遊戲時
const navbar = document.querySelector('.games-list');
navbar.addEventListener('click', (e) => {
  if (e.target.tagName.toLowerCase() === 'li') {
    const thisGame = e.target.innerText;

    changeGame(thisGame);
  }
});

function changeGame(thisGame) {
  document.querySelector('.streams-block__title').innerText = thisGame; // 替換遊戲標題
  document.querySelector('.streams-list').innerHTML = ''; // 先清空所有的實況
  getStreams(thisGame, cbStream);
}

// 負責去 api 拿資料（前 20 個實況）：用 fetch
function getStreams(thisGame, cbStream) {
  fetch(
    getStreamsApiUrl + `?game=${encodeURIComponent(thisGame)}&limit=20`, {
      method: 'GET',
      headers: {
        Accept: 'application/vnd.twitchtv.v5+json',
        'Client-ID': CLIENT_ID
      }
    }
  ).then(response => {
    return response.json();
  }).then(json => {
    cbStream(json.streams); // 把結果傳回去
  })
    .catch(err => {
      console.log('Error: ', err);
    });
}

// 負責處理畫面（把拿到的資料渲染成畫面）
function cbStream(streamData) {
  for (const stream of streamData) {
    const li = document.createElement('li');
    document.querySelector('.streams-list').appendChild(li);

    li.outerHTML = STREAM_TEMPLATE
      .replace('$preview', stream.preview.large)
      .replace('$logo', stream.channel.logo)
      .replace('$status', stream.channel.status)
      .replace('$name', stream.channel.name);
  }
}
