## 什麼是 Ajax？

「用 JavaScript 發送 request 去跟 server 交換資料」的方式，統稱就叫做 AJAX，全名是 Asynchronous JavaScript And XML
（asynchronous 的意思是：非同步；不同時存在；不同時發生的）

ajax 不是單指某一個技術，只要是任何「非同步跟 server 交換資料的 JavaScript」，都可以叫做 ajax

ajax 名字裡面會有 XML 是因為：早期都用 XML 來做為資料格式，但是現在其實大多都用 JSON 做為資料格式了

## 用 Ajax 與我們用表單送出資料的差別在哪？

用 ajax 跟 form 來交換資料，在發送 request 的部分是一樣的：
```
在瀏覽器上的 JS 會透過瀏覽器，瀏覽器再叫作業系統發送 request 到 server
```
#### 但是，在回傳 response 時，就會不同了

* 用 form 來交換資料（顯示出的 response 會換頁）：
```
server 會把 response 回傳給瀏覽器，瀏覽器就會把 response 給 render 出來（換新的頁面）
```
* 用 ajax 來交換資料（顯示出的 response 不會換頁）：
```
server 把 response 回傳給瀏覽器後，瀏覽器會把 response 轉傳給「瀏覽器上的 JavaScript」
```

## JSONP 是什麼？

JSONP 是「從網頁前端去跟後端交換資料的其中一種方式」（現在很少用了）

JSONP 的全名是 JSON with padding，padding 在這裡是「填充」的意思

為了方便性，有些標籤不會受到同源政策的限制，因為這些標籤並不會有安全性的疑慮，例如：
* `<img src="" alt="">`，就算是跨來源的圖片，我也可以載入（因為圖片沒有安全性的問題）
* `<script src="https://"></script>`，我可以引入其他 domain 的 JavaScript

#### 利用「`<script>` 不受同源規範所限制」的特性來拿到資料
例如：
假設，現在我想要拿到一些 user 的資料

#### 首先，在 html 檔案內，先在 script 載入一個 js 檔案叫做 user.js
index.html:
```htmlmixed
<script src="https://test.com/user.js"></script>
```
#### 在 user.js 這個檔案裡面會執行一個 function，在 function 所傳入的參數就是要回傳的 user 資料
user.js:
```javascript
// 在 user.js 裡面

setData([
  {
    id: 1,
    username: 'Harry'
  },
  {
    id: 2,
    username: 'Peter'
  }
])
```
#### 因此，我只要在我本地的 js 裡面先宣告好一個 `setData` function，等到 `<script src="https://test.com/user.js"></script>` 把 user.js 檔案載入完成後，user.js 就會去執行 `setData` function，用 console.log 印出參數來拿到這些 user 的資料（參數就是我想要拿到的 user 資料）
all.js:
```javascript
      function setData(users){
        console.log(users)
      }
```

這個 `<script src="https://test.com/user.js"></script>` 標籤也可以用 JS 動態產生，並且帶入參數，例如下方的 `?id=1`
all.js:
```javascript
      const element = document.createElement('script')
      element.src = 'https://test.com/user.js?id=1'
```
然後 server 端就可以依照 `src` 裡面的參數 `?id=1`，來決定要回傳下面這些資料給 client 端：
```
setData([
  {
    id: 1,
    username: 'Harry'
  }
])
```
因此，此方法會叫做 JSONP 就是因為：
server 端會依照 client 端所指定的參數（`element.src = 'https://test.com/user.js?id=1'`）把 client 想要拿的資料（這個 JS 物件 `{id: 1, username: 'Harry'}`） 給填充進去 `setData()` 裡面，在 client 端就可以利用「執行 `setData` function」來拿到這個資料

## 要如何存取跨網域的 API？

#### 瀏覽器有另一個政策叫做 Cross-Origin Resource Sharing (CORS)，中文翻作「跨來源資源共用」
如果這個 API 願意開放讓某些人「跨來源」去存取這個 API 的資料的話，這個 API 就必須在 response Header 裡面加上 ‘Access-Control-Allow-Origin’ 這一項

在 ‘Access-Control-Allow-Origin’ 的內容裡面就會清楚地列出：哪些來源（Origin），可以存取這個 API 的 response

這個「來源」就是指：瀏覽器在幫我發送 request 時，會在 request header 加上一個欄位叫做 Origin，會填入「我目前所在的網頁的 domain name」
server 就可以根據這個 origin，來決定是否要給這個 origin 存取 response 的權限

例如：
`*` 就代表「所有的 origin」都可以存取這個 response
```
Access-Control-Allow-Origin: *
```
#### 想要向一個「不同源」的網站存取 response，除非對方的 server 有加上 ‘Access-Control-Allow-Origin’ 這項，否則是絕對無法存取到對方的 response 的！

## 為什麼我們在第四週時沒碰到跨網域的問題，這週（觀看 JS102 影片的時候）卻碰到了？

因為在第四週時，我們是使用 Node.js 發送 request（發出去的 request 和接收到的 response 都不會有瀏覽器在中間幫我們處理）

而在這週（JS 102 影片），我們是使用瀏覽器上的 JS 發送 request

這些跨網域的問題（同源政策、CORS）都只跟瀏覽器有關
因此，假如脫離了瀏覽器，直接用 Node.js 發送 request，就完全不會有「同源政策、CORS」這些限制了
也就是說，就算是不同源的網站，我用 Node.js 發送 request 也還是可以存取到 response

#### 會有「同源政策、CORS」其實都是為了安全性
在瀏覽器上的很多限制，都是為了安全性的考量，例如：
用瀏覽器無法隨意去讀取電腦上的檔案，因為怕你會用瀏覽器去偷檔案裡的資料傳到 server 去
