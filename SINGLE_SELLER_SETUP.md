# Single Seller Setup Guide

This application has been converted from a multi-vendor marketplace to a single-seller e-commerce website for **Shiivaraa Money Magnet Stones**.

## What Changed

### 1. Authentication System
- **Unified Login**: Single login form for both customers and admin/seller
- **Email-Based Role Detection**: Admin access is determined by matching the email in `.env` file
- **Removed Seller Registration**: No public seller registration - only one admin/seller account

### 2. Routes Simplified
- Removed all `/seller/*` routes
- Seller registration routes removed
- All seller functionality now accessible through `/admin/*` routes

### 3. Admin Dashboard
- Renamed "Users" to "Customers" in navigation
- Removed "Sellers" and "Payments" sections
- Added Quick Actions for common tasks
- Focused on single-seller operations

### 4. Navigation Updates
- Removed "Become a Seller" links from footer
- Removed seller dashboard links from mobile menu
- Simplified user account dropdown

## Setup Instructions

### Step 1: Configure Environment
Add the seller email to your `.env` file:

```env
SELLER_EMAIL=admin@shiivaraa.com
```

This email will have admin/seller access to the dashboard.

### Step 2: Run Database Migrations
```bash
php artisan migrate:fresh
```

### Step 3: Seed Admin User
```bash
php artisan db:seed --class=AdminUserSeeder
```

Or seed the entire database:
```bash
php artisan db:seed
```

### Step 4: Login Credentials
**Admin/Seller Account:**
- Email: `admin@shiivaraa.com` (or whatever you set in SELLER_EMAIL)
- Password: `password`

**Test Customer Account:**
- Email: `buyer@shopzone.com`
- Password: `password`

## How It Works

### Login Flow
1. User enters email and password
2. System checks if email matches `SELLER_EMAIL` from `.env` OR if user role is 'admin'
3. If match: Redirect to `/admin/dashboard`
4. If no match: Redirect to home page (customer login)

### Admin Access
- Only the user with email matching `SELLER_EMAIL` or role='admin' can access admin panel
- All product management, orders, categories, banners handled through admin panel
- No separate seller dashboard needed

### Customer Experience
- Customers register and login normally
- Can browse products, add to cart, checkout
- View their orders and profile
- No option to become a seller

## File Changes Summary

### Modified Files
- `app/Http/Controllers/Auth/AuthController.php` - Simplified login logic
- `routes/web.php` - Removed seller routes
- `resources/views/layouts/app.blade.php` - Removed seller links
- `.env.example` - Added SELLER_EMAIL configuration
- `database/seeders/DatabaseSeeder.php` - Updated to use AdminUserSeeder

### New Files
- `database/seeders/AdminUserSeeder.php` - Creates admin/seller user

### Removed Functionality
- Seller registration form and routes
- Seller dashboard routes
- Multi-vendor seller management
- Seller approval workflow (not needed for single seller)

## Production Deployment

1. Set `SELLER_EMAIL` in production `.env`
2. Change default password immediately after first login
3. Run migrations and seeders
4. Test login with both admin and customer accounts

## Security Notes

- Change the default password `password` immediately in production
- Keep `SELLER_EMAIL` secure and don't share it publicly
- Only one admin account should exist with this email
- Regular customers cannot access admin panel even if they know the URL

## Support

For issues or questions about the single-seller setup, refer to the Laravel documentation or contact the development team.
