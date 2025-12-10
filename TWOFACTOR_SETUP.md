# 2Factor.in SMS Integration Setup

This document explains how to configure 2Factor.in API for sending SMS notifications to patients.

## Configuration

You need to configure 2Factor.in API credentials in your application. You can do this in two ways:

### Option 1: Environment Variables (Recommended)

Add the following variables to your `.env` file:

```env
TWOFACTOR_API_KEY=0ee9bc61-a5a8-11f0-b922-0200cd936042
SMS_SENDER_ID=SUGAR
```

### Option 2: Database Settings

You can also store 2Factor.in settings in the database using the Settings model:

```php
Setting::set('twofactor_api_key', 'your_api_key_here', 'string', '2Factor.in API key');
Setting::set('sms_sender_id', 'SUGAR', 'string', 'SMS Sender ID');
```

## Getting 2Factor.in API Credentials

1. Sign up for a 2Factor.in account at https://2factor.in
2. Navigate to your dashboard
3. Go to API Settings
4. Generate or copy your API Key
5. Note your Sender ID (or request one from 2Factor.in support)

## Patient Registration SMS

When a new patient is registered, an SMS is automatically sent to the patient's mobile number with the following message:

```
Dear {patient_name}, thank you for registering with {clinic_name} under the care of Dr. {doctor_name}. Your registration is successful.
```

### Dynamic Variables

The SMS message supports the following variables:

- `{patient_name}` or `{#patient_name#}` - Patient's full name
- `{clinic_name}` or `{#clinic_name#}` - Clinic/Hospital name (from doctor's hospital_name or site_name)
- `{doctor_name}` or `{#doctor_name#}` - Doctor's name who registered the patient

### Message Template

You can customize the SMS template by updating the `patient_registration_sms` setting:

```php
Setting::set('patient_registration_sms', 'Dear {patient_name}, thank you for registering with {clinic_name} under the care of Dr. {doctor_name}. Your registration is successful.', 'string', 'Patient registration SMS template');
```

Or via the admin settings page if available.

## How It Works

When a doctor registers a new patient:

1. The patient is created in the database
2. An appointment is created with patient details snapshot
3. `ReminderService::sendPatientRegistrationConfirmation()` is called
4. The SMS message is generated with dynamic variables replaced
5. The SMS is sent via 2Factor.in API to the patient's mobile number

## Testing

To test the integration:

1. Ensure 2Factor.in API key is configured
2. Register a new patient via the doctor dashboard
3. Check application logs at `storage/logs/laravel.log` for SMS sending status
4. The patient should receive the SMS on their registered mobile number

## Troubleshooting

### "SMS service is not configured"

- Check that `TWOFACTOR_API_KEY` is set in `.env` or database
- Verify the setting using `Setting::get('twofactor_api_key')`

### "Missing TemplateName value"

This error occurs when your 2Factor.in account requires a TemplateName (common in India due to DLT regulations). You have two options:

**Option 1: Create a template in 2Factor.in dashboard**
1. Log into your 2Factor.in dashboard
2. Go to Templates section
3. Create a new template with your message format
4. Get the TemplateName from the dashboard
5. Set it in your application:
   ```php
   Setting::set('twofactor_template_name', 'your_template_name_here', 'string', '2Factor.in Template Name');
   ```
   Or in `.env`:
   ```env
   TWOFACTOR_TEMPLATE_NAME=your_template_name_here
   ```

**Option 2: Contact 2Factor.in support**
- Ask if your account can send template-less messages
- Some accounts may require template approval from TRAI/DLT

### "Failed to send SMS"

- Verify your 2Factor.in API key is valid
- Check your 2Factor.in account balance
- Ensure the mobile number is valid (10-digit Indian number)
- Check application logs for detailed error messages
- Verify the Sender ID is approved by 2Factor.in
- If you see "Missing TemplateName value", see above section

### Mobile number format issues

- 2Factor.in expects 10-digit Indian mobile numbers
- Any suffixes (A, B, C) added by the system are automatically removed
- Country codes (91) are automatically removed if present

## API Endpoints Used

- **Send SMS**: `POST https://2factor.in/API/V1/{api_key}/ADDON_SERVICES/SEND/TSMS`

## Request Format

```json
{
    "From": "SUGAR",
    "To": "9876543210",
    "Msg": "Your message here"
}
```

## Response Format

Success:
```json
{
    "Status": "Success",
    "Details": "Message sent successfully"
}
```

Error:
```json
{
    "Status": "Error",
    "Details": "Error message"
}
```

## Notes

- SMS is only sent for patient registration confirmation
- Other reminders (6-month, 3-month) use email or WhatsApp
- All SMS operations are logged for debugging purposes
- Mobile numbers are automatically formatted (suffixes removed, country codes handled)
- The system gracefully handles failures and logs errors without breaking the registration process

