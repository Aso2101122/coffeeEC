# DB定義書
## ER図
[ER図はこちら](https://github.com/Aso2101122/coffeeEC/blob/main/06_DB%E8%A8%AD%E8%A8%88%E6%9B%B8/ER%E5%9B%B3.md)

<img src="./img/ER図.png" width="700px">

# DBテーブルカラム一覧
## m_items

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|商品ID|item_id|varchar(11)|〇|〇||
|商品名|item_name|varchar(100)||〇||
|価格|price|int(11)||〇||
|商品説明|item_description|mediumtext||〇|||
|商品画像パス|item_img_url|varchar(255)||〇||
|生産国ID|country_id|varchar(11)||〇|〇|
|カテゴリID|category_id|varchar(11)||〇|〇|
|ポイント|point|int(11)||〇||
|苦味|bitter|int(1)||〇||
|甘味|sweet|int(1)||〇||
|酸味|acidity|int(1)||〇||
|コク|rich|int(1)||〇||
|香り|scent|int(1)||〇||
|登録日時|Registered_date|timestamp||〇||
|おすすめフラグ|featured_flag|bit(1)||||
|非公開フラグ|private_flag|bit(1)|||

## m_country

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|生産国ID|country_id|varchar(11)|〇|〇||
|生産国名|country_name|varchar(100)||〇||
|生産国旗画像パス|country_img_url|varchar(255)||〇||
|生産地方ID|area_id|varchar(11)|||〇|〇|

## m_area

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|生産地方ID|area_id|varchar(11)|〇|〇||
|生産地方名|area_name|varchar(100)||〇||
|地方説明|area_explanation|text||||
|代表国|area_country|text||||
|代表的なブランド|area_beans|text||||

## m_category

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|カテゴリID|category_id|int(11)|〇|〇||
|カテゴリ名|category_name|varchar(30)||〇||

## m_user

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|会員ID|user_id|varchar(11)|〇|〇||
|メールアドレス|mail|varchar(255)||〇||
|パスワード|password|varchar(255)||〇||
|名前|last_name|text||〇||
|姓名|first_name|text||〇||
|電話番号|phone_number|int(11)||||
|郵便番号|postcode|int(11)||||
|都道府県|prefecture|varchar(100)||||
|市区町村|city|varchar(100)||||
|丁目番地|block|varchar(100)||||
|マンション名・部屋番号等|building|varchar(100)|||||
|保有ポイント|owne_points|int(11)||〇||
|サインアップ日時|signup_at|timestamp|||||
|削除日時|delete_at|datetime||||

## t_order

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|注文ID|order_id|int(11)|〇|〇||
|会員ID|user_id|int(11)||〇|〇|
|注文日時|order_at|timestamp||〇||
|送料|postage|int(11)||〇||
|合計金額|total_fee|int(11)||〇||
|獲得ポイント|earne_point|int(11)||||
|使用ポイント|use_point|int(11)||||
|キャンセルフラグ|cancel_flag|bit||||

## t_order_detail

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|注文詳細ID|order_detail_id|int(11)|〇|〇||
|注文ID|order_id|int(11)||〇|〇|
|商品ID|item_id|int(11)||〇|〇|
|量|amount|int(11)||||
|数量|quantity|int(11)||〇||
|金額|price|int(11)||〇||

## t_favorite_items

|論理名|物理名|型|PK|NN|FK|
|--|--|--|--|--|--|
|お気に入りID|favorite_id|int(11)|〇|〇||
|会員ID|user_id|int(11)||〇|〇|
|商品ID|item_id|int(11)||〇|〇|
|登録日時|register_at|timestamp||〇||
|削除フラグ|delete_flag|bit(1)||||
