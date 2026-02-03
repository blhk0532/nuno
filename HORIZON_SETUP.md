# Laravel Horizon Queue Setup Guide

## Current Status ✓

- **Queue System**: Redis (working)
- **Queue Driver**: Active with Horizon 5.43
- **Batch System**: Working (job_batches table tracking all bulk actions)
- **Jobs Table**: Empty (correct - batches don't use jobs table)

## Why Jobs Table is Empty

Your bulk actions dispatch **batched jobs**, not regular queued jobs:
- `job_batches` table = where your bulk action batches are tracked ✓
- `jobs` table = for regular non-batched queued jobs (can be empty)

**This is the correct behavior for bulk actions.**

## Keeping Horizon Running (3 Options)

### Option 1: Systemd Service (RECOMMENDED - Requires sudo)

1. Copy the service file:
```bash
sudo cp /tmp/laravel-horizon.service /etc/systemd/system/
```

2. Enable and start:
```bash
sudo systemctl daemon-reload
sudo systemctl enable laravel-horizon
sudo systemctl start laravel-horizon
```

3. Check status:
```bash
sudo systemctl status laravel-horizon
sudo journalctl -u laravel-horizon -f  # View logs in real-time
```

4. If Horizon crashes, systemd will auto-restart it.

### Option 2: Monitor Script (NO SUDO NEEDED)

Run this in a screen/tmux session or separate terminal:
```bash
bash /home/baba/zzz/nuno/horizon-monitor.sh
```

This script:
- Starts Horizon on launch
- Checks every 5 seconds if it's still running
- Auto-restarts if it crashes
- Logs all activity to `storage/logs/horizon-monitor.log`

**For persistent background execution, use screen:**
```bash
# Start in background
screen -S horizon-monitor -d -m bash /home/baba/zzz/nuno/horizon-monitor.sh

# View status
screen -ls

# Reattach to view logs
screen -r horizon-monitor

# Detach (Ctrl-A then D)
```

### Option 3: Docker/Production Setup

For production, use Docker with restart policy:
```dockerfile
# In your docker-compose.yml
horizon:
  image: your-app:latest
  command: php artisan horizon
  restart: always  # Auto-restart on crash
  environment:
    - APP_ENV=production
```

## Current Running Instance

Horizon is currently running via nohup. To keep it alive:

```bash
# Check if running
ps aux | grep "php.*horizon" | grep -v grep

# Kill current instance
pkill -f "php.*horizon"

# Start with monitor (recommended)
bash /home/baba/zzz/nuno/horizon-monitor.sh &
```

## Monitoring Horizon Health

```bash
# Check via Artisan
php artisan horizon:status

# Check via dashboard
# Visit: http://localhost:8000/horizon

# View real-time logs
tail -f storage/logs/horizon.log

# Check queue lengths
php artisan tinker
# Then:
# Redis::llen('queues:scrape')
# Redis::llen('queues:default')
# etc.
```

## Queue Configuration

Your Horizon config processes these queues:
- `scrape` (primary)
- `default`
- `hitta-counts`
- `ratsit-counts`
- `hitta-postort`
- `hitta-personer`
- `ratsit-personer`
- `merinfo-queue`
- `merinfo-count`

**Max processes**: 5
**Timeout**: 600 seconds

Edit in `config/horizon.php` if needed.

## Testing Queue System

```bash
# Dispatch a test job
php artisan tinker
> dispatch(new \App\Jobs\TestScrapeQueueJob());

# Check Redis queue
php artisan tinker
> Redis::llen('queues:scrape')

# View batch progress
> DB::table('job_batches')->where('finished_at', null)->get(['id', 'name', 'total_jobs', 'pending_jobs'])
```

## Troubleshooting

**Problem**: Horizon keeps crashing
- Check logs: `tail -f storage/logs/horizon.log`
- Check if Redis is running: `redis-cli ping`
- Check for errors in Node.js scripts (hitta_post_ort.mjs, etc.)

**Problem**: Jobs not processing
- Verify queue driver: `php artisan config:get queue.default`
- Verify Horizon is running: `ps aux | grep horizon`
- Check Horizon config: `cat config/horizon.php`

**Problem**: Batches stuck as "pending"
- Check database: `SELECT * FROM job_batches WHERE finished_at IS NULL`
- Clean up stuck batches: `DELETE FROM job_batches WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)`

## Next Steps

1. Choose how to keep Horizon running (Option 1, 2, or 3)
2. Test with a bulk action
3. Monitor job_batches table for completed batches
4. Set up log rotation for horizon.log (optional)
