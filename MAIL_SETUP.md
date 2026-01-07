# Email Configuration Setup Guide

## Environment Variables

Add the following variables to your `.env` file:

### For SMTP (Recommended for Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### For Gmail SMTP

1. Enable 2-Step Verification on your Google account
2. Generate an App Password:
   - Go to Google Account → Security → 2-Step Verification → App passwords
   - Generate a password for "Mail"
   - Use this password in `MAIL_PASSWORD`

### For Other SMTP Providers

**Mailtrap (Testing):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

**SendGrid:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

**Mailgun:**
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-secret
MAILGUN_ENDPOINT=api.mailgun.net
```

### For Development/Testing

**Log Driver (Emails saved to storage/logs/laravel.log):**
```env
MAIL_MAILER=log
```

**Array Driver (Emails stored in memory, not sent):**
```env
MAIL_MAILER=array
```

## Testing Email Configuration

After setting up your mail configuration, test it by:

1. Registering a new user account
2. Check your email inbox (or logs if using log driver)
3. Verify the email template displays correctly with logo and theme colors

## Troubleshooting

### Emails not sending:
- Check `.env` file has correct values
- Run `php artisan config:clear` after changing `.env`
- Verify SMTP credentials are correct
- Check spam/junk folder
- For Gmail: Make sure "Less secure app access" is enabled OR use App Password

### Logo not showing in email:
- Ensure `public/assets/logo.png` exists
- Use absolute URL in email template if needed
- Some email clients block images - this is normal

## Production Recommendations

1. Use a dedicated email service (SendGrid, Mailgun, SES)
2. Set up SPF and DKIM records for your domain
3. Monitor email delivery rates
4. Use queue for sending emails to avoid timeouts

