# Telavox SMS (CLI)

This project includes a simple Artisan command to send SMS via Telavox Flow/Home API.

## Setup

1. Add your Telavox personal JWT token to your environment:

```bash
export TELAVOX_TOKEN="<your-token>"
```

Alternatively, add to your `.env`:

```
TELAVOX_TOKEN=<your-token>
TELAVOX_BASE_URL=https://api.telavox.se
```

## Usage

Send a message:

```bash
# Swedish number (local format)
php artisan telavox:sms 0701234567 "Hello from Telavox"

# Swedish number (international format with +)
php artisan telavox:sms +46701234567 "Hello from Telavox"

# International number (example)
php artisan telavox:sms +46844484112 "Test message"
```

Debug mode to see request details without sending:

```bash
php artisan telavox:sms +46701234567 "Test" --debug
```

Test API connection:

```bash
php artisan telavox:test
```

Expected success response prints `SMS sent successfully.`.

If there is an error, the command prints the HTTP status and message.

## Notes

- SMS is sent from the logged-in Telavox user associated with the token; sender cannot be overridden.
- Ensure your user has paid telephony; otherwise the API may be blocked.
- The API endpoint used: `GET https://api.telavox.se/sms/{number}?message=...` with `Authorization: Bearer`.
- **Number format**: Use E.164 format with `+` prefix (e.g., `+46701234567` for Swedish numbers). Local format (e.g., `0701234567`) also works for Swedish numbers.
- **International SMS**: May not be supported for all countries depending on your Telavox plan. If you get "Message couldn't be sent for unknown reason" (400 error), the destination country may not be supported or your account may need international SMS enabled.
- **Tested**: Successfully sends to Swedish numbers. International destinations may vary by account settings.
