## 跟你朋友介紹 Git


# 什麼是版本控制？

做版本控制的“目的”就是：
一個檔案會有不同版本，但我希望把每個版本都保存起來

Git 就是一個：幫我做版本控制的程式

# 版本控制要有哪些功能
以下是「自己用資料夾做版本控制」的方式，來推導出一個版本控制應該要有哪些功能（模擬 Git 的運作機制）

1. 需要新版本：就開一個新的資料夾（新增一個 commit）
2. 不想加入版本控制的檔案：就不要加入資料夾（例如：電腦本身的設定檔、放有帳號密碼的檔案等等，都不需要加入版本控制）
3. 避免版本號衝突：用看似亂數的東西當做資料夾名稱（版本編號），每個亂數保證不會相等
4. 知道最新版本：用一個檔案來存最新的版本號
5. 知道歷史記錄：用一個檔案來存「每個版本的順序」

Git 就是要幫我做到上面這些事情



# `git init` 產生 .git 資料夾
該如何對我的專案（test 資料夾），開始使用 Git 這個軟體呢？

作法就是：
1. 打開 CLI，移動到 test 資料夾
2. 輸入指令 `git init`

`init` 就是 initialize（初始化）的意思

在 test 資料夾使用 `git init` 指令後，Git 就知道我想要對這個專案做版本控制了，這時，我的專案資料夾就是一個 Git 的 Local repository

接下來，我就可以使用更多指令來做版本控制

這時，在 test 資料夾裡面，會多出一個 .git 資料夾（是一個隱藏的資料夾），Git 做版本控制需要用到的所有東西都會存在這個資料夾裡面

## 移除 .git 資料夾
如果我不再需要對此專案做版本控制了，只需要輸入指令 `rm -rf .git` 來移除掉 .git 資料夾即可
# `git status` 查看狀態
查看目前的狀態
# `git add`
例如：
在我的專案資料夾內，現在有三個檔案：
```
code.js
note.txt
password
```
針對專案內的每個檔案，我需要決定「這個檔案是否要加入版本控制」

## `git add 檔案名稱` 加入版本控制
輸入指令 `git add code.js`，就可以把 code.js 加入版本控制

Git 會把檔案分成兩個區域：
* untracked 不加入版本控制
* staged 加入版本控制

## `git add .` 把所有檔案加入版本控制
`.` 就是「所有檔案」的意思

在 `git add` 後面加上 `.` 或是 `資料夾名稱`，就可以把資料夾底下的所有檔案加入版本控制

## `git rm --cached code.js` 移出版本控制 
把檔案從 staged 移回 untracked

# `git commit` 新建一個版本

## 當 commit message 較多時
使用指令 `git commit` 就會進入一個 vim 編輯器，在這裡可以輸入 commit message
## 當 commit message 只有一句話時
如果 commit message 很短，那就可以直接使用指令 `git commit -m 'first commit'`

這個參數 `m` 就是「message」的意思，後面用 `引號` 包起來的地方就可以輸入你想要打的 commit message

## `git commit` 出現錯誤
如果你在 `git commit` 的時候出現錯誤，跳出了一個要你設定帳號跟姓名的畫面，請輸入以下指令

（把名字跟 email 換成你自己的）
```
git config --global user.name "your name"
git config --global user.email "your email"
```

如果你的作業系統是 Windows，請注意後面的字串一定要用雙引號，用單引號的話會出錯：

`git commit -am 'error' // 錯誤`

`git commit -am "success" // 正確`

# `git commit -am`

輸入指令 `git commit -am 'forth commit'`，這裡加上了一個參數 `-am`，
意思就是：把 `git add .` 和 `git commit -m 'forth commit'` 合併在一起

`-a`這個參數就是 `-all` 的意思，作用是：自動把修改過的檔案再次加入到 staged 區域（必須是之前已經有被 staged 過的檔案才可以），但如果是「還在 untracked 區域的檔案」就不會去理它（不會把它移到 staged 區域，也不會 commit 它）

