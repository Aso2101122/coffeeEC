# データベース設計図

## m_items

|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|item_id|int(11)|〇|〇||
|item_name|varchar(50)||〇||
|price|int(11)||〇||
|item_description|text||〇|||
|item_img_url|text||〇||
|country_id|int(11)||〇|〇|
|category_id|int(11)||〇|〇|
|point|int(11)||〇||
|featured_flag|bit||||
|Registered_date|datetime||〇||


## m_country
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|country_id|int(11)|〇|〇||
|country_name|varchar(100)||〇||
|country_img_url|text||〇||
|area_id|int(11)|||〇|〇|

## m_area
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|area_id|int(11)|〇|〇||
|area_name|text||〇||

## m_category
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|category_id|int(11)|〇|〇||
|category_name|varchar(30)||〇||

## m_user
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|user_id|int(11)|〇|〇||
|mail|varchar(255)||〇||
|password|varchar(100)||〇||
|last_name|text||〇||
|first_name|text||〇||
|phone_number|int(11)||||
|postcode|int(11)||||
|prefecture_id|varchar(100)||||
|city|varchar(100)||||
|block|varchar(100)||||
|building|varchar(100)|||||
|owne_points|int(11)||〇||
|signup_at|datetime|||||

## t_order
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|order_id|int(11)|〇|〇||
|user_id|int(11)||〇|〇|
|order_at|datetime||〇||
|postage|int(11)||〇||
|total_fee|int(11)||〇||
|earne_point|int(11)||||
|use_point|int(11)||||

## t_order_detail
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|order_detail_id|int(11)|〇|〇||
|order_id|int(11)|〇|〇|〇|
|item_id|int(11)|〇|〇|〇|
|amount|int(11)||〇||
|quantity|int(11)||〇||
|price|int(11)||〇||
## t_favorite
|項目名|型|PK|NN|FK|
|--|--|--|--|--|
|favorite_id|int(11)|〇|〇||
|user_id|int(11)||〇|〇|
|item_id|int(11)||〇|〇|
|register_at|datetime||〇||

