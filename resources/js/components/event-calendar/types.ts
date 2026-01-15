export type CalendarClient = {
  id: number;
  name: string;
  email?: string;
  phone?: string;
  address?: string;
  city?: string;
};

export type CalendarService = {
  id: number;
  name: string;
  description?: string;
  duration?: number;
  price?: number;
};

export type CalendarTechnician = {
  id: number;
  name: string;
  email?: string;
  phone?: string;
  calendar_ids: number[];
};

export type CalendarBookingCalendar = {
  id: number;
  name: string;
  owner_id?: number;
  is_active: boolean;
  google_calendar_id?: string;
  whatsapp_id?: string;
};
