<!-- phpログイン確認 -->



<!-- HTML部 -->
<div class="black-line"></div>
<header class="global-menu">
    <ul>
        <li>
            <a href="./index.php"><img src="img/global-menu_site-rogo.png"></a>
        </li>
        <li id="nav-item_li">
            <a href="" class="over" id="nav-item">商品</a>
            <ul id="item-over">
                <li class="item-link"><a href="product.php?category=01"><img src="./img/global-menu_beans.png"></a></li>
                <li class="item-link"><a href="product.php?category=02"><img src="./img/global-menu_coffee-utensils.png"></a></li>
            </ul>
        </li>
        <li>
            <from action="" method="post">
                <input type="text" placeholder="何をお探しですか" 　class="sarch-nav" />
                <button type="submit" class="serch_btn"><img src="./img/global-memu_serch_icon.png" class="serch_img"></button>
            </from>
        </li>
        <li>
            <a href="#" class="over">
                <img src="./img/nav-login_logo.png" width="60px" />
            </a>
            <ul id="user-over">
                <div>
                    <p>ゲスト様</p>
                    <button type="submit" onclick="location.href='./menber-login.php'" class="black-button">ログイン</button>
                    <br>
                    <button type="submit" onclick="location.href='./menber-add.php'" class="normal-button">新規会員登録</button>
                </div>
            </ul>
        </li>
        <li>
            <a href="./favorite.html" class="over"><img src="./img/nav-favorite_logo.png" width="60px" /></a>
        </li>
        <li>
            <a href="./cart.html" class="over"><img src="./img/nav-cart_logo.png" width="60px" /></a>
        </li>
    </ul>
</header>