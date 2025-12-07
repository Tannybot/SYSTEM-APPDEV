# ConsultEase - Railway Deployment Guide

## 🚀 Quick Deploy to Railway

### Prerequisites
- Railway account
- Git repository

### Steps

1. **Create Railway Project**
   ```bash
   railway login
   railway init
   ```

2. **Add MySQL Database**
   ```bash
   railway add mysql
   ```

3. **Deploy**
   ```bash
   git add .
   git commit -m "Railway deployment"
   git push railway main
   ```

4. **Setup Database**
   - Go to Railway dashboard
   - Open database console
   - Run the contents of `SQL_Database_edoc.sql`

5. **Environment Variables**
   Railway automatically sets `DATABASE_URL`. Verify in dashboard.

## 📁 File Structure
```
/ (project root)
├── admin/          # Admin pages
├── faculty/        # Faculty pages
├── student/        # Student pages
├── css/           # Stylesheets
├── connection.php # Database config
├── login.php      # Login page
├── php.ini        # PHP config
├── railway.toml   # Railway config
└── SQL_Database_edoc.sql # Database schema
```

## 🔧 Configuration Files

### php.ini
- Session path: `/tmp`
- Upload limits: 10MB
- Execution time: 300s

### railway.toml
- Builder: NIXPACKS
- Start command: PHP built-in server
- Health check: `/`

## 🐛 Troubleshooting

### Database Connection Issues
- Check `DATABASE_URL` in Railway variables
- Verify database is linked to app
- Check Railway logs: `railway logs`

### Session Errors
- Ensure `php.ini` is in project root
- Check session.save_path is `/tmp`

### Email Issues
- EmailJS works client-side
- Check console for EmailJS errors
- Verify EmailJS service/template IDs

## 📧 Features
- ✅ User authentication (Student/Faculty/Admin)
- ✅ Appointment booking & management
- ✅ Email notifications via EmailJS
- ✅ Dark green sidebar with hover effects
- ✅ Railway-compatible database connection

## 🔒 Security
- Environment variables for credentials
- Prepared statements for SQL queries
- Session-based authentication