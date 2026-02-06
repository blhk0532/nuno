#!/bin/bash
# Laravel Horizon Auto-Restart Daemon
# Place this in your project root and run: bash horizon-monitor.sh
# It will keep Horizon running and auto-restart if it crashes

HORIZON_PID_FILE="/home/baba/zzz/nuno/.horizon.pid"
APP_PATH="/home/baba/zzz/nuno"
LOG_FILE="$APP_PATH/storage/logs/horizon-monitor.log"

# Function to start Horizon
start_horizon() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting Horizon..." >> "$LOG_FILE"

    # Kill any existing Horizon processes
    pkill -f "php.*horizon" || true
    sleep 2

    # Start fresh
    cd "$APP_PATH"
    nohup php artisan horizon > "$APP_PATH/storage/logs/horizon.log" 2>&1 &
    HORIZON_PID=$!
    echo $HORIZON_PID > "$HORIZON_PID_FILE"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Horizon started with PID $HORIZON_PID" >> "$LOG_FILE"
}

# Function to check if Horizon is running
is_horizon_running() {
    if [ -f "$HORIZON_PID_FILE" ]; then
        PID=$(cat "$HORIZON_PID_FILE")
        if ps -p $PID > /dev/null 2>&1; then
            return 0
        fi
    fi
    return 1
}

# Main monitoring loop
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Horizon monitor started" >> "$LOG_FILE"

# Ensure log file exists
mkdir -p "$APP_PATH/storage/logs"

# Start initial instance
start_horizon

# Monitor loop
while true; do
    sleep 5

    if ! is_horizon_running; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Horizon not running, restarting..." >> "$LOG_FILE"
        start_horizon
    fi
done
