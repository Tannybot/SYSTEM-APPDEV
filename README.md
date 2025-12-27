# ConsultEase


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
└── SQL_Database_edoc.sql # Database schema
```

## 🔧 Configuration Files

### php.ini
- Session path: `/tmp`
- Upload limits: 10MB
- Execution time: 300s


## 🐛 Troubleshooting

### Database Connection Issues
- Check `DATABASE_URL` in environment variables
- Verify database is linked to app

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

## 🔒 Security
- Environment variables for credentials
- Prepared statements for SQL queries
- Session-based authentication