import { router } from '@inertiajs/react';

const API_BASE = '/api/calendar/bookings';

const getCsrfToken = () =>
  document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content')
  ?? '';

const formatDate = (value: Date | string | undefined) => {
  if (!value) return undefined;
  if (value instanceof Date) {
    const year = value.getFullYear();
    const month = String(value.getMonth() + 1).padStart(2, '0');
    const day = String(value.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
  return value;
};

const toNullableInteger = (
  value: string | number | undefined | null,
): number | null => {
  if (value === undefined || value === null || value === '') {
    return null;
  }

  const parsed = Number(value);
  return Number.isNaN(parsed) ? null : parsed;
};

const toNullableFloat = (
  value: string | number | undefined | null,
): number | null => {
  if (value === undefined || value === null || value === '') {
    return null;
  }

  const parsed = Number(value);
  return Number.isNaN(parsed) ? null : parsed;
};

const toNullableString = (value: string | undefined | null): string | null => {
  if (value === undefined || value === null) {
    return null;
  }

  const trimmed = String(value).trim();
  return trimmed === '' ? null : trimmed;
};

const formatBookingPayload = (values: any) => ({
  title: values.title,
  description: values.description,
  category: values.category,
  location: values.location,
  color: values.color,
  booking_client_id: toNullableInteger(values.booking_client_id),
  service_id: toNullableInteger(values.service_id),
  service_user_id: toNullableInteger(values.service_user_id),
  booking_calendar_id: toNullableInteger(values.booking_calendar_id),
  google_event_id: toNullableString(values.google_event_id),
  total_price: toNullableFloat(values.total_price),
  service_date: formatDate(values.startDate),
  start_time: values.startTime,
  end_time: values.endTime,
});

const dispatchBookingChange = (action: string) => {
  if (typeof window !== 'undefined' && window.dispatchEvent) {
    window.dispatchEvent(
      new CustomEvent('booking:mutated', { detail: { action } }),
    );
  }
};

const handleResponse = async (response: Response) => {
  let payload: any = null;

  try {
    payload = await response.json();
  } catch {
    throw new Error('An unexpected error occurred');
  }

  if (!response.ok || !payload?.success) {
    const errorMessage = payload?.message || 'API request failed';
    throw new Error(errorMessage);
  }

  return payload;
};

export async function createEvent(values: any) {
  const payload = formatBookingPayload(values);

  const response = await fetch(API_BASE, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
      'X-CSRF-TOKEN': getCsrfToken(),
    },
    body: JSON.stringify(payload),
  });

  const result = await handleResponse(response);
  dispatchBookingChange('create');

  return result;
}

export async function updateEvent(id: string, values: any) {
  const payload = formatBookingPayload(values);

  const response = await fetch(`${API_BASE}/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
      'X-CSRF-TOKEN': getCsrfToken(),
    },
    body: JSON.stringify(payload),
  });

  const result = await handleResponse(response);
  dispatchBookingChange('update');

  return result;
}

export async function deleteEvent(id: string) {
  const response = await fetch(`${API_BASE}/${id}`, {
    method: 'DELETE',
    headers: {
      Accept: 'application/json',
      'X-CSRF-TOKEN': getCsrfToken(),
    },
  });

  const result = await handleResponse(response);
  dispatchBookingChange('delete');

  return result;
}

export async function searchEvents(query: any) {
  return router.get('/events/search', query);
}
