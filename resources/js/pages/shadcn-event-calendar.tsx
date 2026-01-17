import { useCallback, useEffect, useState } from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { addDays, endOfMonth, startOfMonth } from 'date-fns';
import { toZonedTime } from 'date-fns-tz';

import { EventCalendar } from '@/components/event-calendar/event-calendar';
import type { Events } from '@/types/event';
import type { CalendarCategoryOption } from '@/types/event';
import type { IUser } from '@/components/calendar/interfaces';

const SWEDEN_TIMEZONE = 'Europe/Stockholm';

const formatTime = (date: Date) =>
  `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;

const transformBookingToEvent = (booking: any): Events => {
  const fallbackDate = booking.extendedProps?.service_date
    ? new Date(booking.extendedProps.service_date)
    : new Date();
  const startBase = booking.start ? new Date(booking.start) : fallbackDate;
  const endBase = booking.end ? new Date(booking.end) : startBase;

  const startZoned = toZonedTime(startBase, SWEDEN_TIMEZONE);
  const endZoned = toZonedTime(endBase, SWEDEN_TIMEZONE);

  const startTime = booking.extendedProps?.start_time ?? formatTime(startZoned);
  const endTime = booking.extendedProps?.end_time ?? formatTime(endZoned);

  return {
    id: booking.id.toString(),
    title: booking.title || booking.number || 'Booking',
    description: booking.description || '',
    startDate: startZoned,
    endDate: endZoned,
    startTime,
    endTime,
    isRepeating: false,
    repeatingType: null,
    location: booking.location ?? booking.extendedProps?.location ?? '',
    category: booking.category ?? booking.extendedProps?.category ?? 'General',
    color: booking.color ?? booking.extendedProps?.color ?? '#3b82f6',
    createdAt: booking.createdAt ? new Date(booking.createdAt) : new Date(),
    updatedAt: booking.updatedAt ? new Date(booking.updatedAt) : new Date(),
    technicianId: booking.resourceId ? booking.resourceId.toString() : undefined,
    technicianName: booking.extendedProps?.service_user_name ?? '',
    service_user_id:
      booking.extendedProps?.service_user_id !== undefined
        ? String(booking.extendedProps.service_user_id)
        : booking.resourceId ?? undefined,
    booking_calendar_id:
      booking.extendedProps?.booking_calendar_id !== undefined
        ? String(booking.extendedProps.booking_calendar_id)
        : undefined,
    google_event_id: booking.extendedProps?.google_event_id ?? undefined,
  };
};

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Shadcn Event Calendar',
    href: '/shadcn-event-calendar',
  },
];

export default function ShadcnEventCalendar() {
  const [events, setEvents] = useState<Events[]>([]);
  const [allEvents, setAllEvents] = useState<Events[]>([]);
  const [users, setUsers] = useState<IUser[]>([]);
  const [selectedTechnicianId, setSelectedTechnicianId] = useState<string>('all');
  const [loading, setLoading] = useState(true);
  const [categoryOptions, setCategoryOptions] = useState<CalendarCategoryOption[]>([]);

  const fetchBookings = useCallback(async () => {
    setLoading(true);
    try {
      const now = new Date();
      const rangeStart = startOfMonth(now);
      const rangeEnd = addDays(endOfMonth(now), 30);
      const params = new URLSearchParams({
        start: rangeStart.toISOString(),
        end: rangeEnd.toISOString(),
      });

      const response = await fetch(`/api/calendar/bookings?${params.toString()}`);
      if (!response.ok) {
        throw new Error('Failed to fetch bookings');
      }

      const bookings = (await response.json()) as any[];
      const transformedEvents = bookings.map(transformBookingToEvent);

      setAllEvents(transformedEvents);
      setEvents(transformedEvents);
    } catch (error) {
      console.error('Error fetching bookings:', error);
    } finally {
      setLoading(false);
    }
  }, []);

  const fetchServiceUsers = useCallback(async () => {
    try {
      const response = await fetch('/api/calendar/service-users');
      if (!response.ok) {
        throw new Error('Failed to fetch technicians');
      }

      const data = (await response.json()) as any[];
      setUsers(
        data.map((user) => ({
          id: String(user.id),
          name: user.name,
          picturePath: null,
        })),
      );
    } catch (error) {
      console.error('Error fetching technicians:', error);
    }
  }, []);

  const fetchCategories = useCallback(async () => {
    try {
      const response = await fetch('/api/calendar/categories');
      if (!response.ok) {
        throw new Error('Failed to fetch categories');
      }

      const data = (await response.json()) as CalendarCategoryOption[];
      setCategoryOptions(data);
    } catch (error) {
      console.error('Error fetching categories:', error);
    }
  }, []);

  useEffect(() => {
    fetchBookings();
    fetchServiceUsers();
    fetchCategories();
  }, [fetchBookings, fetchServiceUsers, fetchCategories]);

  useEffect(() => {
    const handleBookingMutation = () => fetchBookings();
    window.addEventListener('booking:mutated', handleBookingMutation);
    return () => window.removeEventListener('booking:mutated', handleBookingMutation);
  }, [fetchBookings]);

  useEffect(() => {
    if (selectedTechnicianId === 'all') {
      setEvents(allEvents);
      return;
    }

    const filtered = allEvents.filter(
      (event) => event.technicianId === selectedTechnicianId,
    );
    setEvents(filtered);
  }, [selectedTechnicianId, allEvents]);

  if (loading) {
    return (
      <AppLayout breadcrumbs={breadcrumbs}>
        <Head title="Shadcn Event Calendar" />
        <div className="w-full max-w-[100%]">
          <div className="bg-transparent rounded-lg shadow min-h-[98vh] flex items-center justify-center">
            <div className="text-center">
              <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-black dark:border-white mx-auto"/>
                <svg version="1.2" id="nordic-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 336" width="200" height="34" fill="currentColor">
	                <g><path fillRule="evenodd" className="s0" d="m1245.5 13.5q39 0 78 0 0.25 104-0.5 208-7.73 69.72-72.5 96.5-81.51 23.59-131.5-44.5-35.41-60.78 1-121 47.62-63.63 125.5-45 0-47 0-94zm-73 200q4.85 39.91 45 39.5 31.97-6.41 35-39-5.71-41.96-48-39.5-29.03 8.55-32 39z"></path></g>
	                <g><path fillRule="evenodd" className="s0" d="m655.5 101.5q73.88-5.44 112.5 57 31.23 64.88-11 123-49.57 55.58-121.5 35.5-62.5-23.77-74.5-89.5-6.8-72.15 53.5-111.5 19.47-10.74 41-14.5zm-10 79.5q-23.59 23.82-7.5 53.5 21.72 25.85 52.5 11.5 20.62-12.99 19.5-37.5-7.55-39.17-47.5-36-9.15 2.65-17 8.5z"></path></g>
	                <g><path fillRule="evenodd" className="s0" d="m1623.5 101.5q54.97-5.93 94 32.5-24.5 24.5-49 49-1.5 1-3 0-19.76-16.75-44-7-27.69 16.05-20.5 47.5 15.61 36.43 53.5 24.5 7.07-3.08 12.5-8.5 25.25 25.25 50.5 50.5-54.66 49.83-124 23-54.24-26.7-64.5-86.5-5.65-83.98 70.5-118.5 12.06-3.76 24-6.5z"></path></g>
	                <g><path fillRule="evenodd" className="s0" d="m381.5 106.5q59 0 118 0 0 105 0 210-42 0-84 0 0-63 0-126-27 0-54 0 0 63 0 126-43 0-86 0-0.25-52 0.5-104 53.05-52.8 105.5-106z"></path></g>
	                <g><path fillRule="evenodd" className="s0" d="m944.5 106.5q50 0 100 0 0 42 0 84-60 0-120 0 0 63 0 126-43 0-86 0-0.25-52 0.5-104 53.05-52.8 105.5-106z"></path></g>
	                <g><path fillRule="evenodd" className="s0" d="m1385.5 106.5q42 0 84 0 0 105 0 210-42 0-84 0 0-105 0-210z"></path></g>
                </svg>
            </div>
          </div>
        </div>
      </AppLayout>
    );
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="NDS Calendar" />
      <div className="w-full max-w-[100%]">
        <div className="bg-transparent rounded-lg max-h-[96vh] min-h-[96vh] p-0">
          <EventCalendar
            events={events}
            initialDate={new Date()}
            users={users}
            selectedTechnicianId={selectedTechnicianId}
            onTechnicianChange={setSelectedTechnicianId}
            totalEvents={allEvents.length}
            categoryOptions={categoryOptions}
          />
        </div>
      </div>
    </AppLayout>
  );
}
