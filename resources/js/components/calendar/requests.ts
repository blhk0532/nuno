import type { IEvent, IUser } from "@/components/calendar/interfaces";

const getCsrfToken = () => {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
};

export const getEvents = async (): Promise<IEvent[]> => {
	try {
		const response = await fetch('/calendar/events', {
			headers: {
				'Accept': 'application/json',
			},
		});
		if (!response.ok) {
			throw new Error('Failed to fetch events');
		}
		const events = await response.json();

		// Transform events to IEvent format
		return events.map((event: any) => ({
			id: parseInt(event.id),
			startDate: event.start,
			endDate: event.end || event.start,
			title: event.title,
			color: '#3b82f6', // Default blue color
			description: '',
			user: {
				id: event.resourceId || '1',
				name: '', // Will be filled in by the component
				picturePath: null,
			},
		}));
	} catch (error) {
		console.error('Error fetching events:', error);
		return [];
	}
};

export const getUsers = async (): Promise<IUser[]> => {
	try {
		const response = await fetch('/calendar/resources', {
			headers: {
				'Accept': 'application/json',
			},
		});
		if (!response.ok) {
			throw new Error('Failed to fetch users');
		}
		const users = await response.json();

		// Transform API users to IUser format
		return users.map((user: any) => ({
			id: user.id,
			name: user.title,
			picturePath: null,
		}));
	} catch (error) {
		console.error('Error fetching users:', error);
		return [];
	}
};
