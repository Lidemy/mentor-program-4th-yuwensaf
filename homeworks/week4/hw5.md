## 請以自己的話解釋 API 是什麼


會需要使用 API 就是為了要交換資料，有可能是「我提供資料給別人」或是「我需要拿取對方的資料」

使用 API 的其中一個好處就是：資料提供者不需要把整個資料庫都開放，可以在 API 設定好要開放哪些資料讓別人取用

API 有分為好幾種，例如：
* 透過作業系統提供的 File API，我可以操控檔案
* 透過網頁傳遞資料的就叫做 Web API

API 的網址會由兩個部分組成：
* 第一個部分是 Base URL，例如 https://api.twitch.tv/kraken
* 第二個部分是「不同的 path」，例如 /videos/top
API 會提供很多不同的資源，例如「取得頻道有多少個粉絲、取得擁有最多觀看數的影片」等等，就會用不同的 path 去區分

`Base URL + path` 才會是 API 的完整網址，例如 https://api.twitch.tv/kraken/videos/top 就是「Get Top Videos」的 API 網址

## 請找出三個課程沒教的 HTTP status code 並簡單介紹


#### 100 (Continue) 繼續
收到 100 代表：Server 已接受請求的初始部分，並期待收到更多資料。

通常會用在 Client 要上傳大型檔案時，就會在 request Headers 加上一個欄位是：
```
Expect: 100-continue
```
Server 接收到此訊息後，如果同意此 Client 上傳資料，便可回傳 100(Continue)，Client 就應該要繼續上傳資料，讓 Server 進行完整的處理。

但如果 Server 不同意此 Client 上傳資料，就可以直接回應 401(Unauthorized) 或是 405(Method Not Allowed)。

這樣，Client 就可以提早知道自己是否可以繼續上傳資料，提高錯誤處理的效率。

#### 401 (Unauthorized) 未授權
收到 401 代表：request 未被採用，因為沒有提供有效的驗證憑證，或是因憑證過期而被拒絕，需要再重新驗證。

在回傳 401 的 response 裡面，Server 也會生成一個 response Headers 的欄位是 WWW-Authenticate，來告訴 Client 要怎麼進行身份驗證，瀏覽器收到 response 後就會根據 WWW-Authenticate 所寫的方式去進行驗證。

#### 429 (Too Many Requests)
這是一個非官方的 HTTP Status Code

Twitter API 在短期內送出太多 request 時就會回傳 429

> 參考資料 1 [HTTP 狀態碼 (Status Codes)](https://notfalse.net/48/http-status-codes)
> 參考資料 2 [常見與不常見的 HTTP Status Code](https://noob.tw/http-status-code/)

## 假設你現在是個餐廳平台，需要提供 API 給別人串接並提供基本的 CRUD 功能，包括：回傳所有餐廳資料、回傳單一餐廳資料、刪除餐廳、新增餐廳、更改餐廳，你的 API 會長什麼樣子？請提供一份 API 文件。


Base URL: https://eatup-restaurants.com

| 說明 | Method | path | 參數 | 參數傳送方式 | 範例 |
| --- | --- | --- | --- | --- | --- |
|回傳所有餐廳資料|GET|/destinations|limit（限制回傳資料數量，預設為 10 筆，最多 100 筆）|Query-string parameter|/destinations?limit=30|
|回傳單一餐廳資料|GET|/destinations/:id|-|-|/destinations/7|
|刪除餐廳|DELETE|/destinations/:id|-|-|/destinations/7|
|新增餐廳|POST|/destinations|name: 餐廳名稱, location: 餐廳地點, category: 分類|Request header|-|
|更改餐廳|PATCH|/destinations/:id|name: 餐廳名稱, location: 餐廳地點, category: 分類|Request header|/destinations/7|



