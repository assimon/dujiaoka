# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**DuJiaoKa (独角数卡)** is a Laravel 6.x-based automated digital goods sales platform designed for selling digital products like cards, keys, and licenses with automated fulfillment.

**Technology Stack:**
- Laravel 6.20.26+ (PHP 7.4+ / 8.0+)
- MySQL 5.6+
- Redis (caching & queues)
- Dcat Admin 2.x (admin dashboard)
- Nginx 1.16+
- Supervisor (process management)

**Key Features:**
- 11+ payment gateway integrations (Alipay, WeChat, PayPal, Stripe, Coinbase, USDT, etc.)
- Auto/manual delivery system
- Queue-based order fulfillment
- Multi-theme support (unicorn, luna, hyper)
- Admin dashboard for managing products, orders, coupons, and system configuration

## Development Commands

### Setup & Dependencies
```bash
composer install              # Install PHP dependencies
npm install                   # Install frontend dependencies
php artisan key:generate      # Generate application encryption key
php artisan migrate           # Run database migrations
```

### Asset Compilation
```bash
npm run dev                   # Build assets for development
npm run watch                 # Watch for changes and rebuild automatically
npm run prod                  # Build optimized production assets
```

### Testing
```bash
php vendor/bin/phpunit                    # Run all tests
php vendor/bin/phpunit --filter=TestName  # Run specific test
```

### Docker
```bash
docker-compose up             # Start application stack
docker-compose build          # Build Docker image
docker-compose down           # Stop containers
```

### Laravel Utilities
```bash
php artisan cache:clear       # Clear application cache
php artisan config:cache      # Cache configuration files
php artisan queue:work        # Start queue worker (CRITICAL for order fulfillment)
php artisan tinker            # Interactive PHP shell
```

## Architecture Overview

### Application Flow
```
User Request
    ↓
Frontend (routes/common/web.php)
    ↓
Controllers (app/Http/Controllers/Home/)
    ↓
Services (app/Service/)
    ↓
Models (app/Models/)
```

### Key Architectural Patterns

**Service Layer Pattern**: Business logic isolated in dedicated service classes
- Controllers delegate to services for business operations
- Services handle validation, calculations, and coordination

**Queue/Job Pattern**: Async processing via Laravel Queue
- Background jobs for emails, notifications, API hooks
- Managed by Supervisor in production

**Event-Driven**: Model events trigger cascading operations
- OrderUpdated, GoodsDeleted events
- Listeners respond to model changes

**Repository Pattern**: Admin panel uses repositories for data abstraction

### Core Services (app/Service/)

**OrderProcessService.php** - CRITICAL service that orchestrates the entire order fulfillment workflow:
- Validates and creates orders
- Applies coupons and calculates pricing
- Coordinates order completion (payment → delivery → notifications)
- Enqueues background jobs for async processing
- Handles carmis (digital key) delivery

**Other Key Services:**
- **OrderService.php** - Order validation, search by order SN/email/browser fingerprint
- **GoodsService.php** - Product management, availability checks, wholesale pricing
- **PayService.php** - Payment gateway configuration loading
- **CouponService.php** - Discount code validation and usage tracking
- **CarmisService.php** - Digital key inventory management, mark as sold
- **EmailtplService.php** - Email template handling and variable replacement

### Payment Gateway Architecture

All payment controllers in [app/Http/Controllers/Pay/](app/Http/Controllers/Pay/) implement:
- `gateway($payway, $orderSN)` - Initialize payment session & redirect to payment provider
- `notifyUrl()` - Async webhook handler from payment provider (includes signature verification)
- `returnUrl()` - Optional sync return handler

**Supported Payment Gateways:**
Alipay (Face-to-Face, PC, Mobile), WeChat Pay, PayJS, Paysapi, Ma Pay, Yi Pay, PayPal, V Free Sign, Stripe, Coinbase, USDT (epusdt), Token Pay

### Order Status Flow

