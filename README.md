# Perfect World Private Server Panel 🎮

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat-square)](https://vuejs.org)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

Full-featured Laravel-based administration panel untuk Perfect World Private Servers dengan support untuk 500+ concurrent users.

## 🌟 Fitur Utama

### Manajemen Akun & Karakter
- ✅ User Account Management (Create, Edit, Delete, Ban/Unban)
- ✅ Character Management & Statistics
- ✅ Account Security (2FA, IP Whitelist)
- ✅ Account Recovery System
- ✅ Multi-character support

### Manajemen Item & Currency
- ✅ Currency Management System
- ✅ Item Management & Distribution
- ✅ Item Generator dengan quantity control
- ✅ Inventory tracking
- ✅ Item history & audit log

### Admin Dashboard
- ✅ GM/Admin Panel dengan Role-Based Access Control
- ✅ Server Statistics & Analytics Dashboard
- ✅ Real-time player monitoring
- ✅ Activity Logs & Audit Trail
- ✅ Performance metrics

### Server Management
- ✅ Server Configuration Management
- ✅ Game Balance Configuration (Drop rates, EXP rates, etc.)
- ✅ NPC & Monster Management
- ✅ Event Management System
- ✅ Scheduled Events & Maintenance

### Finance & Reports
- ✅ Income & Revenue Reports
- ✅ Payment Gateway Integration (iPaymu, Midtrans)
- ✅ Transaction History
- ✅ Financial Analytics
- ✅ Refund Management

### Security & Monitoring
- ✅ Anti-Cheat & Violation Reports
- ✅ Player Behavior Analysis
- ✅ Login attempt tracking
- ✅ IP blocking & whitelist
- ✅ Security audit logs

### Website Integration
- ✅ News & Announcements System
- ✅ Patch Notes Management
- ✅ Website Database Synchronization
- ✅ Forum Integration
- ✅ Email Notifications

### Communication
- ✅ In-Game Mail System
- ✅ Bulk messaging
- ✅ Notification system
- ✅ Email templates

### UI/UX
- ✅ Responsive Mobile-Friendly Dashboard
- ✅ Dark/Light mode support
- ✅ Real-time notifications
- ✅ Advanced data tables
- ✅ Export to Excel/PDF

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 10.x, PHP 8.2+ |
| **Frontend** | Vue.js 3, Tailwind CSS, Alpine.js |
| **Database** | MySQL 8.0 / MariaDB 10.6+ |
| **API** | RESTful API dengan JWT Authentication |
| **Caching** | Redis (optional) |
| **Queue** | Redis / Database Queue |
| **Real-time** | WebSocket (Laravel Echo) |
| **File Storage** | Local / AWS S3 |

## 📁 Struktur Project

```
perfect-world-panel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           (Admin controllers)
│   │   │   ├── Player/          (Player controllers)
│   │   │   ├── API/             (API controllers)
│   │   │   └── Auth/            (Authentication)
│   │   ├── Middleware/
│   │   └── Requests/            (Form validation)
│   ├── Models/                  (Database models)
│   ├── Services/                (Business logic)
│   ├── Jobs/                    (Queue jobs)
│   ├── Events/                  (Event handlers)
│   └── Traits/                  (Reusable traits)
├── database/
│   ├── migrations/              (Database schema)
│   ├── seeders/                 (Data seeders)
│   └── factories/               (Model factories)
├── resources/
│   ├── js/
│   │   ├── components/          (Vue components)
│   │   ├── pages/               (Pages)
│   │   ├── stores/              (Pinia stores)
│   │   └── App.vue
│   ├── views/                   (Blade templates)
│   └── css/                     (Tailwind CSS)
├── routes/
│   ├── api.php
│   ├── web.php
│   └── admin.php
├── config/
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   └── ...
├── storage/
├── tests/
└── ...
```

## 🚀 Instalasi

### Requirements
- PHP 8.2+
- MySQL 8.0+ atau MariaDB 10.6+
- Composer
- Node.js 18+
- Redis (optional)

### Setup

```bash
# 1. Clone repository
git clone https://github.com/paidi123/perfect-world-panel.git
cd perfect-world-panel

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database configuration
# Edit .env dan set database credentials

# 5. Database migration
php artisan migrate
php artisan db:seed

# 6. Build assets
npm run dev      # Development
npm run build    # Production

# 7. Start server
php artisan serve

# Akses: http://localhost:8000
```

## 📖 Dokumentasi

Untuk dokumentasi lengkap, lihat [DOCUMENTATION.md](./DOCUMENTATION.md)

### Quick Links
- [Installation Guide](./docs/INSTALLATION.md)
- [Configuration](./docs/CONFIGURATION.md)
- [API Documentation](./docs/API.md)
- [Database Schema](./docs/DATABASE.md)
- [Contributing Guide](./CONTRIBUTING.md)

## 🔧 Konfigurasi

### Database Connection

```env
# Panel Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pw_panel
DB_USERNAME=root
DB_PASSWORD=

# Game Database (connection terpisah)
GAME_DB_HOST=127.0.0.1
GAME_DB_DATABASE=pw_game
```

### Payment Gateway

```env
# iPaymu
IPAYMU_VA=YOUR_VA
IPAYMU_API_KEY=YOUR_API_KEY
IPAYMU_SIGNATURE_KEY=YOUR_SIGNATURE

# Midtrans
MIDTRANS_SERVER_KEY=YOUR_SERVER_KEY
MIDTRANS_CLIENT_KEY=YOUR_CLIENT_KEY
MIDTRANS_IS_PRODUCTION=false
```

## 📝 Default Account

Setelah migration & seeding:

```
Email: admin@example.com
Password: password
Role: Super Admin
```

**⚠️ PENTING: Ubah password ini setelah login pertama!**

## 🔐 Security Features

- JWT Token Authentication
- Role-Based Access Control (RBAC)
- Two-Factor Authentication (2FA)
- CORS Protection
- CSRF Token Validation
- SQL Injection Prevention
- XSS Protection
- Rate Limiting
- IP Whitelisting
- Activity Logging

## 📊 API Endpoints

### Authentication
```
POST   /api/auth/login
POST   /api/auth/logout
POST   /api/auth/refresh
GET    /api/auth/me
```

### Users
```
GET    /api/users
GET    /api/users/{id}
POST   /api/users
PUT    /api/users/{id}
DELETE /api/users/{id}
```

### Characters
```
GET    /api/characters
GET    /api/characters/{id}
POST   /api/characters
PUT    /api/characters/{id}
```

Untuk dokumentasi API lengkap: [API Documentation](./docs/API.md)

## 🤝 Contributing

Kontribusi sangat diterima! Silakan baca [CONTRIBUTING.md](./CONTRIBUTING.md) untuk detailnya.

## 📄 License

Proyek ini dilisensikan di bawah MIT License - lihat [LICENSE](./LICENSE) file untuk detailnya.

## 👨‍💻 Author

- **Paidi123** - Initial work - [GitHub](https://github.com/paidi123)

Based on structure dari [@hrace009](https://github.com/hrace009) PW Panel examples.

## 📞 Support

Untuk pertanyaan atau masalah:
- Buka issue di [GitHub Issues](https://github.com/paidi123/perfect-world-panel/issues)
- Email: your-email@example.com

## 🙏 Terima Kasih

Terima kasih kepada:
- [Laravel Framework](https://laravel.com)
- [Vue.js](https://vuejs.org)
- [Tailwind CSS](https://tailwindcss.com)
- Community Perfect World Private Server
