<div align="center">

# 🏷️ Product Tag Manager

### A Laravel 12.x Backend Admin Module for Smart Product Tagging via Rule-Based Automation

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-CDN-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

<br/>

> **A practical Laravel backend module** that allows admins to manage products and define conditional rules that automatically tag products when all rule conditions are matched — no manual tagging required.

<br/>

![Project Banner](https://placehold.co/1200x400/1e3a5f/ffffff?text=Product+Tag+Manager+%7C+Laravel+12.x)

</div>

---

## 📋 Table of Contents

- [About the Project](#-about-the-project)
- [Task Description](#-task-description)
- [UI/UX Design Preview](#-uiux-design-preview)
- [Technologies Used](#-technologies-used)
- [Features & Functionalities](#-features--functionalities)
- [Rule Engine Logic](#-rule-engine-logic)
- [Database Schema](#-database-schema)
- [File Structure Overview](#-file-structure-overview)
- [Local Setup Guide](#-local-setup-guide)
- [Routes Reference](#-routes-reference)

---

## 🧾 About the Project

**Product Tag Manager** is a backend admin module built as part of a **Laravel Practical Task**. The module consists of two core entities:

| Entity | Purpose |
|---|---|
| **Product Manager** | Add, edit, delete, and list products with all relevant details |
| **Rule Manager** | Create conditional rules that auto-tag products when all conditions match |

The key concept is **rule-based automation**: an admin creates a rule with one or more conditions (e.g., `vendor == Supp.X` AND `price > 10`). When the admin clicks **Apply Rule**, the system scans all products, checks every condition for each product, and if **all conditions match**, it appends the rule's tags to that product automatically — without the admin manually tagging each product.

This project demonstrates:
- Full **CRUD** using Laravel Resource Controllers
- **Dynamic form rows** (add/remove conditions via JavaScript)
- **Quill.js** rich text editor for product descriptions
- **Image upload** using Laravel's Storage system
- **Rule engine** with multi-condition matching (`==`, `>`, `<`)
- Clean **Blade** templating with **TailwindCSS**

---

## 📄 Task Description

> **Module:** Product Tag Manager  
> **Program:** Laravel Practical

### Entity 1: Product Manager

1. In the backend, create a form to add product data manually.
2. The product form contains the following fields:

   | Field | Input Type |
   |---|---|
   | Product Name | Single input text |
   | Product Description | Rich Text Editor (Quill.js) |
   | Product Price | Decimal Number |
   | Product SKU | Single input text |
   | Product Qty | Number |
   | Product Type | Single input text |
   | Product Vendor | Single input text |
   | Product Image | Image upload |
   | Product Tags | **Non-editable field** (set by rules only) |

3. Show a list of added products in a table with the columns:  
   **Product Name · SKU · Price · Vendor · Type · Tags · Action (Edit & Delete)**

---

### Entity 2: Rule Manager

1. In the backend, create a rule form with the following fields:

   - **Rule Name** — single input text  
   - **Rule Conditions** — multiple conditions can be added:
     1. Choose **Product Selector** — dropdown: `Type`, `SKU`, `Vendor`, `Price`, `Qty`
     2. Choose **Operator** — dropdown: `==`, `>`, `<`
     3. Enter **Value** — text input
   - **Apply Tags** — single input text with comma-separated values

2. Show a list of created rules in a table with columns:  
   **Rule Name · Apply Tags · Action (Edit & Delete) · Action (Apply Rule)**

3. When admin clicks **Apply Rule**:
   - The system checks **all products** against **all conditions** of the rule
   - If **ALL conditions match** a product → the rule's tags are applied to that product
   - Tags are **merged** (no duplicates), comma-separated

---

## 🖥️ UI/UX Design Preview

The UI was wireframed on paper and then digitally proposed. Below is a description of each screen:

### Product Manager Screen
```
┌─────────────────────────────────────────────────────────────────┐
│  🏷️ Product Tag Manager          [Product Manager] [Rule Manager]│
├─────────────────────────────────────────────────────────────────┤
│  Product Manager                              [+ Add Product]    │
│ ┌────┬──────────────┬────────┬────────┬────────┬──────┬───────┐ │
│ │ #  │ Product Name │  SKU   │ Price  │ Vendor │ Type │ Tags  │ │
│ ├────┼──────────────┼────────┼────────┼────────┼──────┼───────┤ │
│ │ 1  │ Widget A     │ WA001  │ $15.00 │ Supp.X │Type1 │ tag1  │ │
│ │ 2  │ Widget B     │ WA002  │ $15.00 │ Supp.X │Type1 │ tag1  │ │
│ │ 3  │ Widget C     │ WA003  │ $30.00 │ Supp.X │Type1 │ tag1  │ │
│ └────┴──────────────┴────────┴────────┴────────┴──────┴───────┘ │
└─────────────────────────────────────────────────────────────────┘
```

### Product Form Screen
```
┌──────────────────────────────────────────┐
│  Add Product                             │
│                                          │
│  Product Name *                          │
│  ┌──────────────────────────────────┐    │
│  └──────────────────────────────────┘    │
│                                          │
│  Product Description                     │
│  ┌──────────────────────────────────┐    │
│  │ B I U S  </>  ≡  ≡              │    │
│  │                                  │    │
│  └──────────────────────────────────┘    │
│                                          │
│  Price *          SKU *                  │
│  ┌──────────┐     ┌──────────────┐       │
│  └──────────┘     └──────────────┘       │
│                                          │
│  Qty *            Type                   │
│  ┌──────────┐     ┌──────────────┐       │
│  └──────────┘     └──────────────┘       │
│                                          │
│  Vendor           Image Upload           │
│  ┌──────────┐     ┌──────────────┐       │
│  └──────────┘     │  📤 File     │       │
│                   └──────────────┘       │
│                                          │
│  Tags (non-editable)                     │
│  ┌──────────────────────────────────┐    │
│  │ tagA, tagB  [disabled]           │    │
│  └──────────────────────────────────┘    │
│                                          │
│  [      SUBMIT PRODUCT      ]            │
└──────────────────────────────────────────┘
```

### Rule Manager Screen
```
┌────────────────────────────────────────────────────────┐
│  Rule Manager                           [+ Add Rule]   │
│ ┌───────────────┬─────────────┬────────────┬─────────┐ │
│ │   Rule Name   │ Apply Tags  │ Edit/Delete│  Action │ │
│ ├───────────────┼─────────────┼────────────┼─────────┤ │
│ │ VIP Products  │ VIP, Gold   │ ✏️  🗑️     │[Apply]  │ │
│ │ Std Products  │ Std-A       │ ✏️  🗑️     │[Apply]  │ │
│ └───────────────┴─────────────┴────────────┴─────────┘ │
└────────────────────────────────────────────────────────┘
```

### Rule Form Screen
```
┌──────────────────────────────────────────────────────────┐
│  Create Rule                                             │
│                                                          │
│  Rule Name *                                             │
│  ┌────────────────────────────────────────────────┐      │
│  └────────────────────────────────────────────────┘      │
│                                                          │
│  Rule Conditions * (All conditions must match)           │
│  ┌─────────────────┬────────────┬───────────┬───┐        │
│  │ Choose Selector │  Operator  │   Value   │ × │        │
│  ├─────────────────┼────────────┼───────────┼───┤        │
│  │ [Type       ▾]  │ [==      ▾]│ [       ] │ × │        │
│  │ [Vendor     ▾]  │ [>       ▾]│ [       ] │ × │        │
│  └─────────────────┴────────────┴───────────┴───┘        │
│  [+ Add More Conditions]                                  │
│                                                          │
│  Apply Tags * (comma-separated)                          │
│  ┌────────────────────────────────────────────────┐      │
│  │ VIP, Gold, Premium                             │      │
│  └────────────────────────────────────────────────┘      │
│                                                          │
│  [            SAVE RULE            ]                     │
└──────────────────────────────────────────────────────────┘
```

---

## 🛠️ Technologies Used

| Technology | Version | Purpose |
|---|---|---|
| **PHP** | 8.2+ | Backend language |
| **Laravel** | 12.x | PHP framework (MVC, routing, ORM) |
| **MySQL** | 8.0+ | Relational database |
| **Eloquent ORM** | Laravel built-in | Database interaction |
| **Laravel Resource Controllers** | Laravel built-in | RESTful CRUD controllers |
| **Blade Templating Engine** | Laravel built-in | Server-side HTML views |
| **TailwindCSS** | CDN (v3.x) | Utility-first CSS styling |
| **Quill.js** | 1.3.7 (CDN) | Rich text editor for description |
| **Vanilla JavaScript** | ES6+ | Dynamic condition rows (add/remove) |
| **Laravel Storage** | Laravel built-in | Product image upload & retrieval |
| **Git** | 2.x | Version control |
| **GitHub** | — | Remote repository hosting |
| **Composer** | 2.x | PHP dependency manager |

---

## ✨ Features & Functionalities

### 🛍️ Product Manager

| Feature | Details |
|---|---|
| ➕ Add Product | Form with all 9 fields including image upload and Quill rich editor |
| ✏️ Edit Product | Pre-filled form; existing image preview with option to replace |
| 🗑️ Delete Product | Deletes record and removes image from storage |
| 📋 Product Listing | Paginated table (10/page) — Name, SKU, Price, Vendor, Type, Tags, Actions |
| 🏷️ Tags (non-editable) | Tags field is disabled in form — set only via Rule Manager |
| 📸 Image Upload | Stored in `storage/app/public/products`, served via symlink |
| 📝 Rich Text Description | Quill.js editor with bold, italic, underline, lists, code formatting |
| ✅ Form Validation | Server-side validation on all required fields; unique SKU check |
| 🔔 Flash Messages | Green success / Red error banners on all actions |

### 📏 Rule Manager

| Feature | Details |
|---|---|
| ➕ Create Rule | Rule name + multiple dynamic conditions + apply tags field |
| ✏️ Edit Rule | Existing conditions pre-loaded, fully editable, old ones replaced |
| 🗑️ Delete Rule | Deletes rule and all its associated conditions (cascadeOnDelete) |
| 📋 Rule Listing | Paginated table — Rule Name, Apply Tags (as pills), Edit/Delete, Apply Rule |
| ➕ Dynamic Conditions | Add/Remove condition rows dynamically in the browser without page reload |
| ⚡ Apply Rule Button | Triggers rule engine — tags matching products automatically |
| ✅ Form Validation | Server-side validation on all condition fields |

---

## ⚙️ Rule Engine Logic

This is the core intelligence of the module. When the admin clicks **"Apply Rule"** on any rule:

```
Admin clicks [Apply Rule]
       │
       ▼
POST /rules/{rule}/apply
       │
       ▼
Load Rule with all Conditions
       │
       ▼
Loop over every Product in the database
       │
       ├──► For each Product, check ALL conditions:
       │
       │        Condition: product.{selector} {operator} {value}
       │
       │        selector  → type | sku | vendor | price | qty
       │        operator  → ==   | >   | <
       │
       │        == : strtolower(actual) == strtolower(value)   [string/numeric]
       │        >  : (float) actual > (float) value            [numeric only]
       │        <  : (float) actual < (float) value            [numeric only]
       │
       │        If ANY condition fails → skip this product ✗
       │        If ALL conditions pass → proceed to tag ✓
       │
       ├──► Merge tags (no duplicates):
       │
       │        existing_tags = product.tags split by ','
       │        new_tags      = rule.apply_tags split by ','
       │        merged        = array_unique(existing + new)
       │        product.tags  = implode(', ', merged)
       │        product.save()
       │
       ▼
Redirect → Rule Manager with success message:
"Rule applied. Tags added to X product(s)."
```

### Example Scenario

**Products in DB:**

| Name | SKU | Price | Vendor | Type | Tags |
|---|---|---|---|---|---|
| Widget A | WA001 | 15.00 | Supp.X | Type1 | *(empty)* |
| Widget B | WA002 | 25.00 | Supp.X | Type1 | *(empty)* |
| Widget C | WA003 | 5.00 | Supp.Y | Type2 | *(empty)* |

**Rule: "High Value Supp.X"**
- Condition 1: `vendor == Supp.X`
- Condition 2: `price > 10`
- Apply Tags: `VIP, Premium`

**After clicking Apply Rule:**

| Name | Tags Applied? | Reason |
|---|---|---|
| Widget A | ✅ VIP, Premium | vendor==Supp.X ✓ AND price(15)>10 ✓ |
| Widget B | ✅ VIP, Premium | vendor==Supp.X ✓ AND price(25)>10 ✓ |
| Widget C | ❌ No change | vendor==Supp.Y ✗ (fails condition 1) |

---

## 🗄️ Database Schema

### `products` table

| Column | Type | Details |
|---|---|---|
| `id` | bigint (PK) | Auto-increment |
| `name` | varchar(255) | Required |
| `description` | longtext | HTML from Quill.js, nullable |
| `price` | decimal(10,2) | Required |
| `sku` | varchar(255) | Required, Unique |
| `qty` | unsigned int | Default: 0 |
| `type` | varchar(255) | Nullable |
| `vendor` | varchar(255) | Nullable |
| `image` | varchar(255) | Path in public disk, nullable |
| `tags` | varchar(255) | Comma-separated, set by rules only |
| `created_at` | timestamp | — |
| `updated_at` | timestamp | — |

### `rules` table

| Column | Type | Details |
|---|---|---|
| `id` | bigint (PK) | Auto-increment |
| `name` | varchar(255) | Required |
| `apply_tags` | varchar(255) | Comma-separated tag values |
| `created_at` | timestamp | — |
| `updated_at` | timestamp | — |

### `rule_conditions` table

| Column | Type | Details |
|---|---|---|
| `id` | bigint (PK) | Auto-increment |
| `rule_id` | bigint (FK) | References `rules.id` — cascadeOnDelete |
| `product_selector` | enum | `type`, `sku`, `vendor`, `price`, `qty` |
| `operator` | enum | `==`, `>`, `<` |
| `value` | varchar(255) | The value to compare against |
| `created_at` | timestamp | — |
| `updated_at` | timestamp | — |

### Entity Relationships

```
rules (1) ──────────── (many) rule_conditions
  │
  └── apply_tags applied to ──► products.tags  (when Apply Rule is triggered)
```

---

## 📁 File Structure Overview

```
product-tag-manager/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ProductController.php     ← Resource CRUD + image upload
│   │       └── RuleController.php        ← Resource CRUD + applyRule()
│   │
│   └── Models/
│       ├── Product.php                   ← Fillable fields
│       ├── Rule.php                      ← hasMany(RuleCondition)
│       └── RuleCondition.php             ← belongsTo(Rule)
│
├── database/
│   └── migrations/
│       ├── xxxx_create_products_table.php
│       ├── xxxx_create_rules_table.php
│       └── xxxx_create_rule_conditions_table.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             ← Master layout (nav, flash, TailwindCSS, Quill CDN)
│       │
│       ├── products/
│       │   ├── index.blade.php           ← Product listing table
│       │   ├── create.blade.php          ← Add product form
│       │   └── edit.blade.php            ← Edit product form
│       │
│       └── rules/
│           ├── index.blade.php           ← Rule listing table + Apply Rule button
│           ├── create.blade.php          ← Create rule form (dynamic conditions)
│           └── edit.blade.php            ← Edit rule form (pre-loaded conditions)
│
├── routes/
│   └── web.php                           ← Resource routes + custom apply route
│
├── storage/
│   └── app/
│       └── public/
│           └── products/                 ← Uploaded product images stored here
│
├── public/
│   └── storage → ../storage/app/public  ← Symlink (php artisan storage:link)
│
├── .env                                  ← Environment config (DB, APP_URL, etc.)
├── .env.example                          ← Template for .env
├── .gitignore                            ← Excludes vendor, .env, storage keys
├── composer.json                         ← PHP dependencies
└── README.md                             ← This file
```

---

## 🚀 Local Setup Guide

Follow these steps **exactly** to run the project on your local machine.

### ✅ Prerequisites

Make sure the following are installed on your system:

| Tool | Minimum Version | Check Command |
|---|---|---|
| PHP | 8.2+ | `php -v` |
| Composer | 2.x | `composer -V` |
| MySQL | 8.0+ | `mysql --version` |
| Git | 2.x | `git --version` |

---

### Step 1 — Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/product-tag-manager.git
cd product-tag-manager
```

---

### Step 2 — Install PHP Dependencies

```bash
composer install
```

---

### Step 3 — Copy Environment File

```bash
cp .env.example .env
```

---

### Step 4 — Configure `.env`

Open `.env` in your editor and update:

```env
APP_NAME="Product Tag Manager"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_tag_manager
DB_USERNAME=root
DB_PASSWORD=
```

---

### Step 5 — Create the Database

Open MySQL and run:

```sql
CREATE DATABASE product_tag_manager
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Or via terminal:

```bash
mysql -u root -p -e "CREATE DATABASE product_tag_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

### Step 6 — Generate Application Key

```bash
php artisan key:generate
```

---

### Step 7 — Run Migrations

```bash
php artisan migrate
```

You should see 3 tables created:
- `products`
- `rules`
- `rule_conditions`

---

### Step 8 — Create Storage Symlink

```bash
php artisan storage:link
```

This creates `public/storage` → `storage/app/public`, enabling image serving.

---

### Step 9 — Start the Development Server

```bash
php artisan serve
```

Open your browser and visit:

```
http://localhost:8000
```

You will be redirected to the **Product Manager** page automatically.

---

### ✅ Full Setup in One Block (copy-paste)

```bash
git clone https://github.com/YOUR_USERNAME/product-tag-manager.git
cd product-tag-manager
composer install
cp .env.example .env
# ↑ Edit .env with your DB credentials now
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

---

## 🗺️ Routes Reference

| Method | URI | Controller Action | Name | Description |
|---|---|---|---|---|
| GET | `/` | redirect | — | Redirects to products index |
| GET | `/products` | `ProductController@index` | `products.index` | List all products |
| GET | `/products/create` | `ProductController@create` | `products.create` | Show add product form |
| POST | `/products` | `ProductController@store` | `products.store` | Save new product |
| GET | `/products/{product}/edit` | `ProductController@edit` | `products.edit` | Show edit product form |
| PUT | `/products/{product}` | `ProductController@update` | `products.update` | Update product |
| DELETE | `/products/{product}` | `ProductController@destroy` | `products.destroy` | Delete product |
| GET | `/rules` | `RuleController@index` | `rules.index` | List all rules |
| GET | `/rules/create` | `RuleController@create` | `rules.create` | Show create rule form |
| POST | `/rules` | `RuleController@store` | `rules.store` | Save new rule |
| GET | `/rules/{rule}/edit` | `RuleController@edit` | `rules.edit` | Show edit rule form |
| PUT | `/rules/{rule}` | `RuleController@update` | `rules.update` | Update rule |
| DELETE | `/rules/{rule}` | `RuleController@destroy` | `rules.destroy` | Delete rule |
| POST | `/rules/{rule}/apply` | `RuleController@applyRule` | `rules.apply` | ⚡ Apply rule to all products |

---

<div align="center">

**Built with ❤️ using Laravel 12.x**

*Laravel Practical Task — Product Tag Manager*

</div>