```
WAIT_PAY (1)     → Order created, waiting for payment
PENDING (2)      → Payment received, pending processing
PROCESSING (3)   → Order being processed
COMPLETED (4)    → Order completed & delivered
    ↓
    Triggers background jobs:
    - MailSend (order confirmation email)
    - ApiHook (external webhooks)
    - TelegramPush, ServerJiang, BarkPush, WorkWeiXinPush (notifications)

FAILURE (5)      → Order failed
ABNORMAL (6)     → Abnormal state
EXPIRED (-1)     → Payment timeout
```

When order completes, [OrderProcessService.php:completedOrder()](app/Service/OrderProcessService.php) handles:
1. Update order status to COMPLETED
2. Deliver carmis (if auto delivery)
3. Send email notification
4. Fire API hooks to external systems
5. Send push notifications
6. Mark coupon as used

### Background Jobs (app/Jobs/)

Enqueued from OrderProcessService on order events:
- **MailSend** - Send order emails using templates from emailtpls table
- **ApiHook** - POST order data to configured webhook URLs
- **TelegramPush**, **ServerJiang**, **BarkPush**, **WorkWeiXinPush** - Various notification services
- **OrderExpired** - Background job to expire unpaid orders
- **CouponBack** - Refund coupon usage when order fails

**IMPORTANT**: Queue worker must be running in production for order fulfillment to work:
```bash
php artisan queue:work
```
Typically managed by Supervisor.

### Admin Dashboard

Built with Dcat Admin 2.x framework:
- **Path**: `/admin`
- **Default Credentials**: admin/admin (CHANGE IN PRODUCTION)
- **Controllers**: [app/Admin/Controllers/](app/Admin/Controllers/)
- **Actions**: [app/Admin/Actions/](app/Admin/Actions/) - Batch operations, restore deleted records
- **Repositories**: [app/Admin/Repositories/](app/Admin/Repositories/) - Data layer abstraction

**Admin Features:**
- Orders management with soft delete restoration
- Products (Goods) CRUD with categories (GoodsGroup)
- Carmis (digital keys) bulk import via Excel
- Coupons/discount codes
- Payment gateway configuration
- Email templates editor
- System settings (cached in Redis)

### Database Models (app/Models/)

**Order** - Customer orders
- 6 status states (WAIT_PAY → PENDING/PROCESSING → COMPLETED/FAILURE/ABNORMAL/EXPIRED)
- Soft deletes enabled
- Relationships: belongsTo Goods, Coupon, Pay

**Goods** - Products/services
- Type: AUTO_DELIVERY (carmis delivered automatically) or MANUAL_PROCESSING (admin fulfillment)
- Relationships: belongsTo GoodsGroup, hasMany Carmis, belongsToMany Coupons

**Carmis** - Digital keys/cards inventory
- Status: UNSOLD (1) or SOLD (2)
- `is_loop` flag for reusable keys
- Soft deletes enabled

**Coupon** - Discount codes
- Type: ONE_TIME (1) or REPEAT (2)
- Status: UNUSED (1) or USE (2)
- `ret` field tracks remaining uses

**Pay** - Payment gateway configurations
- `pay_handleroute` - Controller route (e.g., '/pay/alipay')
- `pay_client` - PC (1), MOBILE (2), or ALL (3)
- Stores merchant_id, merchant_key, merchant_pem credentials

**Key Relationships:**
```
Order → Goods (belongsTo)
Order → Coupon (belongsTo)
Order → Pay (belongsTo)
Goods → GoodsGroup (belongsTo)
Goods → Carmis (hasMany)
Goods ↔ Coupons (belongsToMany via coupons_goods pivot)
```

## Important Configurations

### Environment Requirements

**PHP 7.4 Requirements:**
- PHP-CLI version MUST match web PHP version
- Required extensions: `fileinfo`, `redis`
- Required functions (check php.ini): `putenv`, `proc_open`, `pcntl_signal`, `pcntl_alarm`

**Infrastructure:**
- MySQL 5.6+ (or MariaDB equivalent)
- Redis (for caching system settings and queue management)
- Supervisor (manages queue worker processes)
- Nginx 1.16+ with proper configuration
- Composer (PHP package manager)

### System Configuration

