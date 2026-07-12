# Perfect World Panel

A comprehensive game administration panel for managing Perfect World Online game servers.

## Features

### Admin Dashboard
- Real-time server statistics
- Account and character management
- Item distribution system
- Transaction tracking
- Player reports handling
- Game balance configuration
- System announcements

### Player Features
- Account management
- Character management
- Transaction history
- Report system
- Server status
- Announcements

## Technology Stack

### Backend
- **Framework**: Laravel 10
- **Database**: MySQL
- **Cache**: Redis
- **Authentication**: JWT
- **API**: RESTful API

### Frontend
- **Framework**: Vue.js 3
- **State Management**: Pinia
- **Styling**: Tailwind CSS
- **HTTP Client**: Axios
- **Build Tool**: Vite

## Installation

### Prerequisites
- PHP 8.2+
- Node.js 18+
- MySQL 8.0+
- Redis

### Backend Setup

```bash
# Clone the repository
git clone https://github.com/paidi123/perfect-world-panel.git
cd perfect-world-panel

# Install PHP dependencies
composer install

# Create environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Generate JWT secret
php artisan jwt:secret

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start the development server
php artisan serve
```

### Frontend Setup

```bash
# Install Node dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build
```

## API Documentation

### Authentication Endpoints

#### Register
```
POST /api/auth/register
Body: {
  "name": "string",
  "email": "string",
  "password": "string",
  "password_confirmation": "string"
}
```

#### Login
```
POST /api/auth/login
Body: {
  "email": "string",
  "password": "string"
}
```

#### Logout
```
POST /api/auth/logout
Headers: Authorization: Bearer {token}
```

### Admin Endpoints

#### Get Accounts
```
GET /api/admin/accounts?page=1&search=query
Headers: Authorization: Bearer {token}
```

#### Ban Account
```
POST /api/admin/accounts/{id}/ban
Headers: Authorization: Bearer {token}
Body: {
  "reason": "string",
  "until": "date"
}
```

#### Distribute Item
```
POST /api/admin/items/distribute
Headers: Authorization: Bearer {token}
Body: {
  "item_id": "integer",
  "character_id": "integer",
  "quantity": "integer",
  "reason": "string"
}
```

## Database Schema

### Accounts Table
- `id` - Primary key
- `user_id` - Foreign key to users
- `account_name` - Unique account name
- `account_status` - active, inactive, suspended
- `is_banned` - Boolean flag
- `ban_reason` - Reason for ban
- `ban_until` - Ban expiration date
- `last_login` - Last login timestamp

### Characters Table
- `id` - Primary key
- `account_id` - Foreign key to accounts
- `character_name` - Unique character name
- `level` - Character level (1-150)
- `class` - wizard, warrior, archer, cleric, assassin
- `faction` - human, tian, demon
- `experience` - Current experience
- `money` - In-game currency
- `yuanBao` - Premium currency
- `boundYuanBao` - Bound premium currency
- `status` - online, offline
- `play_time` - Total playtime in hours

## Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthenticationTest.php

# Run with coverage
php artisan test --coverage
```

## Security

- JWT token-based authentication
- Role-based access control (RBAC)
- Input validation and sanitization
- SQL injection prevention via Eloquent ORM
- CORS configuration
- Rate limiting
- Activity logging

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@perfectworldpanel.com or open an issue on GitHub.

## Roadmap

- [ ] Guild management system
- [ ] PvP arena rankings
- [ ] Marketplace integration
- [ ] In-game shop management
- [ ] Event scheduling system
- [ ] Advanced analytics
- [ ] Mobile app
- [ ] WebSocket support for real-time updates
