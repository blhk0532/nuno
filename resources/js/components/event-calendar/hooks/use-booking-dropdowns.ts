'use client';

import { useCallback, useEffect, useRef, useState } from 'react';
import type {
  CalendarBookingCalendar,
  CalendarClient,
  CalendarService,
  CalendarTechnician,
} from '../types';

type DropdownState = {
  clients: CalendarClient[];
  services: CalendarService[];
  technicians: CalendarTechnician[];
  calendars: CalendarBookingCalendar[];
  loading: boolean;
  error: Error | null;
};

const fetchJson = async <T>(url: string): Promise<T> => {
  const response = await fetch(url, {
    headers: { Accept: 'application/json' },
  });

  if (!response.ok) {
    const text = await response.text();
    throw new Error(`${url} responded with ${response.status}: ${text}`);
  }

  return response.json();
};

export function useBookingDropdowns() {
  const [state, setState] = useState<DropdownState>({
    clients: [],
    services: [],
    technicians: [],
    calendars: [],
    loading: true,
    error: null,
  });
  const isMountedRef = useRef(true);

  const load = useCallback(async () => {
    setState((prev) => ({ ...prev, loading: true, error: null }));

    try {
      const [clientsData, servicesData, techniciansData, calendarsData] =
        await Promise.all([
          fetchJson<CalendarClient[]>('/api/calendar/clients'),
          fetchJson<CalendarService[]>('/api/calendar/services'),
          fetchJson<CalendarTechnician[]>('/api/calendar/service-users'),
          fetchJson<CalendarBookingCalendar[]>('/api/calendar/calendars'),
        ]);

      if (!isMountedRef.current) {
        return;
      }

      setState({
        clients: clientsData,
        services: servicesData,
        technicians: techniciansData,
        calendars: calendarsData,
        loading: false,
        error: null,
      });
    } catch (error) {
      if (!isMountedRef.current) {
        return;
      }
      console.error('Error loading booking dropdowns:', error);
      setState((prev) => ({
        ...prev,
        loading: false,
        error: error instanceof Error ? error : new Error('Failed to load dropdowns'),
      }));
    }
  }, []);

  useEffect(() => {
    isMountedRef.current = true;
    load().catch(() => {
      /* load handles errors */
    });

    return () => {
      isMountedRef.current = false;
    };
  }, [load]);

  return {
    ...state,
    refetch: load,
  };
}