System settings are stored in database and cached in Redis:
- **Cache Key**: `'system-setting'`
- **Helper Function**: `dujiaoka_config_get($key)` - Retrieves cached config values
- **Admin UI**: Configure via [SystemSettingController](app/Admin/Controllers/SystemSettingController.php) at `/admin/system-setting`

### Frontend Templates

Located in [resources/views/](resources/views/) with three themes:
- **unicorn/** - Official default theme
- **luna/** - By contributor Julyssn
- **hyper/** - By contributor bimoe

## Key Routes & Entry Points

### Frontend Routes ([routes/common/web.php](routes/common/web.php))

```
GET  /                              → Homepage with product catalog
GET  /buy/{id}                      → Product detail page
POST /create-order                  → Create new order
GET  /bill/{orderSN}                → Checkout/payment page
GET  /detail-order-sn/{orderSN}     → Order detail view
GET  /order-search                  → Order search form
GET  /check-order-status/{orderSN}  → AJAX status check
POST /search-order-by-sn            → Search by order number
POST /search-order-by-email         → Search by email
POST /search-order-by-browser       → Search by browser fingerprint
```

### Payment Routes ([routes/common/pay.php](routes/common/pay.php))

```
GET  /pay-gateway/{handle}/{payway}/{orderSN}  → Main payment router

Per-Gateway Routes:
/pay/{gateway}/{payway}/{orderSN}              → Gateway payment page
POST /pay/{gateway}/notify_url                 → Async webhook from provider
GET  /pay/{gateway}/return_url                 → Sync return from provider
```

### Admin Routes

Auto-generated by Dcat Admin framework, accessible at `/admin` namespace.

## Important Middleware ([app/Http/Middleware/](app/Http/Middleware/))

**DujiaoBoot** - PRE-ROUTE middleware that:
- Loads system configuration from Redis cache
- Loads email templates into memory
- Critical for application initialization

**PayGateWay** - Validates payment gateway requests

**InstallCheck** - Enforces installation completion before allowing access

## Deployment Notes

### Supported Platforms
- **Linux** (recommended) - See [debian_manual.md](debian_manual.md) for detailed LNMP setup
- **Docker** - Use provided [docker-compose.yml](docker-compose.yml) and [Dockerfile](Dockerfile)
- **Baota Panel** - One-click panel installation supported
- **Windows** - NOT officially supported

### Production Deployment Checklist

1. Ensure Redis is running and accessible
2. Configure and start Supervisor to manage queue workers
3. Configure Nginx with web root pointing to `/public` directory
4. Set proper file permissions (www-data or nginx user)
5. Run `composer install --optimize-autoloader --no-dev`
6. Run `npm run prod` to build optimized production assets
7. Configure `.env` file with database, Redis, and payment gateway credentials
8. Run `php artisan migrate` for initial database schema
9. Configure queue worker in Supervisor config
10. Change default admin credentials immediately

### Queue Worker Configuration (Supervisor)

Example supervisor configuration:
```ini
[program:dujiaoka-worker]
command=php /path/to/artisan queue:work --sleep=3 --tries=3
directory=/path/to/project
user=www-data
autostart=true
autorestart=true
```

### Default Admin Access

- **URL**: `/admin`
- **Username**: `admin`
- **Password**: `admin`
- **CRITICAL**: Change these credentials immediately in production!

## Helper Functions

Global helpers available via [app/Helpers/functions.php](app/Helpers/functions.php):
- `dujiaoka_config_get($key)` - Get cached system configuration value
- `replace_mail_tpl($tpl, $order)` - Replace email template variables with order data
- `format_wholesale_price($text)` - Parse wholesale pricing structure
- `delete_html_code($str)` - Sanitize HTML from user input

## Testing

- **Test Suites**: Unit tests ([tests/Unit/](tests/Unit/)), Feature tests ([tests/Feature/](tests/Feature/))
- **Configuration**: [phpunit.xml](phpunit.xml)
- **Test Database**: In-memory SQLite (configured in phpunit.xml)
- **Environment**: APP_ENV=testing with array cache/session drivers

## Code Style

- Follows Laravel coding conventions
- StyleCI configured ([.styleci.yml](.styleci.yml)) with Laravel preset
- PSR-2 compliant with Laravel-specific adjustments
