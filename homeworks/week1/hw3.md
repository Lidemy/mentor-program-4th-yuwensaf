## 教你朋友 CLI


# 什麼是 command line
操縱電腦的方式有兩種：
* 第一種是透過 Graphical User Interface（簡稱 GUI）：例如電腦中的「檔案總管」，我可以透過這個“圖形化的介面”來操縱電腦幫我做「新增資料夾、新增檔案」等等的動作
![](https://i.imgur.com/Apjyqdb.jpg)
* 第二種就是透過 Command Line Interface（簡稱 CLI）：透過純文字（輸入指令），一樣可以操縱電腦幫我「新增資料夾、新增檔案」等等
![](https://i.imgur.com/Tm7iKZY.jpg)

因此，command line 其實就是操縱電腦的另一種方式而已。


# 如何使用 command line
首先，要開啟你電腦的終端機應用程式
* Mac 內建的叫做「Terminal」
* Windows 內建的叫做「命令提示字元」

除了使用內建的，也可以自行下載其他更好用的來用，例如：[iTerm2](https://www.iterm2.com/)

接著要介紹一些基本的 command line 指令


# Command Line 好用指令



在 Command Line 中，可以使用「絕對路徑」或是「相對路徑」來切換檔案位置
## 絕對路徑
以`/`開頭的，就是絕對路徑，代表一個「絕對的位置」

例如：`~/Desktop/test`

## 相對路徑
相對於現在的資料夾

例如：
在 `test`資料夾 底下有一個 `image`資料夾
![](https://i.imgur.com/m8DR5oi.jpg =400x)

我現在所在的資料夾是`~/Desktop/test`，因此，我只要輸入`cd image`，就可以跳到「在 `test`資料夾 底下的 `image`資料夾」

但是，如果我輸入的指令是 `cd /image`，就會出現錯誤「no such file or directory: /image」，是因為`/`代表「根目錄」，而在根目錄中，並沒有`image`資料夾
# 基本指令
執行每一個指令，其實就是在執行一個「程式」
## `pwd` 印出目前所在位置

print working directory 的簡寫

## `ls` 列出檔案清單

list 的簡寫--> 印出現在資料夾底下的檔案

### 加參數
在 `ls` 後面加上 `-` 就代表「我要加上參數」

### `ls -al`

用途：
1. 列出所有檔案（包括隱藏檔案），像是 `.`、`..`、`.DS_Store` 這些
2. 以詳細的方式列出檔案
以下紅色框框分別代表：
* 檔案權限
* 檔案擁有者
* 檔案大小
* 最後修改日期、時間
![](https://i.imgur.com/R3wPUyD.jpg)

## `cd` 切換資料夾

change directory 的簡寫


### `cd ..` 回到上一層
### `cd ~` 回到`/Users/saffran`資料夾
`~`就是代表 `/Users/saffran` 這個資料夾

## `man` 指令使用手冊
manual 的縮寫--> 使用說明書

在 `man` 後面接上「我要查詢的指令名稱」
例如：
`man ls` 就可以看到關於`ls`的使用說明手冊

### 指令可以加上哪些參數？
下面這行所列出的，就是`ls`後面可以加上的參數

```
SYNOPSIS
     ls [-ABCFGHLOPRSTUW@abcdefghiklmnopqrstuwx1%] [file ...]
```

下面會仔細介紹各個參數的用途
例如：
* `ls -a` 代表：列出所有檔案（包括隱藏的檔案）
    * `a`就是取 all 的開頭字母
    * Include directory entries whose names begin with a dot (.).
    * 檔案名稱最前方有一個`.`的通常都是「隱藏檔案」
* `ls -l` 代表：以詳細的方式列出檔案
    * List in long format. （`l`就是取 long 的開頭字母）
* `ls -al` 代表：以詳細的方式列出所有檔案（包括隱藏的檔案）
### 按下`q`可離開手冊畫面

# 檔案操作相關指令
## `touch` 更改檔案時間&建立檔案

### 更改檔案時間
當我 touch（碰一下）檔案，就更改了檔案最後修改的時間（檔案內容並不會被改變）

### 建立檔案
當我 touch 了一個「不存在的檔案」，就會直接幫我建立這個檔案

## `rm` 刪除
remove 的簡寫

### 刪除檔案： `rm 檔案名稱`
例如：
`rm index.html` 就可以把 index.html 刪除掉

### 刪除資料夾

#### 作法一： `rmdir 資料夾名稱`
例如：
`rmdir image` 就可以把 image 資料夾刪除掉
（dir 就是 directory 的簡寫）
#### 作法二： `rm -r 資料夾名稱`
例如：
`rm -r image` 就可以把 image 資料夾刪除掉

### 加參數
### `-f` 強制刪除
有些受到保護的檔案，在被刪除之前，會詢問你「是否確定要刪除」

如果指令加上`-f`，就會直接刪除，不會出現「是否確定要刪除」的提示

`-f`這個參數比較危險，因為有些重要的檔案，刪掉就救不回來了
### `-r`
在這裡，`-r`跟`-R`是一樣的

`-r`會把「這個資料夾 & 資料夾底下的全部檔案」都刪除，也就是「刪除資料夾的意思」

## `mkdir` 建立資料夾
make directory 的簡寫

## `mv` 移動檔案 or 改名
move 的簡寫
### 移到資料夾裡面： `mv 檔案名稱 資料夾名稱`
例如：
輸入指令 `mv hello.txt image`
就可以把「`hello.txt`檔案」移到「`image`資料夾」裡面
### 再從資料夾拿出來： `mv 檔案名稱 ..`
例如：
現在，在`image`資料夾裡面，有一個`hello.txt`檔案

注意！
要先移動到「`image`資料夾」，才可以輸入指令 `mv hello.txt ..`
就可以把「`hello.txt`檔案」移出「`image`資料夾」到上一層去

### 檔案改名： `mv 檔案舊名稱 檔案新名稱`
例如：
輸入指令 `mv hello.txt apple`，就可以把`hello.txt`改名為`apple`

可以想成是：我把`hello.txt`檔案移動到`apple`檔案去

## `cp` 複製
copy 的簡寫

### 複製檔案： `cp 檔案名稱 複製的檔案名稱`
例如：
輸入指令 `cp hello.txt hello2.txt`，就可以把原本的 `hello.txt` 檔案，複製一份且取名叫做 `hello2.txt`
### 複製資料夾： `cp -r 資料夾名稱 複製的資料夾名稱`
例如：
輸入指令 `cp -r image image2`，就可以把原本的 `image` 資料夾，複製一個且取名叫做 `image2` 資料夾


# 如何達成 h0w 哥想要的功能
h0w 哥想要的功能是：
“我想用 command line 建立一個叫做 wifi 的資料夾，並且在裡面建立一個叫 afu.js 的檔案。”

步驟如下：
1. 用 `mkdir wifi`，就可以建立一個叫做 wifi 的資料夾
2. 接著，用 `cd wifi` 移動到 wifi 資料夾底下
3. 用 `touch afu.js` 就可以建立一個叫 afu.js 的檔案






