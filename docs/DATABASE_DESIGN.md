# Database Design - Digi Herba

## 1. Entity-Relationship Diagram (ERD)

### Entitas Utama

#### Core Authentication
- **USERS** - Data pengguna (id, name, email, password, etc)
- **SESSIONS** - Session pengguna aktif
- **PASSWORD_RESET_TOKENS** - Token reset password
- **USER_PROVIDERS** - Integrasi social login (Google, GitHub, dll)

#### Authorization & Permissions
- **ROLES** - Peran pengguna (super admin, admin, user, etc)
- **PERMISSIONS** - Izin spesifik (view_backend, edit_users, dll)
- **MODEL_HAS_ROLES** - Junction table users ↔ roles (N:M)
- **MODEL_HAS_PERMISSIONS** - Junction table users ↔ permissions (N:M)
- **ROLE_HAS_PERMISSIONS** - Junction table roles ↔ permissions (N:M)

#### Media & Notifications
- **MEDIA** - File/gambar polymorphic (users, products, etc)
- **NOTIFICATIONS** - Notifikasi polymorphic (users, etc)

#### System Tables
- **CACHE** - Penyimpanan cache
- **CACHE_LOCKS** - Lock mechanism cache
- **JOBS** - Queue background jobs
- **JOB_BATCHES** - Batch processing
- **FAILED_JOBS** - Job yang gagal

### Relasi Antar Entitas

```
USERS (1) ─────── (N) SESSIONS
USERS (1) ─────── (N) USER_PROVIDERS
USERS (N) ─────── (N) ROLES      [via MODEL_HAS_ROLES]
USERS (N) ─────── (N) PERMISSIONS [via MODEL_HAS_PERMISSIONS]
USERS (1) ─────── (N) MEDIA      [polymorphic]
USERS (1) ─────── (N) NOTIFICATIONS [polymorphic]

ROLES (1) ─────── (N) MODEL_HAS_ROLES
ROLES (N) ─────── (N) PERMISSIONS [via ROLE_HAS_PERMISSIONS]

PERMISSIONS (1) ─ (N) MODEL_HAS_PERMISSIONS
PERMISSIONS (1) ─ (N) ROLE_HAS_PERMISSIONS
```

---

## 2. Logical Record Structure (LRS)

### Definisi Tabel

#### USERS
```
USERS (
  id BIGINT PK AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
Indexes: email, id
```

#### SESSIONS
```
SESSIONS (
  id VARCHAR(255) PK,
  user_id BIGINT FK (USERS.id) NULL ON DELETE CASCADE,
  ip_address VARCHAR(45) NULL,
  user_agent TEXT NULL,
  payload LONGTEXT NOT NULL,
  last_activity INT INDEXED NOT NULL
)
Indexes: user_id, last_activity
```

#### USER_PROVIDERS
```
USER_PROVIDERS (
  id BIGINT PK AUTO_INCREMENT,
  user_id BIGINT FK (USERS.id) NOT NULL ON DELETE CASCADE,
  provider VARCHAR(255) NOT NULL,
  provider_id VARCHAR(255) NOT NULL,
  avatar VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
Indexes: user_id, provider_id
```

#### ROLES
```
ROLES (
  id BIGINT PK AUTO_INCREMENT,
  name VARCHAR(125) UNIQUE NOT NULL,
  guard_name VARCHAR(125) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
Indexes: name, guard_name
```

#### PERMISSIONS
```
PERMISSIONS (
  id BIGINT PK AUTO_INCREMENT,
  name VARCHAR(125) UNIQUE NOT NULL,
  guard_name VARCHAR(125) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
Indexes: name, guard_name
```

#### MODEL_HAS_ROLES
```
MODEL_HAS_ROLES (
  role_id BIGINT FK (ROLES.id) NOT NULL ON DELETE CASCADE,
  model_type VARCHAR(255) NOT NULL,
  model_id BIGINT NOT NULL,
  PRIMARY KEY (role_id, model_type, model_id)
)
Indexes: role_id, model_id
```

#### MODEL_HAS_PERMISSIONS
```
MODEL_HAS_PERMISSIONS (
  permission_id BIGINT FK (PERMISSIONS.id) NOT NULL ON DELETE CASCADE,
  model_type VARCHAR(255) NOT NULL,
  model_id BIGINT NOT NULL,
  PRIMARY KEY (permission_id, model_type, model_id)
)
Indexes: permission_id, model_id
```

#### ROLE_HAS_PERMISSIONS
```
ROLE_HAS_PERMISSIONS (
  permission_id BIGINT FK (PERMISSIONS.id) NOT NULL ON DELETE CASCADE,
  role_id BIGINT FK (ROLES.id) NOT NULL ON DELETE CASCADE,
  PRIMARY KEY (permission_id, role_id)
)
Indexes: permission_id, role_id
```

#### MEDIA
```
MEDIA (
  id BIGINT PK AUTO_INCREMENT,
  model_type VARCHAR(255) NOT NULL,
  model_id BIGINT NOT NULL,
  uuid UUID UNIQUE NULL,
  collection_name VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  mime_type VARCHAR(255) NULL,
  disk VARCHAR(255) NOT NULL,
  conversions_disk VARCHAR(255) NULL,
  size BIGINT NOT NULL,
  manipulations JSON NOT NULL,
  custom_properties JSON NOT NULL,
  generated_conversions JSON NOT NULL,
  responsive_images JSON NOT NULL,
  order_column INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
Indexes: id, model_type, model_id, uuid, order_column
```

