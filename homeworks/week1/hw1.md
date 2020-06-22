## 交作業流程


寫作業、交作業的步驟，從這裡開始：

## 設定 GitHub 專案

* GitHub classroom 網址：https://classroom.github.com/a/SbDvk2VA
* 我寫作業的地方：https://github.com/Lidemy/mentor-program-4th-yuwensaf


Lidemy 的課綱，其實就是一個交作業的模板
透過 GitHub classroom 把「Lidemy 的課綱」複製一份 repository 到我的 GitHub 帳號底下--> 我就是要在這份 repository 裡面交作業，也就是：https://github.com/Lidemy/mentor-program-4th-yuwensaf


先把這份「我帳號底下的 repository」複製到本地端
```zsh
git clone https://github.com/Lidemy/mentor-program-4th-yuwensaf.git
```

在我的本地端，就會有一個「mentor-program-4th-yuwensaf 資料夾」了

## 如何寫作業
首先，在 CLI 切換到「mentor-program-4th-yuwensaf 資料夾」
#### 1. 每週在開始寫作業之前，都要先建立一個新的分支（分支名稱可以用週次來命名）
```zsh
git branch week1
```
2. 切換到 week1 分支，在 week1 分支裡面修改所有的檔案（也就是寫作業），寫完作業後，在 week1 分支 commit
```zsh
git commit -am 'week1 完成'
```

到這裡，就寫完作業了，接下來就是要交作業
#### 注意！基本上，都不會在 master 分支上面修改任何檔案

## 如何交作業

### 步驟一：在 GitHub 發 pull request
寫完作業之後
1. 在 week1 分支上，使用指令 `git push origin week1`，把本地端的 week1 分支推送到遠端的 repository 去
2. 推送成功後，就可以到 [mentor-program-4th-yuwensaf](https://github.com/Lidemy/mentor-program-4th-yuwensaf) 頁面上，會看到剛剛推送上去的 week1 分支，點擊「Compare & pull request」，意思就是「我發出一個請求：我想要把 week1 分支 merge 到 master 上」，填寫完相關的標題、敘述之後，就可以按「Create pull request」

助教就可以在 Files changed 的 tab 這裡幫我改作業
#### 到這裡，就達成交作業的第一個步驟了

### 步驟二：到 Lidemy 學習系統繳交作業

1. 點擊「作業列表 > 新增作業」
2. 注意！這裡要貼的 PR 連結是 pull request 的連結
![](https://i.imgur.com/nshXOod.jpg)
3. 按下送出後，才完成「交作業」的所有步驟


## 當助教批改完我的作業後，他就會按「Merge pull request > Confirm merge」，把「遠端的 week1 分支」合併到「遠端的 master」上
然後助教就會把我「遠端的 week1 分支」給刪掉
（注意！此步驟都是助教才能做的）

當我看到作業上出現這個「Merged」的標籤，就代表助教改完我的作業了
![](https://i.imgur.com/XRtwpJt.jpg)

現在，在遠端的地方：week1 分支已經合併到 master 上了
#### 但是，本地端的 master 還沒同步
## 與本地端的 master 同步
回到本地端
1. 切換回 master 分支
```zsh
git checkout master
```
2. 在 master 分支使用指令 `git pull origin master`，把「遠端的 master」跟「本地端的 master」同步，這樣本地的 master 就也可以擁有最新的 master + week1 內容
#### 3. 最後，記得要把本地端的 week1 分支給刪掉
```zsh
git branch -d week1
```

## :tada: 寫作業、交作業的流程就完成了！





