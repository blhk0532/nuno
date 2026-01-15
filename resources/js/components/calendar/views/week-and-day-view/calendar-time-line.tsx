import { useEffect, useState } from "react";
import { useCalendar } from "@/components/calendar/contexts/calendar-context";
import { formatTime } from "@/components/calendar/helpers";
import { toZonedTime } from "date-fns-tz";

export function CalendarTimeline() {
	const { use24HourFormat, timezone } = useCalendar();
	const [currentTime, setCurrentTime] = useState(new Date());

	useEffect(() => {
		const timer = setInterval(() => setCurrentTime(new Date()), 60 * 1000);
		return () => clearInterval(timer);
	}, []);

	const getCurrentTimePosition = () => {
		// Convert to timezone-specific time for position calculation
		const zonedTime = toZonedTime(currentTime, timezone);
		const minutes = zonedTime.getHours() * 60 + zonedTime.getMinutes();
		return (minutes / 1440) * 100;
	};

	const formatCurrentTime = () => {
		return formatTime(currentTime, use24HourFormat, timezone);
	};

	return (
		<div
			className="pointer-events-none absolute inset-x-0 z-50 border-t border-primary"
			style={{ top: `${getCurrentTimePosition()}%` }}
		>
			<div className="absolute -left-1.5 -top-1.5 size-3 rounded-full bg-primary"></div>

			<div className="absolute -left-18 flex w-16 -translate-y-1/2 justify-end bg-background pr-1 text-xs font-medium text-primary">
				{formatCurrentTime()}
			</div>
		</div>
	);
}
