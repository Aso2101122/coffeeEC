console.log('こんばんは');
function execPost(method,item_id,user_id) {
    console.log('こんにちは');
    console.log(item_id);
    console.log(user_id);
    console.log(method);
    //inputを記述
    var form = document.createElement('form');
    form.setAttribute('action', 'http://aso2101122.schoolbus.jp/Biginners-coffee/item-detail.php?id='+ item_id);
    form.setAttribute('method', 'post');
    form.style.display = 'none';
    document.body.appendChild(form);

    //追加か削除かflag
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'method');
    input.setAttribute('value', method);
    form.appendChild(input);    // FORMへインプットパラメータとして追加

    //商品id
    var input2 = document.createElement('input');
    input2.setAttribute('type', 'hidden');
    input2.setAttribute('name', 'item_id');
    input2.setAttribute('value', item_id);
    form.appendChild(input2);    // FORMへインプットパラメータとして追加

    //ユーザーid
    var input3 = document.createElement('input');
    input3.setAttribute('type', 'hidden');
    input3.setAttribute('name', 'user_id');
    input3.setAttribute('value', user_id);
    form.appendChild(input3);    // FORMへインプットパラメータとして追加

    form.submit();
}
