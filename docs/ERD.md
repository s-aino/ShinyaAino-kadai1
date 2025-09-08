# ER 図

 ```mermaid
erDiagram
  USERS ||--o{ CONTACTS : 投稿者
  CATEGORIES ||--o{ CONTACTS : has-many

  USERS {
    BIGINT id PK
    STRING name
    STRING email
    STRING password
    DATETIME created_at
    DATETIME updated_at
  }

  CATEGORIES {
    BIGINT id PK
    STRING content
    DATETIME created_at
    DATETIME updated_at
  }

  CONTACTS {
    BIGINT id PK
    STRING last_name
    STRING first_name
    TINYINT gender "1:男性 2:女性 3:その他"
    STRING email
    STRING tel
    STRING address
    STRING building
    BIGINT category_id FK
    STRING detail "120文字以内"
    DATETIME created_at
    DATETIME updated_at
  }
