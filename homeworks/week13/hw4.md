## Webpack 是做什麼用的？可以不用它嗎？
因為瀏覽器原生沒有支援 `require()` 語法，所以要引入 module（資源）很不方便。webpack 幫我們「在瀏覽器上實作了 `require()` 的功能」，然後再把 module 包在一起，讓我們在瀏覽器上也可以用 `require()` 的語法來使用模組。

webpack 把「module」的概念擴充到不只是 JS 的模組，還包括圖片、CSS 檔案、聲音等資源，都可以當作 module（資源）打包在一起。

如果不用 webpack 的話，在瀏覽器上就無法使用 `require()` 的語法，並且在使用 ES6 的 `import`, `export` 時，必須要在 script 標籤加上 `type="module"`，這樣瀏覽器才看得懂。
```htmlmixed
<script src="./index.js" type="module"></script>
```

## gulp 跟 webpack 有什麼不一樣？
### gulp 的產品定位是「task manager」，task 的內容可以非常多元（基本上可以做到任何事情）
gulp 裡面有很多任務，我可以自己決定「每一個 task 的內容要是什麼」，基本上，只要我能夠寫出這個 task，gulp 就什麼事情都可以做到。例如：
* 校正時間
* 抓取某一個網站的圖片
* 定時 call API
* 用 babel 轉換程式碼
* 把 scss 編譯成 css

:x: 「gulp 本身」做不到的事情是：bundle
但是，gulp 可以透過 webpack-plugin 去打包
### webpack 的定位則是「bundler」
我有很多資源（例如 .js, .scss, img），webpack 可以幫我把這些資源都 bundle 在一起

在 bundle 之前，需要透過 loader 把 .js, .scss, img 檔案載入進去 webpack ，webpack 再把這些檔案包起來

#### 在 loader 載入檔案時，就可以順便做一些「資源的轉換」（這就是為什麼會跟 gulp 很像的原因）
例如：
* babel loader -> 可以把 .js 檔案先經過 babel 轉換之後，再載入進去 webpack
* scss loader -> 可以把 .scss 檔案先編譯成 css 之後，再載入進去 webpack

:x: webpack 做不到的事情，例如：校正時間、定時 call API
:heavy_check_mark: webpack 主要的功能就是 bundle

## CSS Selector 權重的計算方式為何？
#### :star: 原則一：越詳細的贏
```
!important > inline style > id > class > 標籤
```
![](https://i.imgur.com/mjhoAwc.jpg)

* inline style 是 1, 0, 0, 0
* `!important` 是 1, 0, 0, 0, 0

舉例：
樣式 A 用了「一個 id、三個 class」就是 1, 3, 0
樣式 B 用了「15 個 class」就是 0, 15, 0

樣式 A 永遠都會蓋過樣式 B （不會逢十就進位）
#### :star: 原則二：當「權重完全一樣」時，「後面的樣式」就會蓋掉「前面的樣式」
