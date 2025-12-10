# Wati WhatsApp Integration Setup

This document explains how to configure Wati API for sending WhatsApp messages with PDF attachments.

## Configuration

You need to configure Wati API credentials in your application. You can do this in two ways:

### Option 1: Environment Variables (Recommended)

Add the following variables to your `.env` file:

```env
WATI_API_ENDPOINT=https://api.wati.io
WATI_API_TOKEN=your_api_token_here
WATI_WHATSAPP_NUMBER=your_whatsapp_number
```

### Option 2: Database Settings

You can also store Wati settings in the database using the Settings model:

```php
Setting::set('wati_api_endpoint', 'https://api.wati.io', 'string', 'Wati API endpoint');
Setting::set('wati_api_token', 'your_api_token_here', 'string', 'Wati API token');
Setting::set('wati_whatsapp_number', 'your_whatsapp_number', 'string', 'Wati WhatsApp number');
```

## Getting Wati API Credentials

### Method 1: Through Dashboard

1. Sign up for a Wati account at https://wati.io
2. Log into your Wati dashboard at https://app.wati.io
3. **IMPORTANT: Connect your WhatsApp number first**
   - If you see a banner saying "To experience WhatsApp Messaging, please connect your WhatsApp number"
   - Click the **"Connect Now"** button
   - Follow the on-screen instructions to connect your WhatsApp Business number
   - This step is required before API settings become available
4. After connecting your WhatsApp number, look for API settings in one of these locations:
   - **Settings** → **API & Webhooks** (if available)
   - **Settings** → **Integration** → **API**
   - **Developer** or **Developers** menu
   - **Integration** menu (in sidebar or top navigation)
   - **Account Settings** → **API**
   - Profile/Account dropdown → **API Settings**

5. If you can't find API settings:
   - **Ensure your WhatsApp number is connected first** (see step 3 above)
   - Check your user permissions (admin/owner access may be required)
   - Try accessing directly: `https://app.wati.io/settings/api` or `https://app.wati.io/integration/api`
   - Contact Wati support through the dashboard help/support section

6. Once in API settings:
   - Generate or copy your API token
   - Note your API endpoint URL (usually `https://api.wati.io` or `https://api.wati.io/v1`)
   - Note your WhatsApp Business number registered with Wati

### Method 2: Direct API Documentation

If you cannot access API settings through the dashboard:

1. **Visit Wati API Documentation directly:**
   - API Documentation: https://docs.wati.io/api-reference
   - Or: https://support.wati.io/en-US/article/193-api-setup

2. **Check your account email** - Wati may have sent API credentials during signup

3. **Contact Wati Support:**
   - Use the help/support option in your dashboard
   - Email: support@wati.io
   - Request: "I need help accessing my API token and credentials"

### Important Notes

- Your API endpoint is typically: `https://api.wati.io` (or `https://api.wati.io/v1` for newer accounts)
- The API token is a long alphanumeric string that acts as authentication
- Keep your API token secure and never share it publicly
- Your WhatsApp Business number is the phone number you registered with Wati (format: country code + number, e.g., `919876543210`)

## How It Works

When a doctor clicks the "WhatsApp" button on the appointment summary page:

1. The system prompts for the patient's phone number
2. A WhatsApp message is generated with:
   - Patient name
   - Doctor name
   - Hospital name
   - Appointment date and time
   - Portal name (from settings)
3. The appointment summary PDF is generated
4. Both the message and PDF are sent to the patient's WhatsApp number via Wati API

## Message Template

The WhatsApp message follows this format:

```
Hello {patient_name},

Here's a summary of your appointment with Dr. {doctor_name}
Hospital: {hospital_name}
Appointment Date And Time: {appointment_date_time}

Download your summary here: [PDF attached]

Stay healthy,
Team {portal_name}
```

## Testing

To test the integration:

1. Ensure Wati credentials are configured
2. Navigate to any appointment summary page
3. Click the "WhatsApp" button
4. Enter a test phone number (10 digits)
5. The message and PDF should be sent via Wati

## Troubleshooting

### Cannot Find API Settings in Dashboard

- **Connect WhatsApp number first**: You must connect your WhatsApp Business number before API settings become available. Look for the "Connect Now" button on the dashboard
- **Check user role**: API settings may only be visible to account owners/admins
- **Look in different menus**: Wati interface varies - check sidebar, top menu, account dropdown
- **Try direct URLs**:
  - `https://app.wati.io/settings/api`
  - `https://app.wati.io/integration/api`
  - `https://app.wati.io/developer`
- **Check Wati documentation**: https://docs.wati.io/api-reference
- **Contact Wati support**: support@wati.io or use help chat in dashboard
- **Check your email**: API credentials may have been sent during account setup

### "WhatsApp service is not configured"

- Check that `WATI_API_ENDPOINT` and `WATI_API_TOKEN` are set in `.env` or database
- Verify the settings using `Setting::get('wati_api_endpoint')` and `Setting::get('wati_api_token')`

### "Failed to send message"

- Verify your Wati API token is valid
- Check that your WhatsApp Business number is active
- Ensure the recipient phone number is in international format (without +)
- Check application logs at `storage/logs/laravel.log` for detailed error messages

### PDF not attaching

- Verify PDF generation is working (test the "Generate PDF" button first)
- Check file permissions on `storage/app/temp/` directory
- Review Wati API response in application logs

## API Endpoints Used

- **Send Message**: `POST {api_endpoint}/api/v1/sendSessionMessage/{whatsapp_number}`
- **Send File**: `POST {api_endpoint}/api/v1/sendSessionFile/{whatsapp_number}`

## Notes

- Phone numbers are automatically formatted with country code (91 for India if 10 digits)
- PDF files are temporarily stored in `storage/app/temp/` and cleaned up after sending
- All WhatsApp operations are logged for debugging purposes

