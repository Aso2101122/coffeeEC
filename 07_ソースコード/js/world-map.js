//const text1 = document.getElementById('text1');
var area_title = document.getElementById('area-name');
var area_feature = document.getElementById('area-feature');
var images_src = new Array("./img/world-map_world-map_img_00.png"); //デフォルトの画像url
images_src.push("./img/world-map_africa_img_01_over.png"); //アフリカマウスオーバー時
images_src.push("./img/world-map_asia_img_02_over.png"); //東南アジアマウスオーバー時
images_src.push("./img/world-map_latin-america_img_03_over.png"); //中南米マウスオーバー時

// alert("値: " + sample[0]['area_id']);
var area_id = sample[0]['area_id'];
alert("値：" + sample[1]['area_id']);

var areanames = new Array('アフリカ', '東南アジア', '中南米');

var areafeatures = new Array('フルーティでほんのり甘い香り、そして良質な酸味をもっています。<br>また苦味の少ない豆が多く、飲みやすいコーヒーとなります。');
var num = 0;

// // テスト用メソッド（完成時に消す）
// function msg(msg) {
//     text1.value = msg;
// }

function pictureChange(num) {
    document.getElementById("worldmap").src = images_src[num];
}

function selectArea(num) {
    area_title.innerHTML = areanames[num - 1];
    area_feature.innerHTML = areafeatures[num - 1];
}


//レスポンシブ対応
jQuery('img[usemap]').rwdImageMaps();