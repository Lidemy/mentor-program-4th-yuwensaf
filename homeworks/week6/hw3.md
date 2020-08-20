## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
### `<section>`
網頁中的一個區塊，這個區塊的內容是有意義的且會附帶標題。
### `<article>`
`<article>` 是一個獨立的區塊，會有完整的內容和標題。
`<article>` 和 `<section>` 不同的地方在於：`<article>` 有更高的獨立性和完整性，就算單獨把 `<article>` 抽出來看也會是一個完整的內容。而 `<section>` 對外層會有一定的相依性，無法獨立存在。
### `<aside>`
`<aside>` 是「除了主要內容以外的其他內容」，會與周圍的內容有相關性。例如：側邊欄。

> 參考資料 [Day14：小事之 HTML 語意化標籤 上篇](https://ithelp.ithome.com.tw/articles/10195356)

## 請問什麼是盒模型（box model）
box-sizing 這個屬性可以決定「要用什麼樣的模式來顯示」

* 預設是 `box-sizing: content-box`，意思就是：元素的 width, height 就是「content（內容）」的寬高，不包括 border 和 padding。因此，加上 border 或 padding 都會使元素額外再增加寬高（對開發者來說，計算寬高還要加加減減很麻煩）
* 如果設定成 `box-sizing: border-box`，意思就是：元素的 width, height 就是 content + border + padding 的寬高（已經把 border 和 padding 給算進去了）。因此，加上 border 或 padding 後，content 會自動縮小，讓元素的 width, height 不改變（對開發者來說很方便，因為不需要再去加加減減的計算寬高，因此通常都會設定成 `box-sizing: border-box`）

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
### display: inline
* span, a 這些元素，預設就是 `display: inline`
* 調整 width, height 沒有作用（元素的 width, height 都是根據內容來決定的）
* 調整上下的 margin 沒有作用（只能夠調整左右的 margin）
* 調整左右的 padding 會把元素左右撐開，也會影響到元素的左右位置
* 調整上下的 padding 不會改變元素的位置，但還是會以元素 content 為中心點把元素的上下給撐開
* 使用時機：同一列可以並排多個 inline 元素
### display: block
* div, h1, p 這些元素，預設就是 `display: block`
* 調什麼都可以（可以任意調整元素的 width, height, padding, margin）
* 使用時機：當我想要自己就佔滿一整列（寬度會撐滿整個父元素），不跟其他元素並排
### display: inline-block
inline-block 集合了 inline 和 block 的優點
* button, input, select 這些元素，預設就是 `display: inline-block`
* 跟 inline 一樣可以並排
* 跟 block 一樣可以調整 width, height, margin, padding
* 使用時機：想要並排多個元素，又想要調整元素的 width, height, margin, padding

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？

### position: static
* 每個元素，預設就會是 `position: static`
* static 會順著排版流
* 會用到的場合：沒有需要特殊的排版時，就可以順著排版流去排
### position: relative
* `position: relative` 就是「相對定位」
* 用 top, right, bottom, left 來調整元素「相對於自己在 `position: static` 時」的位置
* relative 會順著排版流
* 只會改變自己的位置，不會影響到其他元素的位置
* 會用到的場合：要做出彈跳視窗右上角的叉叉按鈕，彈跳視窗就要設定為 `position: relative`，這樣就可以做為叉叉按鈕的參考點
### position: fixed
* `position: fixed` 會相對於 viewport （瀏覽器窗口）做定位
* 會脫離正常的排版流
* 會用到的場合：網頁右下角的 go-to-top 按鈕，就可以用 `position: fixed` 來固定在右下角的位置
### position: absolute
* `position: absolute` 會相對於參考點去做定位，也就是「絕對定位」
* 如果都沒有找到參考點，那就會以 body 做為參考點去做定位
* 會脫離正常的排版流
* 會用到的場合：要做出彈跳視窗右上角的叉叉按鈕，彈跳視窗就要設定為 `position: relative`，叉叉按鈕設定為 `position: absolute`，叉叉就可以相對於彈跳視窗去做定位
#### `position: absolute` 要怎麼找到參考點？
往上找，找到的第一個「position 不是 static 的元素」就是參考點

