import React, { useState, useEffect } from 'react';
import { ResourceTimeline } from '@/components/resource-timeline';
import { Button } from '@/components/ui/button';
import { BookingForm, type BookingFormData } from '@/components/booking-form';

interface Event {
  id: string;
  title: string;
  start: string;
  end?: string;
  resourceId?: string;
  backgroundColor?: string;
  borderColor?: string;
  extendedProps?: {
    type: string;
    status: string;
    client_name?: string;
    service_name?: string;
    service_user_name?: string;
    location_name?: string;
    total_price?: number;
    notes?: string;
  };
}

export function BookingCalendar() {
  const [events, setEvents] = useState<Event[]>([]);
  const [loading, setLoading] = useState(false);
  const [showForm, setShowForm] = useState(false);
  const [selectedEvent, setSelectedEvent] = useState<Partial<BookingFormData> | null>(null);

  // Fetch events from API
  useEffect(() => {
    fetchEvents();
  }, []);

  const fetchEvents = async () => {
    try {
      setLoading(true);
      const today = new Date();
      const nextMonth = new Date(today.getTime() + 30 * 24 * 60 * 60 * 1000);

      const response = await fetch(
        `/api/calendar/bookings?start=${today.toISOString()}&end=${nextMonth.toISOString()}`
      );

      if (response.ok) {
        const data = await response.json();
        setEvents(data);
      }
    } catch (error) {
      console.error('Failed to fetch events:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleSelectSlot = (selectInfo: any) => {
    // Get time in HH:mm format from the selected dates
    const startDate = new Date(selectInfo.start);
    const endDate = new Date(selectInfo.end);

    const startTime = String(startDate.getHours()).padStart(2, '0') + ':' + String(startDate.getMinutes()).padStart(2, '0');
    const endTime = String(endDate.getHours()).padStart(2, '0') + ':' + String(endDate.getMinutes()).padStart(2, '0');

    setSelectedEvent({
      service_date: startDate.toISOString().split('T')[0],
      start_time: startTime,
      end_time: endTime,
      service_user_id: selectInfo.resourceId ? parseInt(selectInfo.resourceId) : undefined,
    });

    setShowForm(true);
  };

  const handleFormSubmit = async (formData: BookingFormData) => {
    try {
      setLoading(true);
      const response = await fetch('/api/calendar/bookings', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '',
        },
        body: JSON.stringify(formData),
      });

      if (response.ok) {
        setShowForm(false);
        setSelectedEvent(null);
        await fetchEvents();
      } else {
        const errors = await response.json();
        console.error('Booking error:', errors);
        alert('Fel vid skapande av bokning. Kontrollera formuläret.');
      }
    } catch (error) {
      console.error('Failed to create booking:', error);
      alert('Ett fel uppstod. Försök igen senare.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      {/* Calendar Section */}
      <div className="relative h-[600px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
        <ResourceTimeline
          className="h-full"
          schedulerLicenseKey="CC-Attribution-NonCommercial-NoDerivatives"
          editable
          selectable
          selectConstraint="businessHours"
          select={handleSelectSlot}
          nowIndicator
          navLinks
          locale="sv"
          initialView="resourceTimelineWeek"
          height="100%"
          contentHeight="auto"
          timeZone="UTC"
          resourceColumnHeaderContent="Tekniker"
          resources="calendar/resources?with-nesting&with-colors"
          events="calendar/events?with-resource-timeline"
          addButton={{
            text: 'Ny bokning',
            click() {
              setShowForm(true);
              setSelectedEvent(null);
            },
          }}
        />
      </div>

      {/* Booking Form Modal/Section */}
      {showForm && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
          <div className="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl bg-background p-6 shadow-lg">
            <button
              onClick={() => {
                setShowForm(false);
                setSelectedEvent(null);
              }}
              className="absolute right-4 top-4 text-muted-foreground hover:text-foreground"
            >
              ✕
            </button>

            <h2 className="mb-6 text-2xl font-semibold">Ny bokning</h2>

            <BookingForm
              onSubmit={handleFormSubmit}
              loading={loading}
            />
          </div>
        </div>
      )}

      {/* Events List */}
      <div className="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
        <h3 className="text-lg font-semibold mb-4">Kommande bokningar</h3>

        {events.length === 0 ? (
          <p className="text-muted-foreground">Inga bokningar ännu</p>
        ) : (
          <div className="space-y-3">
            {events.map((event) => (
              <div
                key={event.id}
                className="rounded-lg border border-sidebar-border/50 p-4 hover:bg-accent/50 transition-colors"
              >
                <div className="flex items-start justify-between">
                  <div className="flex-1">
                    <h4 className="font-semibold text-sm">{event.title}</h4>
                    <p className="text-xs text-muted-foreground mt-1">
                      {event.extendedProps?.client_name && `Klient: ${event.extendedProps.client_name}`}
                    </p>
                    <p className="text-xs text-muted-foreground">
                      {event.extendedProps?.service_name && `Service: ${event.extendedProps.service_name}`}
                    </p>
                    <p className="text-xs text-muted-foreground">
                      {new Date(event.start).toLocaleString('sv-SE')}
                      {event.end ? ` - ${new Date(event.end).toLocaleTimeString('sv-SE')}` : ''}
                    </p>
                  </div>
                  <div className="ml-4">
                    <span
                      className={`inline-block px-3 py-1 rounded-full text-xs font-medium ${
                        event.extendedProps?.status === 'confirmed'
                          ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                          : event.extendedProps?.status === 'cancelled'
                            ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                            : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'
                      }`}
                    >
                      {event.extendedProps?.status === 'confirmed'
                        ? 'Bekräftad'
                        : event.extendedProps?.status === 'cancelled'
                          ? 'Inställd'
                          : 'Bokad'}
                    </span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
