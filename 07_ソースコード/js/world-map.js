const text1 = document.getElementById('text1');
var images_src = new Array("./img/world-map_worldmap_img_00.png"); //デフォルトの画像url
images_src.push("./img/world-map_worldmap_img_01.png"); //アフリカマウスオーバー時
images_src.push("./img/world-map_worldmap_img_02.png"); //東南アジアマウスオーバー時
images_src.push("./img/world-map_worldmap_img_03.png"); //中南米マウスオーバー時

var num = 0;



function msg(msg) {
    text1.value = msg;

}

function Picturechange(num) {
    if (num = 0) {
        document.getElementById("worldmap").src = "./img/world-map_worldmap_img_00.png";
    } else if (num = 1) {
        document.getElementById("worldmap").src = "./img/world-map_worldmap_img_01.png";
    }

}

// jQuery('img[usemap]').rwdImageMaps();