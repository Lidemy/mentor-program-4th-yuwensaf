## 什麼是 DOM？

DOM 的全名是 Document Object Model，簡單來說，DOM 就是「把 document 轉換成 object」，也就是：把一整個網頁（document）轉換成一個有階層關係的樹狀圖，我可以取得「`<body>` 裡面的所有元素」或是「`<a>` 元素的 text」（就像是物件一樣，我可以取得物件 a 的某個屬性）

![](https://i.imgur.com/EwZEYqc.jpg)

瀏覽器提供了 DOM 這個橋樑，讓我們可以用 JS 去改變畫面上的東西。

JavaScript 就是透過 DOM 跟瀏覽器溝通，用 JS 可以拿到任何一個 DOM，然後就可以去改變它的背景顏色、文字等等。

## 事件傳遞機制的順序是什麼；什麼是冒泡，什麼又是捕獲？
#### 先捕獲（由 window 往下層傳），再冒泡（從自己往父層傳回 window）
![](https://i.imgur.com/PnXaEaQ.jpg)

當我點擊 `<td>` 元素時，
#### 1. 第一階段（捕獲階段）：首先會進入到 Capture phase（捕獲階段），就會把事件由上（Window）傳到下（我點擊的 `<td>` 元素）
#### 2. 第二階段（Target phase）：在我點擊的 `<td>` 元素進入 Target phase
#### 3. 第三階段（冒泡階段）：Target phase 結束之後，接下來會進入到 Bubbling phase（冒泡階段），就會從自己往上層的父元素傳遞，從「我點擊的 `<td>` 元素」再把事件傳回去「Window」。在冒泡階段，就像是一層一層向上級長官回報。例如：在學校犯了錯，風紀股長就會回報給老師 > 學務主任 > 校長
### 注意！事件往上層傳時，只會傳遞到上層的父元素上，並不會傳遞到上層的其他子元素

## 什麼是 event delegation，為什麼我們需要它？

event delegation 就是：利用事件的冒泡機制，我們只需要在父元素加上 eventListener（例如：加上一個 click 事件），就可以監聽到底下所有子元素的 click 事件
#### 使用 event delegation 的好處是：
1. 只需要在父元素加上 eventListener 即可（子元素都不用加），讓程式碼更有效率、節省資源
2. 就算是後來才用 JS 動態新增的子元素，也都可以透過冒泡機制，讓父層接收到子元素的事件

## event.preventDefault() 跟 event.stopPropagation() 差在哪裡，可以舉個範例嗎？

### event.preventDefault()
#### :heavy_exclamation_mark: 注意！`preventDefault` 跟 DOM 的事件傳遞「一點關係都沒有」，加上 `e.preventDefault()` 這一行之後，事件還是會繼續傳遞（還是會有 capturing, target, bubbling 這三個 phase）

`e.preventDefault()` 作用是「阻止瀏覽器的預設行為」，底下是 `e.preventDefault()` 常用的幾個地方：

1. 點擊 submit 按鈕後，阻止瀏覽器送出表單
2. 點擊 `<a>` 後，阻止瀏覽器連到指定位置
3. 按下按鍵後，阻止瀏覽器輸入字元

### event.stopPropagation()
`e.stopPropagation()` 的作用是「阻止事件繼續傳遞」

會分為兩種情況：
#### 情況一：如果把 `e.stopPropagation()` 加在 xx 元素的捕獲階段，事件的傳遞就斷在 xx 元素的捕獲階段，事件不會繼續往下層傳遞
因此，如果我點擊了 xx 元素的下層元素，下層元素是接收不到事件的
#### 情況二：如果把 `e.stopPropagation()` 加在 xx 元素的冒泡階段，事件的傳遞就斷在 xx 元素的冒泡階段，事件不會繼續往父層傳遞
xx 元素的上層元素都不會接收到事件
