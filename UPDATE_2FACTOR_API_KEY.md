# 2Factor API Key Update

## API Key Updated Successfully

The 2Factor API key has been updated in the database:

**API Key:** `0ee9bc61-a5a8-11f0-b922-0200cd936042`

## Where It's Stored

The API key is stored in the database settings table. The system checks for the key in this order:
1. Database setting: `twofactor_api_key`
2. Environment variable: `TWOFACTOR_API_KEY`

## Optional: Update .env File

If you want to also set it in the `.env` file (recommended for production), add or update:

```env
TWOFACTOR_API_KEY=0ee9bc61-a5a8-11f0-b922-0200cd936042
SMS_SENDER_ID=SUGAR
```

## Testing the Integration

To test the SMS integration:

1. Register a new patient via the doctor dashboard
2. The system will automatically send an SMS to the patient's mobile number
3. Check the application logs at `storage/logs/laravel.log` for SMS sending status
4. The patient should receive the SMS on their registered mobile number

## Verification

You can verify the API key is configured by running:

```bash
php artisan tinker
```

Then in tinker:
```php
use App\Services\TwoFactorService;
$service = new TwoFactorService();
$service->isConfigured(); // Should return true
```

## API Details

- **Endpoint:** `https://2factor.in/API/V1/{api_key}/ADDON_SERVICES/SEND/TSMS`
- **Method:** POST
- **Sender ID:** SUGAR (configurable via `sms_sender_id` setting)

