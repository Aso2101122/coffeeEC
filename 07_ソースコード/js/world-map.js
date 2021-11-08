const text1 = document.getElementById('text1');
var images_src = new Array("./img/world-map_world-map_img_00.png"); //デフォルトの画像url
images_src.push("./img/world-map_africa_img_01_over.png"); //アフリカマウスオーバー時
images_src.push("./img/world-map_asia_img_02_over.png"); //東南アジアマウスオーバー時
images_src.push("./img/world-map_latin-america_img_03_over.png"); //中南米マウスオーバー時

var num = 0;



function msg(msg) {
    text1.value = msg;

}

function Picturechange(num) {
    document.getElementById("worldmap").src = images_src[num];
}

// jQuery('img[usemap]').rwdImageMaps();