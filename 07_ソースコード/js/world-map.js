//const text1 = document.getElementById('text1');
//エリア名オブジェクト取得
var area_title = document.getElementById('area-name');
//エリア説明オブジェクト取得
var area_feature = document.getElementById('area-feature');
//主な生産国項目名オブジェクト取得
var area_country_th = document.getElementById('area-country-th');
//有名なブランド項目名オブジェクト取得
var area_beans_th = document.getElementById('area-beans-th');
//主な生産国オブジェクト取得
var area_country = document.getElementById('area-country');
//有名なブランドオブジェクト取得
var area_beans = document.getElementById('area-beans');

// 商品1のオブジェクトを取得
var item_name1 = document.getElementById('item-name1');





var area_table = document.getElementById('area-table');
var area_tr1 = document.getElementById('area-tr1');
var area_tr2 = document.getElementById('area-tr2');

var images_src = new Array("./img/world-map_world-map_img_00.png"); //デフォルトの画像url
images_src.push("./img/world-map_africa_img_01_over.png"); //アフリカマウスオーバー時
images_src.push("./img/world-map_asia_img_02_over.png"); //東南アジアマウスオーバー時
images_src.push("./img/world-map_latin-america_img_03_over.png"); //中南米マウスオーバー時

// alert("値: " + sample[0]["area_name"]);
// alert(sample[1]["area_id"]);
// var area_id = sample[0]['area_id'];
// alert("値：" + sample[1]['area_id']);

var num = 0;

function pictureChange(num) {
    document.getElementById("worldmap").src = images_src[num];
}

function selectArea(area_num) {
    console.log(area_num);
    area_title.innerHTML = area_result[area_num - 1]["area_name"];
    area_feature.innerHTML = area_result[area_num - 1]["area_explanation"];

    // 商品情報を変える
    item_name1.innerHTML = africa_item[0][item_name];








    area_country_th.innerHTML = "主な生産国";
    area_beans_th.innerHTML = "有名なブランド";
    area_country.innerHTML = area_result[area_num - 1]["area_country"];
    area_beans.innerHTML = area_result[area_num - 1]["area_beans"];

    // エリア名のクラスを変える
    area_title.className = "area-name-on";
    // テーブルのクラスを動的に変える
    area_table.className = "area-table-on";
    area_tr1.className = "area-tr-on";
    area_tr2.className = "area-tr-on";

}


//レスポンシブ対応
jQuery('img[usemap]').rwdImageMaps();