## 請解釋後端與前端的差異。


![](https://i.imgur.com/AKQUn5F.jpg)

綠線左側是「我看得到的頁面」--> 就是屬於「Front End」
綠線右側是「我看不到的，server 在處理的部分」--> 就是屬於「Back End」
## 前端
再把前端的「瀏覽器」拉出來看，瀏覽器可以分成這三個部分：

* 網頁的內容就是 html
* 負責裝飾的就是 css（排版、背景顏色、字體大小...）
    * 在 Firefox 選單點擊「檢視/頁面樣式/無樣式」就可以把 css 關掉，網頁就會用「純文字」顯示出來
![](https://i.imgur.com/e8Bo1RD.jpg)
* 負責網頁功能（頁面互動、資料溝通）的是 JavaScript
    * 在網頁上寫的程式，一定都是 JavaScript

## 後端

以「Google 表單」的範例來說，我們要把 request 發送到 docs.google.com 這個網址去，但是，網路只認「IP 位置」
（docs.google.com 是“域名”）

因此，在發送 request 之前，

1. 瀏覽器（網路卡）要先去問「DNS server」，問說「docs.google.com 的 IP 位置是什麼？」
2. DNS server 就會回答說：「docs.google.com 的 IP 位置是 216.58.200.46」
3. 網路卡就會把 request 發送到 216.58.200.46 這個 IP 位置的 server 去

### 後端的程式語言

負責處理從「Google server」之後的事情，就是後端負責的：
可以使用不同的程式語言，有 PHP, Ruby 等等

### 後端的系統架構
Database 都不會只有一台，

如果 Database 只有一台的話，這台掛掉，整個服務就掛掉了，

因此，會把資料都複寫到另一台 Database，一台掛了，就可以連到另一台，服務就不會中斷掉。



## 假設我今天去 Google 首頁搜尋框打上：JavaScript 並且按下 Enter，請說出從這一刻開始到我看到搜尋結果為止發生在背後的事情。


1. 我在 Google 搜尋框按下 Enter 後，瀏覽器要送出關鍵字「JavaScript」到 google.com
2. 瀏覽器會先去檢查自己的 dns cache 有沒有存 google.com 的 IP 位置
3. 有的話就直接發送 request 到那個 IP 位置
4. 沒有的話就呼叫 C 語言提供的 function（例如 `gethostbyname`）
5. C 語言會呼叫作業系統
6. 作業系統會去檢查自己的 dns cache 有沒有存 google.com 的 IP 位置
7. 有的話就直接回傳 IP 位置
8. 沒有的話，就去 Google 的 DNS server（IP 位置是 8.8.8.8）問說 google.com 的 IP 位置是哪裡
9. Google 的 DNS server 回傳 172.217.160.78
10. 瀏覽器發送 request 到 172.217.160.78
11. Google server 收到 request 後，去 database 查詢關鍵字，並取得搜尋結果
12. Google server 將搜尋結果回傳一個 response 給瀏覽器
13. 瀏覽器將 response 解析後顯示在畫面上，就是我所看到的搜尋結果了



## 請列舉出 3 個「課程沒有提到」的 command line 指令並且說明功用


網路上查到的好用指令，幾乎在課程中都有教了。下面列出幾個好不容易找到的（課程沒有特別提到，也覺得應該算實用）

## 讀取檔案
### `less <fileName>`
使用 `cat <fileName>` 可以將檔案內容輸出在 CLI 介面上，
但是如果是使用 `less <fileName>` 就可以使用分頁的方式來顯示檔案內容
### `open -a [appToOpen] [fileName]`
可以使用 `open <fileName>` 來開啟檔案，
如果是 `open -a [appToOpen] [fileName]` 就可以指定特定的應用程式來開啟檔案

## 找檔案
### 尋找空檔案
```zsh
find . -empty
```
### 尋找名稱後綴為 .del 的資料夾
```zsh
find . -iname '*.del' -type d
```

* `-type d` 代表：type 是 directory

### 尋找名稱後綴為 .js 的檔案
```zsh
find . -iname '*.js' -type f
```

* `-type f` 代表：type 是 file

## 使用 `&&` 可以一次執行兩個指令
例如：
切換到「test 資料夾」，並且印出 code.js 的檔案內容

```zsh
cd /Users/saffran/Desktop/test && cat code.js
```

> 參考資料：[[指令] Command Line 操作, cmd, cli, bash](https://pjchender.github.io/2017/09/26/指令-command-line-操作-cmd-cli-bash/)




