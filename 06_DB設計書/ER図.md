```uml
@startuml

skinparam class {
    '図の背景
    BackgroundColor Snow
    '図の枠
    BorderColor Black
    'リレーションの色
    ArrowColor Black
}

!define MASTER_MARK_COLOR Orange 
!define TRANSACTION_MARK_COLOR SkyBlue

package "Beginners Coffee" as target_system {
    /'
      マスターテーブルを M、トランザクションを T などで表記
      １文字なら "主" とか "従" まど日本語でも記載可能
     '/
     
     entity "商品マスタ" as items <m_items> <<M,MASTER_MARK_COLOR>> {
        +  item_id[PK]
        --
        item_name
        price
        item_description
        item_img_url
        country_id[FK]
        category_id[FK]
        point
        featured_flag
        Registered_date
    }
        
    entity "生産国マスタ" as country <m_item> <<M,MASTER_MARK_COLOR>> {
        +  country_id[PK]
        --
        country_name
        country_img_url
        area_id[FK]
    }
    
    entity "生産エリアマスタ" as area <m_area> <<M,MASTER_MARK_COLOR>> {
        +  area_id[PK]
        --
        area_name
    }
    
    entity "カテゴリマスタ" as category <m_category> <<M,MASTER_MARK_COLOR>> {
        +  category_id[PK]
        --
        category_name
    }
   
    entity "会員マスタ" as user <m_user> <<M,MASTER_MARK_COLOR>> {
        +  user_id[PK]
        --
        mail
        password
        last_name
        first_name
        phone_number
        postcode
        prefecture_id
        city
        block
        building
        owne_points
        signup_at
    }
    
    entity "注文テーブル" as order <t_order> <<T,TRANSACTION_MARK_COLOR>> {
        +  order_id[PK]
        --
        user_id[FK]
        order_at
        postage
        total_fee
        earne_point
        use_point
    }
    
    entity "注文詳細テーブル" as order_detail <t_order_detail> <<T,TRANSACTION_MARK_COLOR>> {
        +  order_detail_id[PK]
        --
        order_id[FK]
        item_id[FK]
        amount
        quantity
        price
    }
    
    entity "お気に入りテーブル" as favorite_items <t_favorite_items> <<T,TRANSACTION_MARK_COLOR>> {
        +  favorite_id[PK]
        --
        user_id[FK]
        item_id[FK]
        register_at
    }
    
    items -r- order_detail
    items -l- favorite_items
    items -d- country
    country -r- area
    items -d- category
    
}
     
     
@enduml
```
