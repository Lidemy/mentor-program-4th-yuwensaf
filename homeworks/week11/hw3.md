## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫

### 加密 vs 雜湊(hash)
加密跟雜湊的差別在於：
##### 加密可以解密，但雜湊無法還原

---

### 加密 Encryption （一對一關係）
```
明文 => 加密 => 密文
密文 => 解密 => 明文
```
加密 例如：
aaa 加密之後是 bbb
bbb 解密回去一定會是 aaa
```
aaa => 加密 => bbb
bbb => 解密 => aaa
```
因為 aaa 跟 bbb 是一對一的關係，所以可以還原（可以逆推回去）
##### 把密碼加密還是會有安全性的漏洞
原因為：
加密是一對一的，所以如果駭客知道了我使用哪種加密演算法，又拿到了 key，那他就可以解開我存在資料庫的密碼

因此，會使用另一個更安全的做法：雜湊
### 雜湊 Hash （多對一關係）
```
明文 => hash => 文字
```
hash 的意思是：肉末馬鈴薯泥

雜湊 例如：
```
aaa => hash => 8ukt5ew
ccc => hash => 8ukt5ew
```
aaa 經過 hash 之後永遠都會是 8ukt5ew
但除了 aaa 之外，其他字串經過 hash 之後也有可能是 8ukt5ew

這種「多對一的關係」就是雜湊無法還原的原因
#### 為什麼會是多對一的關係呢？
例如有個雜湊的演算法，
出來的結果都會是由「大小寫英文字母、數字」所組成的 7 位數

大小寫英文字母有 52 個 + 數字有 10 個（0 ~ 9） = 62

所以 hash 的結果會有 62^7 種組合，儘管這是一個很大的數字，但是還是「有限的」
而 hash 前的字串會有無限多種
##### 「無限多種字串」對應到「有限的結果」，所以會是多對一的關係

