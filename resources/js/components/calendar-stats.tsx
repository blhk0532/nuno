import { useEffect, useState } from 'react';

interface CalendarStats {
    total_bookings: number;
    booked: number;
    confirmed: number;
    cancelled: number;
    completed: number;
    today_bookings: number;
    week_bookings: number;
}

export function CalendarStats() {
    const [stats, setStats] = useState<CalendarStats>({
        total_bookings: 0,
        booked: 0,
        confirmed: 0,
        cancelled: 0,
        completed: 0,
        today_bookings: 0,
        week_bookings: 0,
    });

    useEffect(() => {
        const fetchStats = async () => {
            try {
                const response = await fetch('/api/calendar/stats');
                const data = await response.json();
                setStats(data);
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        };

        fetchStats();

        // Refresh stats every 5 minutes
        const interval = setInterval(fetchStats, 300000);
        return () => clearInterval(interval);
    }, []);

    return (
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div className="rounded-lg bg-white p-6 shadow">
                <div className="text-sm font-medium text-gray-500">
                    Total Bokningar
                </div>
                <div className="mt-2 text-3xl font-bold text-gray-900">
                    {stats.total_bookings}
                </div>
            </div>

            <div className="rounded-lg bg-white p-6 shadow">
                <div className="text-sm font-medium text-gray-500">
                    Bekräftade
                </div>
                <div className="mt-2 text-3xl font-bold text-green-600">
                    {stats.confirmed}
                </div>
            </div>

            <div className="rounded-lg bg-white p-6 shadow">
                <div className="text-sm font-medium text-gray-500">Idag</div>
                <div className="mt-2 text-3xl font-bold text-blue-600">
                    {stats.today_bookings}
                </div>
            </div>

            <div className="rounded-lg bg-white p-6 shadow">
                <div className="text-sm font-medium text-gray-500">
                    Denna Vecka
                </div>
                <div className="mt-2 text-3xl font-bold text-purple-600">
                    {stats.week_bookings}
                </div>
            </div>
        </div>
    );
}
