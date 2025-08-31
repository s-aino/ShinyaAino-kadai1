# ER 図

```mermaid
erDiagram
  CATEGORIES ||--o{ TODOS : has
  CATEGORIES {
    int id PK
    string name
    datetime created_at
    datetime updated_at
  }
  TODOS {
    int id PK
    int category_id FK
    string content
    datetime created_at
    datetime updated_at
  }
