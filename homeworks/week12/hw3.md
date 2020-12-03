## 請簡單解釋什麼是 Single Page Application
與 Single Page Application 相對應的就是 Multiple Page Application
* Multiple Page Application：使用者造訪不同頁面，server 就會回傳不同的 HTML 檔案給瀏覽器 render，每份 HTML 檔案都已經完整包含了資料和畫面
* Single Page Application：使用者造訪不同頁面，都是利用 ajax 發送 request 到後端拿資料（不同頁面就發送到不同的後端 API），後端的資料永遠都是回傳到同一個 HTML 檔案，在 client side 再透過 JavaScript 把回傳的資料渲染成畫面

## SPA 的優缺點為何
> 參考資料：
> * [前端三十｜18. [FE] 為什麼網站要做成 SPA？SSR 的優點是什麼？](https://medium.com/schaoss-blog/前端三十-18-fe-為什麼網站要做成-spa-ssr-的優點是什麼-c926145078a4)
> * [跟著小明一起搞懂技術名詞：MVC、SPA 與 SSR](https://hulitw.medium.com/introduction-mvc-spa-and-ssr-545c941669e9)
> * [前後端分離與 SPA](https://blog.techbridge.cc/2017/09/16/frontend-backend-mvc/)
### SPA 的優點
* 做任何操作都不需要換頁，使用者體驗很流暢
* server 不再需要處理畫面的渲染（只需要提供資料），大幅降低 server 的運算和流量負荷

### SPA 的缺點
* 網頁的第一個畫面，要等前端載入大量 JavaScript，經過計算、渲染之後才會出現畫面，造成第一個畫面需要較長的載入時間
* 因為 server 僅提供一個幾乎是空的 HTML 檔案（只有一些基本的 tag 和用來載入 JS 的 script），其他內容都是由 JS 動態產生上去的，這些 JS 動態產生的內容並不會出現在網頁原始碼中，許多瀏覽器爬到的就只會是一個空蕩蕩的 HTML，這樣讓 SEO 非常差

## 這週這種後端負責提供只輸出資料的 API，前端一律都用 Ajax 串接的寫法，跟之前透過 PHP 直接輸出內容的留言板有什麼不同？
「透過 PHP 直接輸出內容」 vs 「用 PHP 開發出 API」

雖然兩者最後都能產生網頁內容，但是對瀏覽器來說是不一樣的
### 透過 PHP 直接輸出內容
流程如下：
1. 把資料拿出來
2. 在後端把資料跟 HTML（也就是 UI）結合在一起
3. 回傳 HTML （資料+UI）給瀏覽器

對瀏覽器來說：一拿到 response 就可以看到「資料+UI」，瀏覽器可以直接看到整個網頁內容，因此又稱為「server-side render」。
### 用 PHP 開發出 API
流程如下：
1. 把資料拿出來
2. 把資料變成某種格式（JSON）
3. 回傳資料

後端 API 回傳的就只有資料，不會有任何跟 UI 有關的東西。
API 回傳資料後，透過前端去串接 API 拿到資料，再透過 JS 去拿資料並且動態 render 出 HTML 元素。

因此，對瀏覽器來說：拿到的 response （HTML） 會是空的，必須要等到載入 HTML -> 執行 JS 檔案後，JS 去後端拿資料並且動態 render 出網頁內容。
