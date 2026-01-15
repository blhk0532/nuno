"use client";

import React, { useEffect, useState } from "react";
import { CalendarBody } from "@/components/calendar/calendar-body";
import { CalendarProvider } from "@/components/calendar/contexts/calendar-context";
import { DndProvider } from "@/components/calendar/contexts/dnd-context";
import { CalendarHeader } from "@/components/calendar/header/calendar-header";
import { getEvents, getUsers } from "@/components/calendar/requests";
import type { IEvent, IUser } from "@/components/calendar/interfaces";

export function Calendar() {
	const [events, setEvents] = useState<IEvent[]>([]);
	const [users, setUsers] = useState<IUser[]>([]);
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		const fetchData = async () => {
			try {
				// First fetch users to have them available for events
				const usersData = await getUsers();
				setUsers(usersData);

				// Then fetch events and enrich them with user data
				const eventsData = await getEvents();
				const enrichedEvents = eventsData.map(event => ({
					...event,
					user: usersData.find(user => user.id === event.user.id) || event.user
				}));
				setEvents(enrichedEvents);
			} catch (error) {
				console.error('Error fetching calendar data:', error);
			} finally {
				setLoading(false);
			}
		};

		fetchData();
	}, []);

	if (loading) {
		return (
			<div className="w-full border rounded-xl flex items-center justify-center min-h-[99vh] h-[99vh]">
				<div className="text-center">
					<div className="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 mx-auto"></div>
					<p className="mt-2 text-sm text-gray-600">Loading calendar...</p>
				</div>
			</div>
		);
	}

	return (
		<CalendarProvider events={events} users={users} view="day">
			<DndProvider showConfirmation={false}>
				<div className="w-full border rounded-xl min-h-[88vh]">
					<CalendarHeader />
					<CalendarBody />
				</div>
			</DndProvider>
		</CalendarProvider>
	);
}
