# Quick Start Guide - Shiivaraa Single Seller

## 🚀 Quick Setup (3 Steps)

### 1. Configure Environment
```bash
# Add to .env file (already done)
SELLER_EMAIL=admin@shiivaraa.com
```

### 2. Setup Database
```bash
# Fresh migration (if needed)
php artisan migrate:fresh

# Seed admin user
php artisan db:seed --class=AdminUserSeeder

# Or seed everything
php artisan db:seed
```

### 3. Login
- **Admin**: Go to `/login`, use `admin@shiivaraa.com` / `password`
- **Customer**: Register at `/register` or use test account `buyer@shopzone.com` / `password`

## 🎯 Key Features

### Single Seller Model
- ✅ One admin/seller account (configured via SELLER_EMAIL)
- ✅ Unified login form for admin and customers
- ✅ No public seller registration
- ✅ All management through admin dashboard

### Admin Dashboard (`/admin/dashboard`)
- Manage Products
- Manage Categories
- Manage Orders
- Manage Banners
- View Customers
- Site Settings
- Reports

### Customer Features
- Browse money magnet stones
- Add to cart & checkout
- Wishlist functionality
- Order tracking
- Profile management

## 📋 Default Credentials

| Role | Email | Password | Access |
|------|-------|----------|--------|
| Admin/Seller | admin@shiivaraa.com | password | /admin/dashboard |
| Test Customer | buyer@shopzone.com | password | Customer features |

⚠️ **Change passwords in production!**

## 🔧 Common Commands

```bash
# Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Create admin user
php artisan db:seed --class=AdminUserSeeder

# Check routes
php artisan route:list

# Run development server
php artisan serve
```

## 📁 Important Files

- **Login Logic**: `app/Http/Controllers/Auth/AuthController.php`
- **Routes**: `routes/web.php`
- **Admin Dashboard**: `resources/views/admin/dashboard.blade.php`
- **Home Page**: `resources/views/home.blade.php`
- **Config**: `.env` (SELLER_EMAIL)

## 🎨 Branding

- **Website Name**: Shiivaraa
- **Tagline**: Money Magnet Stones
- **Theme**: Amber/Gold (#d97706, #fbbf24, #f59e0b)
- **Logo**: Animated shimmer effect

## 🔐 Security Notes

1. Change default password immediately
2. Keep SELLER_EMAIL secure
3. Only one admin account
4. Admin routes protected by middleware
5. Customers cannot access admin panel

## 📚 Documentation

- `SINGLE_SELLER_SETUP.md` - Detailed setup guide
- `IMPLEMENTATION_SUMMARY.md` - Complete change log
- `QUICK_START.md` - This file

## ✅ Verification Checklist

- [ ] SELLER_EMAIL set in .env
- [ ] Admin user created via seeder
- [ ] Can login as admin
- [ ] Can login as customer
- [ ] Admin dashboard accessible
- [ ] No seller registration links visible
- [ ] Products display correctly
- [ ] Cart and checkout working

## 🆘 Troubleshooting

**Can't access admin dashboard?**
- Check SELLER_EMAIL matches your login email
- Verify user role is 'admin' in database
- Clear cache: `php artisan cache:clear`

**Seller registration still showing?**
- Clear views: `php artisan view:clear`
- Check routes: `php artisan route:list --path=seller`

**Login not working?**
- Verify database connection
- Check user exists: `php artisan tinker` → `User::where('email', 'admin@shiivaraa.com')->first()`
- Reset password if needed

## 🎉 You're Ready!

Your single-seller Shiivaraa Money Magnet Stones website is ready to use. Login as admin to start adding products and managing your store!
