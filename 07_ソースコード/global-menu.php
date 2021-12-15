<!-- phpログイン確認 -->
<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $login_flag = true;
    $user_name = "";
    $user_name = $_SESSION['user']['last_name'].$_SESSION['user']['first_name'];
    $point = $_SESSION['user']['owned_points'];
}else{
    $login_flag = false;
}

?>
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
            <form action="./product.php" method="get">
                <input type="text" name="keyword" placeholder="何をお探しですか" class="sarch-nav" />
                <button type="submit" class="serch_btn"><img src="./img/global-memu_serch_icon.png" class="serch_img"/></button>
            </form>
        </li>
        <?php if(!$login_flag) :?>
        <li>
            <a href="#" class="over">
                <img src="./img/nav-login_logo.png" width="60px" />
            </a>
            <ul id="user-over">
                <div>
                    <p>ゲスト様</p>
                    <button type="button" onclick="location.href='./menber-login.php'" class="black-button">ログイン</button>
                    <br>
                    <button type="button" onclick="location.href='./menber-add.php'" class="normal-button">新規会員登録</button>
                </div>
            </ul>
        </li>
        <?php endif ?>
        <?php if($login_flag) :?>
        <li>
            <a href="#" class="over">
                <img src="./img/nav-mypage_logo.png" width="60px" />
            </a>
            <ul id="user-over">
                <div>
                    <p>こんにちは、<?= $user_name ?>様</p>
                    <a href="user-info-update.php">
                        <img src="./img/nav-user-info_logo.png" class="user-info-logo-img">
                        <span class="">お客様情報</span>
                    </a>
                    <div class="point-content">
                        <div class="point-text-content">
                            <span class="available-points">ご利用可能<br>ポイント</span>
                        </div>
                        <div class="point-display">
                            <span class="point-many"><?= $point ?></span>
                            <span class="point">pt</span>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="logout-content">
                        <a href="logout.php" class="logout-link">
                            <img src="./img/nav-logout_logo.png" class="logout-link-img"/>
                            <span class="logout-link-text">ログアウト</span>
                        </a>
                    </div>
                </div>
            </ul>
        </li>
        <?php endif ?>

        <li>
            <a href="./favorite.php" class="over"><img src="./img/nav-favorite_logo.png" width="60px" /></a>
        </li>
        <li>
            <a href="./cart.php" class="over"><img src="./img/nav-cart_logo.png" width="60px" /></a>
        </li>
    </ul>
</header>