* 參考 [git-commit_options](https://git-scm.com/docs/git-commit#Documentation/git-commit.txt--a)


# Git 的多人協作

Git 要如何做到多人協作呢（讓大家共同開發一個 Git 的專案）？

#### 在 Git 裡面，「被 Git 控制的一個專案」就稱為一個「repository」
因此，多人協作就是要「共享同一份 repository」

## Git vs GitHub
Git 是一個「版本控制的程式」
GitHub 是一個「可以放 Git repository 的地方」，當然也還有其他更多的功能

## GitHub--> 視覺化你的 repository

在 GitHub 中，README.md 檔案的內容 “預設” 就會顯示在頁面下方，
README.md 通常會寫一些：專案的介紹、使用操作說明等等

![](https://i.imgur.com/kb5DEwp.jpg)


在出現 bug 時，用 GitHub 可以很方便的查看「這行程式碼是誰寫的、最後修改時間、為什麼要修改」，才能查出為什麼會有這個 bug

![](https://i.imgur.com/vnMTt8m.jpg)

### History

點擊 History，可以看到這個檔案過往的所有 commit 記錄和 commit message（為什麼要改）

（commit 就是“提交一個版本”的意思）
### Blame
點擊 Blame，可以看到每一行程式碼「最後是被誰改的、是什麼時候改的」，當有問題時就知道要找誰去問了

# 把本地的 code 同步到 GitHub 上

## 可以想成是：「本地端的 repository」跟「GitHub 上的 repository」其實是同一個，但是需要自己“手動”去同步它們兩個

要如何把「我的電腦裡的 Git repository」放到 GitHub 上呢？

#### 1. 在 GitHub 點擊右上角的 + 號，選擇 New repository
![](https://i.imgur.com/kec6PSB.jpg)
#### 2. 我把 repository 取名為「git101_test」，按下 Create repository 之後，我的 repository 就在 GitHub 上面建好了（目前是一個空的 repository）
#### 3. 看到的第一個畫面會是一個教學說明，那因為我在本地端的電腦上已經有 repository 了，因此就可以參考「…or push an existing repository from the command line」的教學

![](https://i.imgur.com/1bT4y8u.jpg)

```
git remote add origin https://github.com/yuwensaf/git101_test.git
```
* remote 就是「遠端」的意思，`git remote add` 代表「我要新增一個遠端的 repository」
* 這個遠端 repository 的位置是 `https://github.com/yuwensaf/git101_test.git` （是 GitHub 提供的位置）
* 這個遠端 repository 的名稱是 `origin` （是 GitHub 預設的名稱，也可以自己改叫其他名稱）


```
git push -u origin master
```
* `push` 就是「把本地端的檔案推上去」
* `-u` 這個參數代表 `-set-upstream`，意思就是：設定一個地方（我要把檔案推到那個地方），在這裡就是 `origin` 這個遠端的 repository
* `master` 是「我要推送的本地分支」
* 整句指令的意思是：我要把「本地端的 master 分支」push 到「`origin` 這個遠端 repository」裡面

#### 4. 因此，就在 CLI 輸入這兩行指令
```
git remote add origin https://github.com/yuwensaf/git101_test.git
git push -u origin master
```

重新整理網頁，就可以看到我推上去的檔案了（在 master 分支上）

![](https://i.imgur.com/Z9rrQPJ.jpg)


# `git push`
使用 `git push 遠端repository名稱 本地分支名稱` 可以把我在本地端最新修改好的檔案，再次推送到 GitHub 上

流程如下：
1. 我在本地端修改了 code.js 檔案
2. 在本地端新增一個 commit
```
git commit -am 'modify code.js'
```

3. 輸入指令 `git push origin master`，來把「本地端的 master 分支」push 到「origin 這個遠端 repository」

### 注意！一定要做「push」這個動作，本地端的檔案才會跟遠端同步

4. 回到 GitHub 頁面重新整理後，就可以看到最新的 commit 了
![](https://i.imgur.com/VmVnV9g.jpg)

## 推送「本地端的其他分支」到遠端 repository
例如：
1. 我在本地端建立一條新的分支叫做 issue
```
git branch issue
```
2. 切換到 issue 分支
```
git checkout issue
```
3. 輸入指令 `git push origin issue` 就可以把「本地端的 issue 分支」push 到「遠端的 origin 數據庫」
```
git push origin issue
```
4. 在 GitHub 頁面上，就可以看到剛剛同步上去的 issue 分支了
![](https://i.imgur.com/cc3ynwO.jpg)

# `git pull`
假設我的同事在 GitHub 上做了修改，那我要怎麼把遠端最新的版本同步到本地端呢？
## 在 GitHub 直接修改檔案
GitHub 有提供「修改檔案」的功能

因為在 GitHub 上面也是一個 Git repository，因此檔案改完之後也要做 commit 的動作

1. 進入檔案，點擊這個鉛筆 icon，就可以進入修改的頁面
![](https://i.imgur.com/5rK1Eze.jpg)
2. 修改完成後，只要按下 Commit changes，GitHub 就會自動幫我產生 commit 了
![](https://i.imgur.com/Nfhh10i.jpg)

## `git pull origin master`

輸入指令 `git pull origin master`，就可以把「遠端 origin 的 master 分支 」pull 到「本地端的 master 分支」

## 當 pull 遇到衝突時
1. 我在本地端修改了 code.js 的第一行，改完後新增一個 commit
```
git commit -am 'modify first line'
```
2. 同事也在 GitHub 上修改了 code.js 的第一行，改完後在 GitHub 新增一個 commit
3. 這時，我在本地端輸入指令 `git pull origin master`，就會出現衝突「Merge conflict in code.js」
用 `git status` 可以看到
```
Unmerged paths:
  (use "git add <file>..." to mark resolution)
	both modified:   code.js
```
4.  因此，就把 code.js 打開來看，自己手動決定要保留的內容，儲存檔案後就可以新增一個 commit
```
git commit -am 'update code.js first line'
```
5. 然後就可以從本地端 push 回去到遠端 repository，遠端的 repository 就會被同步更新了
```
git push origin master
```













