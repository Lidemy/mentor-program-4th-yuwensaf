/* eslint-disable no-plusplus */
/* eslint-disable quote-props */
const request = require('request');

const options = {
  url: 'https://api.twitch.tv/kraken/games/top',
  headers: {
    'Accept': 'application/vnd.twitchtv.v5+json',
    'Client-ID': 'ovn0u5ph1z8z2gngt8si4nogad7znx',
  },
};

const callback = (error, response, body) => {
  let obj;
  try {
    obj = JSON.parse(body);
  } catch (err) {
    console.log(err);
  }

  const data = obj.top;
  for (let i = 0; i < data.length; i++) {
    console.log(data[i].viewers, data[i].game.name);
  }
};

request(options, callback);