## `include`、`require`、`include_once`、`require_once` 的差別
### 參考資料
> [[PHP教學] - 初學者最易混淆的include、include_once、require、require_once之比較](https://injerry.pixnet.net/blog/post/39082306)
> [簡單談談PHP中的include、include_once、require以及require_once語句](https://codertw.com/程式語言/213553/)
> [深入理解require與require_once與include以及include_once的區別](https://codertw.com/程式語言/239900/)
### include()
include() 會將指定的檔案讀入，並執行檔案裡面的程式碼。
### include_once()
include_once() 和 include() 的作用幾乎相同，但是 include_once() 會先檢查要匯入的檔案是否已經被匯入過了，如果有的話就不會再重複匯入該檔案。
這個檢查有時候是很重要的，例如：在要匯入的檔案裡面有包含很多變數、自定義的函式，如果是用 include() 重複匯入該檔案，第二次匯入時就會發生錯誤，因為 PHP 不允許同名的變數、函式被重複宣告。
### require()
require() 會將目標檔案的內容讀入，並把自己本身替換成這些讀入的內容。
### require_once()
require(), require_once() 的差別也是在於： require_once() 會先檢查要匯入的檔案是否有被匯入過了，如果有的話就不會再重複匯入該檔案。

### 綜合比較
include(), include_once() 適合用來引入動態的程式碼。如果找不到要引入的檔案會出現錯誤訊息，但程式不會停止執行。

require(), require_once() 適合用來引入靜態的檔案內容。如果找不到要引入的檔案會出現錯誤訊息，且程式會停止執行。

## 請說明 SQL Injection 的攻擊原理以及防範方法

### SQL Injection 攻擊原理
SQL Injection（駭客的填字遊戲），意思就是：
駭客把一個惡意構造的字串，注入到 SQL query 當中，去改變了 SQL query 原本的意思
##### 會發生 SQL Injection 就是因為 SQL query 是用「字串拼接」的方式，任何人都可以透過一個惡意構造的字串去改變 SQL query 原本的意思
#### SQL Injection 範例（假冒身份登入）
#### 駭客只要知道你的 username，就可以假冒你的身份登入
假設在資料庫裡面，有一個使用者的帳號是 aa，密碼是 sunny33

在最陽春版的留言板中， login.php 登入功能的 SQL query 是這樣：
比對使用者輸入的帳號和密碼是否同時在資料庫中，如果有找到資料（`num_rows` > 0） 就登入成功
```php
SELECT * from users where username='%s' and password='%s'
```

駭客故意輸入了一個惡意構造的帳號
駭客輸入的帳號是 `username: aa'#`，密碼是 `password: bbb`（密碼隨便寫什麼都可以）

所以把資料帶進去 SQL query 後就會是這樣：
```php
SELECT * from users where username='aa'#' and password='bbb'
```

把這段 SQL query 放到 PhpMyAdmin 去執行，會發現從 `#` 開始的字都是黃色的（`#` 後面的都會是註解）
![](https://i.imgur.com/hiRus7X.jpg)
#### 因此，SQL query 原本的意思被改變了，變成是：只把 username 從資料庫 select 出來（不管 password 了）
會被執行的只有前面這段 `SELECT * from users where username='aa'`，後面這段 `#' and password='bbb'` 會被當成是註解（不會被執行）

因為資料庫裡面的確有 aa 這個 username，所以這段 `SELECT * from users where username='aa'` 會找到資料（`num_rows` > 0），儘管駭客輸入的密碼是錯的，但是因為 SQL query 根本就不會去檢查密碼，所以駭客依然假冒 aa 的身份登入成功了！
#### 其實，就算駭客不知道 username 也沒關係，只要可以讓前面這段 `SELECT * from users where username='%s'` 有傳東西回來（`num_rows` > 0）就可以登入成功了

因此，駭客只需要傳入 `username: ' or 1=1#`，`password: bbb`（密碼隨便寫什麼都可以）

把 username 和 password 帶入 SQL query 就會長這樣：
```php
SELECT * from users where username='' or 1=1#' and password='bbb'
```
會被執行的只有前面這段 `SELECT * from users where username='' or 1=1`，後面這段 `#' and password='bbb'` 不會被執行（會被當成註解）

那因為 `1=1` 永遠都是 true，所以這段 SQL query 就會撈出資料庫裡面所有的資料，也就是說 `num_rows` > 0 （就登入成功了）

### SQL Injection 防範方法：prepared statement
要修正 SQL Injection，可以使用 MySQL 內建的方法叫做 prepared statement

原本的 SQL query 是用「字串拼接」的方式，
那麼 prepared statement 的差別在於：prepared statement 是用 MySQL 內建的機制去把我傳進去的參數（字串）做拼接，就可以把那些惡意構造的指令解釋成「純文字」，就不會發生 SQL Injection 的問題了

因此，要修改 SQL query 的寫法，範例如下：

```php
...
  $sql = 'insert into comments(nickname, content) values(?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $nickname, $content);
  
  // 執行 query
  $result = $stmt->execute();
  if (!$result) {
    die('Error: ' . $conn->error);
  }
...
```

##  請說明 XSS 的攻擊原理以及防範方法

### XSS 攻擊原理
#### 發現問題：XSS
XSS 的全名是 Cross-Site Scripting，意思就是：跨站（在別人的網站）執行 `<script>`

XSS 會發生的根本原因就是：把 client 輸入的資料當成是一段程式碼去執行，而不是純文字

例如：
當我在留言欄位中輸入這段：`<h1>Hello!</h1>`
![](https://i.imgur.com/CfbqCWo.jpg)

按下 Submit 後，這段留言內容就會被解析成程式碼（html 標籤）並執行它（顯示出 h1 標題），而不是純文字 `<h1>Hello!</h1>`
![](https://i.imgur.com/0ftCGNF.jpg)
#### XSS 範例一
駭客在留言欄位中輸入了這段 script：`<script>location.href='https://google.com'</script>`
![](https://i.imgur.com/1bWWjek.jpg)

按下 Submit 後，這段留言內容就會被解析成程式碼並執行它，把網頁導到 google.com 去（真正的駭客可以把你導到一個跟原本網站長很像的釣魚網站去，就會有人上鉤）
![](https://i.imgur.com/LU8junn.jpg)

### XSS 防範方法：htmlspecialchars
要修補 XSS 的問題，可以使用 PHP 內建的函式叫做 `htmlspecialchars`，把 client 端輸入的資料經過特殊處理（變成純文字）後，才顯示在畫面上

`htmlspecialchars` 函式會把一些特殊字元，例如 `<` 就會被編碼成字串 `&lt;`，然後 html 就會把字串 `&lt;` 解釋成 < 這個「純文字」（而不會是 `<` 這個 tag）
#### utils.php
因此，就可以在 utils.php 裡面新增一個 `escape` 函式來做「跳脫」，把一個字串傳進 `escape` 函式就可以處理掉所有的特殊字元：
```php
...
  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
...
```

#### 注意！建議是在「顯示在畫面上之前」再去做跳脫即可，而不是在「存進資料庫之前」做跳脫
原因為：
因為資料庫裡面的資料，不是只有網頁會用到而已，有可能在手機 app 上也會用到

如果是把跳脫過後的內容存進資料庫，IOS 和 Android 就看不懂這些跳脫過後的內容 （只有瀏覽器看得懂跳脫過後的內容）

所以，要讓資料庫裡面存的資料可以「保持使用者原本輸入的內容（如下）」，而不是存跳脫過後的內容
![](https://i.imgur.com/qhxjuJ0.jpg)

## 請說明 CSRF 的攻擊原理以及防範方法

### CSRF 的攻擊原理
CSRF 的全名是 Cross-Site Request Forgery（跨站請求偽造），也就是攻擊者會讓使用者在不知情的情況下，發出一個惡意的 request 到 server（這個 request 的 method 可以是 GET 或是 POST）

例如在一個購物網站的會員系統中，刪除會員帳號的網址是 `/delete.php?account=5`
攻擊者想要讓小明在不知情的情況下把自己的帳號刪掉，因此刻意發給小明一個心理測驗網站，網站裡面有一行程式碼是：
```htmlmixed
<img src="https://shop.com/delete.php?account=5" width="0" height="0">
```

當小明用瀏覽器打開這個心理測驗網站時，就會發出一個 request 到 https://shop.com/delete.php?account=5 這個網址去，而且因為瀏覽器的運行機制，會把 shop.com 這個 domain 底下的 cookie 也一起帶過去（也就是說，如果小明有登入的話，在 cookie 裡面就會有小明的 session id）

因此，server 收到 request 後比對了 session id，就會認為這個 request 就是小明發出的，小明的會員帳號就被刪除了
### CSRF 的防範方法
在 Google 用關鍵字「PHP CSRF」搜尋，從搜尋結果看了好幾篇[文章](https://riptutorial.com/php/example/19314/cross-site-request-forgery)，都提到要解決 CSRF 的一個常見方法就是使用 CSRF token，但是這方法會遇到一個問題是：如果 server 有支援 cross site 的 request，攻擊者就可以在他的頁面發起 request 並拿到這個 csrf token

目前一個比較完善的作法是從瀏覽器下手，因為 CSRF 其實就是因為瀏覽器的運行機制才得以成立的
這個做法就是：啟用 Google 的 SameSite cookie

只要在設置 Cookie 的 header 後面多加上一個 `SameSite` 即可：
```php
Set-Cookie: session_id=jlwemmm355; SameSite
```

`SameSite` 有兩種模式，可以自己指定模式：
```php
Set-Cookie: session_id=jlwemmm355; SameSite=Strict
Set-Cookie: session_id=jlwemmm355; SameSite=Lax
```
#### Strict 模式
如果不指定模式的話，Strict 就是預設的模式，意思是：這個 Cookie 只允許 same site 使用，不可以被加在任何的 cross site request 上面

這樣雖然很安全，但是因為連 `<a href="...">` 都不會帶上 Cookie，當我從 Google 搜尋結果或其他地方點進某個網站時，因為沒有帶 Cookie，所以那個網站都會變成是登出狀態，使用者體驗會很不好

因此可以改為使用另一種模式：
#### Lax 模式
Lax 模式會放寬一些限制，例如 `<a>`,`<link rel="prerender">`, `<form method="GET">` 這些可以帶上 Cookie，但只要是 POST, PUT, DELETE 這些方法的，都不會帶上 Cookie

這樣，使用者從其他地方連進網站時就能夠維持登入狀態，但要注意的是：在 Lax 模式就沒辦法擋掉 GET 形式的 CSRF
