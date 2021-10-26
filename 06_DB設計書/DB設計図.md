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
|item_category|int(11)||〇|〇|
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



