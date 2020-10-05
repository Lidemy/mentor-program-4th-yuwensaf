## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼


（因為教學影片說要了解 VARCHAR 就要先了解 CHAR，所以就把 CHAR 的介紹也一起寫進來）

> 資料來源 1 [CHAR Data Type](https://youtu.be/sc1E73QX0Xc)
> 資料來源 2 [VARCHAR Data Type](https://youtu.be/GquwVjgnKDc)
> 資料來源 3 [TEXT, TINYTEXT, MEDIUMTEXT, LONGTEXT](https://youtu.be/qhFkXAWl9s4)


編碼會使用 UTF8 是因為：可以支援多種語言

CHAR、VARCHAR、TEXT 都是「string」的資料型別

以下是個別的介紹與比較：
## CHAR
#### 資料型別如果使用 CHAR：該欄位的每個值都要是一個「固定長度的 string」
CHAR(30) 代表：長度是 30 個 characters 的字串

如果我的字串是「hello」，只有用到 5 個 characters，MySQL 會在後面自動加上 25 個空白來補滿 30 個 characters，所以在欄位裡的資料就會是：
```
'hello                 '
```

但是，當我使用 `SELECT` 語法把資料撈出來時，MySQL 會自動把空白去掉，所以我拿到的資料會是：
```
'hello'
```

MySQL mode 有很多種模式，如果我去把其中一個模式叫做 PAD_CHAR_TO_FULL_LENGTH 給打開，這樣當我使用 `SELECT` 語法把資料撈出來時，MySQL 就不會把空白去掉了，所以我拿到的資料就會是「有 25 個空白的字串」：
```
'hello                 '
```
### CHAR 使用時機
#### :star: 當我很確定此欄位的字串長度，例如都會是 30 個字元時，使用 CHAR(30) 就是最節省空間的，因為 MySQL 不需要特別去記錄每筆資料的字串長度（就都是 30 個字元）

如果是使用 VARCHAR，MySQL 就要特別去記錄每筆資料的字串長度（因此每個字串都會佔用較多空間）
#### :star: 當我使用了 CHAR(30)，但是此欄位的資料長度不是固定的，例如這筆資料只有 5 個字元，那就會浪費了 25 個字元的空間
### CHAR 允許的長度
#### CHAR 的長度是限定在 0 ~ 255 個字元
0 個字元就是：8 bit 能放入的最少字元 （可以是 `null`、空字串 `''`）
255 個字元就是：8 bit 能放入的最多字元
```
十進位的 0 就是：二進位的 00000000
十進位的 255 就是：二進位的 11111111
```
## VARCHAR
VARCHAR 跟 CHAR 的差別是：
VARCHAR 不會用空白去補字串長度
### 但是！使用 VARCHAR 的缺點是：因為每個字串長度都不同，所以 MySQL 會需要額外的空間去記錄每個字串的長度
* 如果字串長度 <= 255 個字元，MySQL 會需要 1 byte 來記錄字串長度
* 如果字串長度 > 255 個字元，MySQL 會需要 2 bytes 來記錄字串長度

在 UTF8 的編碼中，一個英文字母所佔的空間是 1 byte
其他語言（例如中文字），因為筆畫較多，一個字元在 MySQL 最多會佔 3 bytes 的空間

如果我的資料型別使用的是 VARCHAR(50)

當有一個字串 `'hello'`，所佔的空間就是 5 bytes + 1 byte
### VARCHAR 的字串長度限制
VARCHAR 可以放入字串的最大空間是：65535 bytes
而 MySQL 的 row limit 也剛好是 65535 bytes
（row limit 就是：每個 row 可以存東西的最大空間）

65535 bytes 換算成字串長度就是 21,843 個字元：
```
65535 bytes / 3 - 2 bytes = 21843
```
* 「除以 3」是因為：一個字元在 MySQL 最多會佔 3 bytes 的空間
* 「減掉 2 bytes」是因為：MySQL 最多會需要 2 bytes 來記錄字串長度

因此，保險起見，VARCHAR 的字串長度不要超過 20,000 個字元
## TEXT
如果是用 VARCHAR，只要是 65535 bytes 以內的字串，我都可以存

但如果是用 TEXT，會根據不同的 size 又區分為四種型別：
```
TINYTEXT: 最多可以存 255 characters = 255 Bytes
TEXT: 最多可以存 65,535 characters = 64 KB
MEDIUMTEXT: 最多可以存 16,777,215 characters = 16 MB
LONGTEXT: 最多可以存 4,294,967,295 characters = 4 GB
```

> 參考資料 [Understanding Storage Sizes for MySQL TEXT Data Types](https://chartio.com/resources/tutorials/understanding-strorage-sizes-for-mysql-text-data-types/)
### VARCHAR 和 TEXT 的差別主要有三個
#### 差別一：VARCHAR 可以設長度，但是 TEXT 不行設長度（這是最重要的差別）
* 如果本來就知道大概會需要多少字元，就用 VARCHAR （才能節省空間）
* 真的逼不得已東西很長（例如說要存文章）的時候才用 TEXT
#### 差別二：MySQL 的 row limit
* VARCHAR 會受到 MySQL 的 row limit 所限制（最大就是 65535 bytes）
* TEXT 不受到 MySQL 的 row limit 所限制

原因為：
VARCHAR 是直接存在 table 裡面，所以會受到 row limit 的限制

但是 MySQL 會把 TEXT 存放在別的地方（不是直接存在 table 裡面），再用「reference」的方式去引入這個 TEXT
（無論存了多大的 TEXT，在 table 本身最多只會用到 12 bytes 而已）

![](https://i.imgur.com/eVoLMpG.jpg)

因此，TEXT 可以比 VARCHAR 存更多的字元在欄位中

TEXT 這種資料型別也被稱為 CLOB（Character Large Object）
#### 差別三：default value
* VARCHAR 的 default value 可以是任何的值（包括 `null` 或是其他任何的值）
* TEXT 的 default value 只能是 `null`

## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又是怎麼把 Cookie 帶去 Server 的？


Cookie 是個儲存在瀏覽器的小型文字檔案

Cookie 可以經由 server 來設定，設定方式如下：
![](https://i.imgur.com/cvG0vPr.jpg)
### 要從 server 設置 Cookie 的話，要用 `Set-Cookie` 來設置
#### `Set-Cookie` 是 HTTP 的 response Header
server 可以傳一個 response Header 叫做 `Set-Cookie: user_id=1`，透過這個 response Header 來叫瀏覽器設置這個 Cookie （只能設置自己 Domain 底下的 Cookie）

瀏覽器收到 `Set-Cookie: user_id=1` 這個 response Header 後，自己就會把 `user_id=1` 這個 Cookie 存在瀏覽器裡面

（只有瀏覽器會自動存取 Cookie。如果是自己寫的一些網路爬蟲程式，沒有瀏覽器的話基本上就不會有 Cookie 這個東西）

![](https://i.imgur.com/JhOa0sL.jpg)

當我之後再次訪問相同的頁面時，瀏覽器會自動在 Request Headers 加上一個欄位是 `Cookie: user_id=1`（幫我把 Cookie 帶上來，一起送到 server 去），server 就會知道我是誰了
:heavy_exclamation_mark: 注意，瀏覽器只會把「符合條件」的 Cookie 帶上來，符合條件是指：
1. 沒有過期
2. Domain 和 Path 都要符合

## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？

1. 在資料庫裡面的密碼存的是明碼，如果資料庫被駭客竊取，所有會員的密碼就都被駭客知道了
2. 在會員連線到 server 後（已取得 session id），有可能會在連線的過程中被駭客竊聽來獲取會員的 session id，駭客就可以用偷來的 session id 來偽造成會員身份