#### NOTIFICATIONS
```
NOTIFICATIONS (
  id UUID PK,
  type VARCHAR(255) NOT NULL,
  notifiable_type VARCHAR(255) NOT NULL,
  notifiable_id BIGINT NOT NULL,
  data TEXT NOT NULL,
  read_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
Indexes: id, notifiable_type, notifiable_id
```

---

## 3. Transformasi ERD ke LRS

### Aturan Transformasi

1. **Entitas → Tabel**: Setiap entitas dalam ERD menjadi satu tabel
2. **Atribut → Kolom**: Setiap atribut menjadi kolom dalam tabel
3. **Primary Key**: Dipertahankan sebagai constraint PK
4. **Relasi 1:N**: Foreign key ditempatkan di sisi N
5. **Relasi N:M**: Buat tabel junction/bridge
6. **Polymorphic**: Gunakan kombinasi type + id

### Contoh Transformasi

#### 1. Entitas menjadi Relasi

**ERD:**
```
[USERS] (id, name, email, password, ...)
```

**LRS:**
```
USERS (id, name, email, password, ...)
PK: id
```

#### 2. Relasi 1:N

**ERD:**
```
[USERS] -----(1:N)----- [SESSIONS]
```

**LRS:**
```
USERS (id, ...)
SESSIONS (id, user_id, ...) 
  FK: user_id → USERS.id
```

#### 3. Relasi N:M

**ERD:**
```
[USERS] -----(N:M)----- [ROLES]
```

**LRS:**
```
USERS (id, ...)
ROLES (id, ...)
MODEL_HAS_ROLES (user_id, role_id)
  FK: user_id → USERS.id
  FK: role_id → ROLES.id
  PK: (user_id, role_id)
```

#### 4. Atribut Multivalued (via N:M)

**ERD:**
```
[ROLES] -----(N:M)----- [PERMISSIONS]
```

**LRS:**
```
ROLES (id, name, ...)
PERMISSIONS (id, name, ...)
ROLE_HAS_PERMISSIONS (role_id, permission_id)
  FK: role_id → ROLES.id
  FK: permission_id → PERMISSIONS.id
```

#### 5. Relasi Polymorphic

**ERD:**
```
[MEDIA] -----(N:1)------ [MODEL: Users, Products, etc]
```

**LRS:**
```
MEDIA (
  id,
  model_type VARCHAR(255),  -- 'App\Models\User', 'App\Models\Product'
  model_id BIGINT,          -- ID dari model
  ...
)
```

---

## 4. Normalisasi

Database sudah dinormalisasi hingga **3rd Normal Form (3NF)**:

### 1st Normal Form (1NF)
- ✅ Setiap kolom atomic (indivisible)
- ✅ Tidak ada repeating groups
- ✅ Setiap tabel punya primary key

### 2nd Normal Form (2NF)
- ✅ Sudah 1NF
- ✅ Setiap non-key attribute bergantung penuh pada primary key
- ✅ Tidak ada partial dependency

### 3rd Normal Form (3NF)
- ✅ Sudah 2NF
- ✅ Tidak ada transitive dependency
- ✅ Setiap atribut bergantung hanya pada primary key

---

## 5. Foreign Key Constraints

| Tabel | FK Kolom | Referensi | ON DELETE |
|-------|----------|-----------|-----------|
| SESSIONS | user_id | USERS(id) | CASCADE |
| USER_PROVIDERS | user_id | USERS(id) | CASCADE |
| MODEL_HAS_ROLES | role_id | ROLES(id) | CASCADE |
| MODEL_HAS_PERMISSIONS | permission_id | PERMISSIONS(id) | CASCADE |
| ROLE_HAS_PERMISSIONS | permission_id | PERMISSIONS(id) | CASCADE |
| ROLE_HAS_PERMISSIONS | role_id | ROLES(id) | CASCADE |

---

## 6. Indexing Strategy

### Primary Keys (Auto-indexed)
- USERS.id
- SESSIONS.id
- ROLES.id
- PERMISSIONS.id
- MEDIA.id
- NOTIFICATIONS.id

### Foreign Keys (Must be indexed)
- SESSIONS.user_id
- USER_PROVIDERS.user_id
- MODEL_HAS_ROLES.role_id, model_id
- MODEL_HAS_PERMISSIONS.permission_id, model_id
- ROLE_HAS_PERMISSIONS.permission_id, role_id

### Search/Filter Columns
- USERS.email (UNIQUE)
- ROLES.name (UNIQUE)
- PERMISSIONS.name (UNIQUE)
- MEDIA.model_type, model_id
- NOTIFICATIONS.notifiable_type, notifiable_id

---

## 7. Data Integrity Rules

1. **Referential Integrity**: Foreign keys enforce data consistency
2. **Cascade Delete**: Menghapus parent otomatis menghapus child records
3. **Unique Constraints**: Email, role name, permission name tidak boleh duplikat
4. **NOT NULL Constraints**: Kolom critical harus memiliki nilai

---

## 8. File Dokumentasi

- **LaTeX**: `docs/DATABASE_DESIGN.tex` - Komprehensif dengan formatting
- **Markdown**: `docs/DATABASE_DESIGN.md` - Quick reference ini

## 9. File Gambar Diagram

- **Rancangan Tabel Basis Data**: `docs/rancangan_tabel_basis_data.svg`
- **ERD**: `docs/database_erd.svg`
- **Transformasi ERD ke LRS**: `docs/transformasi_erd_ke_lrs.svg`
- **Logical Record Structure (LRS)**: `docs/logical_record_structure_lrs.svg`
- **Sumber Mermaid**: `docs/database_erd.mmd`, `docs/transformasi_erd_ke_lrs.mmd`, `docs/logical_record_structure_lrs.mmd`
