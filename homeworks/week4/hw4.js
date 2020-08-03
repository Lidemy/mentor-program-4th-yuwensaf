/* eslint-disable no-plusplus */
/* eslint-disable quote-props */
/* eslint-disable camelcase */
/* eslint-disable consistent-return */
/* eslint-disable prefer-template */
const request = require('request');

const baseUrl = 'https://api.twitch.tv/kraken';
const Client_ID = 'ovn0u5ph1z8z2gngt8si4nogad7znx';

const options = {
  url: `${baseUrl}/games/top`,
  headers: {
    'Accept': 'application/vnd.twitchtv.v5+json',
    'Client-ID': Client_ID,
  },
};

const callback = (error, response, body) => {
  if (error) {
    return console.log('抓取失敗', error);
  }
  const obj = JSON.parse(body);
  const data = obj.top;
  for (let i = 0; i < data.length; i++) {
    console.log(data[i].viewers + ' ' + data[i].game.name);
  }
};

request(options, callback);
