/* eslint-disable prefer-template */
/* eslint-disable prefer-arrow-callback */
/* eslint-disable no-restricted-syntax */
/* eslint-disable no-use-before-define */
/* eslint-disable no-shadow */
const getGamesApiUrl = 'https://api.twitch.tv/kraken/games/top';
const getStreamsApiUrl = 'https://api.twitch.tv/kraken/streams/';
const CLIENT_ID = 'ovn0u5ph1z8z2gngt8si4nogad7znx';
const STREAM_TEMPLATE = `
        <li class="streams-list__item">
          <div class="stream-banner" style="background-image: url($banner)"></div>
          <div class="stream-info">
            <div class="stream-info__logo" style="background-image: url($logo)"></div>
            <div class="stream-info__content">
              <div class="description">$description</div>
              <div class="name">$name</div>
            </div>
          </div>
        </li>`;


// 負責去 api 拿資料（抓取前 5 名的遊戲名稱）
function getGames(cb) {
  const request = new XMLHttpRequest();
  request.onload = () => {
    if (request.status >= 200 && request.status < 400) {
      const games = JSON.parse(request.responseText).top;

      cb(games);
    } else {
      console.log('Error!');
    }
  };

  request.onerror = () => {
    console.log('Error!');
  };

  request.open('GET', getGamesApiUrl + '?limit=5', true);

  request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
  request.setRequestHeader('Client-ID', CLIENT_ID);

  request.send();
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
  // 當重新整理頁面時，就顯示第一個遊戲的實況
  changeGame(games[0].game.name);
});

// 負責顯示畫面（前 20 個實況）
// 當我點擊其中一個遊戲時
const navbar = document.querySelector('.games-list');
navbar.addEventListener('click', (e) => {
  if (e.target.tagName.toLowerCase() === 'li') {
    const thisGame = e.target.innerText;

    changeGame(thisGame);
  }
});

function changeGame(thisGame) {
  document.querySelector('.game-block__title').innerText = thisGame; // 替換遊戲標題
  document.querySelector('.streams-list').innerHTML = ''; // 先清空畫面
  getStreams(thisGame, cbStream);
}

// 負責去 api 拿資料（前 20 個實況）
function getStreams(thisGame, cbStream) {
  const request = new XMLHttpRequest();
  request.onload = () => {
    if (request.status >= 200 && request.status < 400) {
      const streamData = JSON.parse(request.responseText).streams;

      cbStream(streamData);
    } else {
      console.log('Error!');
    }
  };

  request.onerror = () => {
    console.log('Error!');
  };

  request.open('GET', getStreamsApiUrl + `?game=${thisGame}&limit=20`, true);

  request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
  request.setRequestHeader('Client-ID', CLIENT_ID);

  request.send();
}

function cbStream(streamData) {
  for (const stream of streamData) {
    const li = document.createElement('li');
    document.querySelector('.streams-list').appendChild(li);

    li.outerHTML = STREAM_TEMPLATE
      .replace('$banner', stream.channel.video_banner)
      .replace('$logo', stream.channel.logo)
      .replace('$description', stream.channel.description)
      .replace('$name', stream.channel.name);
  }
}
