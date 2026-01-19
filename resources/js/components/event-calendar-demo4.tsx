import { EventCalendar } from '@/components/event-calendar';
import { useForm } from '@inertiajs/react';
import { useCallback, useEffect, useState } from 'react';

export function EventCalendarDemo4() {
  const [dropdownData, setDropdownData] = useState({
    clients: [],
    services: [],
    locations: [],
    serviceUsers: [],
    calendars: [],
  });
  const [fourthTechnician, setFourthTechnician] = useState<any>(null);
  const [showNewClientForm, setShowNewClientForm] = useState(false);
  const [newClient, setNewClient] = useState({ name: '', email: '', phone: '' });
  const [newClientErrors, setNewClientErrors] = useState<string[]>([]);
  const [newClientProcessing, setNewClientProcessing] = useState(false);
  const [showBookingModal, setShowBookingModal] = useState(false);
  const [selectedSlot, setSelectedSlot] = useState<any>(null);
  const [selectedEvent, setSelectedEvent] = useState<any>(null);
  const [isEditMode, setIsEditMode] = useState(false);
  const [errors, setErrors] = useState<string[]>([]);
  const [successMessage, setSuccessMessage] = useState<string>('');

  const { data, setData, post, put, delete: destroy, processing, reset } = useForm({
    service_date: '',
    start_time: '',
    end_time: '',
    booking_client_id: '',
    service_id: '',
    booking_location_id: '',
    service_user_id: '',
    booking_calendar_id: '',
    status: 'booked',
    total_price: '',
    notes: '',
    service_note: '',
  });

  useEffect(() => {
    const loadFourth = async () => {
      try {
        const res = await fetch('/calendar/resources');
        const resources = await res.json();
        if (resources && resources.length > 3) {
          setFourthTechnician(resources[3]);
        }
      } catch (error) {
        console.error('Error loading technician:', error);
      }
    };

    loadFourth();
  }, []);

  useEffect(() => {
    const loadDropdownData = async () => {
      try {
        const [clientsRes, servicesRes, locationsRes, usersRes, calendarsRes] = await Promise.all([
          fetch('/api/calendar/clients'),
          fetch('/api/calendar/services'),
          fetch('/api/calendar/locations'),
          fetch('/api/calendar/service-users'),
          fetch('/api/calendar/calendars'),
        ]);

        const [clients, services, locations, serviceUsers, calendars] = await Promise.all([
          clientsRes.json(),
          servicesRes.json(),
          locationsRes.json(),
          usersRes.json(),
          calendarsRes.json(),
        ]);

        setDropdownData({ clients, services, locations, serviceUsers, calendars });
      } catch (error) {
        console.error('Error loading dropdown data:', error);
      }
    };

    loadDropdownData();
  }, []);

  const handleDateSelect = useCallback(
    (info: any) => {
      const start = new Date(info.start);
      const end = info.end ? new Date(info.end) : null;

      setSelectedSlot({ start, end, allDay: info.allDay, resourceId: info.resource?.id });

      setData((currentData) => ({
        ...currentData,
        service_date: start.toISOString().split('T')[0],
        start_time: start.toTimeString().slice(0, 5),
        end_time: end ? end.toTimeString().slice(0, 5) : '',
        service_user_id: info.resource?.id || fourthTechnician?.id || '',
      }));

      setIsEditMode(false);
      setShowBookingModal(true);
    },
    [setData, fourthTechnician],
  );

  const handleEventClick = useCallback(
    (info: any) => {
      const event = info.event;

      setSelectedEvent({ id: event.id, title: event.title, start: event.start, end: event.end, extendedProps: event.extendedProps });

      const props = event.extendedProps;
      setData((currentData) => ({
        ...currentData,
        service_date: props.service_date || event.start?.toISOString().split('T')[0] || '',
        start_time: props.start_time || event.start?.toTimeString().slice(0, 5) || '',
        end_time: props.end_time || event.end?.toTimeString().slice(0, 5) || '',
        booking_client_id: '',
        service_id: '',
        booking_location_id: '',
        service_user_id: event.getResource()?.id || '',
        status: props.status || 'booked',
        total_price: props.total_price || '',
        notes: props.notes || '',
        service_note: '',
      }));

      setIsEditMode(true);
      setShowBookingModal(true);
    },
    [setData],
  );

  const handleEventDrop = useCallback(async (info: any) => {
    const event = info.event;
    const newStart = event.start;
    const newEnd = event.end;
    const resourceId = event.getResource()?.id;

    try {
      const response = await fetch(`/api/calendar/bookings/${event.id}/move`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
        body: JSON.stringify({ start: newStart.toISOString(), end: newEnd ? newEnd.toISOString() : null, resource_id: resourceId }),
      });

      if (!response.ok) {
        throw new Error('Failed to move booking');
        info.revert();
      }

      window.location.reload();
    } catch (error) {
      console.error('Error moving booking:', error);
      info.revert();
    }
  }, []);

  const handleEventResize = useCallback(async (info: any) => {
    const event = info.event;
    const newEnd = event.end;

    try {
      const response = await fetch(`/api/calendar/bookings/${event.id}/resize`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
        body: JSON.stringify({ end: newEnd.toISOString() }),
      });

      if (!response.ok) {
        throw new Error('Failed to resize booking');
        info.revert();
      }

      window.location.reload();
    } catch (error) {
      console.error('Error resizing booking:', error);
      info.revert();
    }
  }, []);

  const handleSubmit = useCallback(
    async (e: React.FormEvent) => {
      e.preventDefault();
      setErrors([]);
      setSuccessMessage('');

      try {
        const url = isEditMode ? `/api/calendar/bookings/${selectedEvent?.id}` : '/api/calendar/bookings';
        const method = isEditMode ? 'PUT' : 'POST';

        const response = await fetch(url, {
          method,
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
          body: JSON.stringify(data),
        });

        const responseData = await response.json();

        if (!response.ok) {
          if (responseData.errors) {
            const errorMessages = Object.values(responseData.errors).flat() as string[];
            setErrors(errorMessages);
          } else {
            setErrors([responseData.message || `Failed to ${isEditMode ? 'update' : 'create'} booking`]);
          }
          return;
        }

        setSuccessMessage(responseData.message || `Booking ${isEditMode ? 'updated' : 'created'} successfully`);
        setTimeout(() => {
          setShowBookingModal(false);
          reset();
          setSelectedEvent(null);
          setSelectedSlot(null);
          window.location.reload();
        }, 1500);
      } catch (error) {
        console.error(`Error ${isEditMode ? 'updating' : 'creating'} booking:`, error);
        setErrors(['An unexpected error occurred. Please try again.']);
      }
    },
    [data, isEditMode, selectedEvent?.id, reset],
  );

  const handleDelete = useCallback(async () => {
    if (!selectedEvent?.id) return;

    try {
      const response = await fetch(`/api/calendar/bookings/${selectedEvent.id}`, { method: 'DELETE', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' } });

      if (!response.ok) throw new Error('Failed to delete booking');

      setShowBookingModal(false);
      reset();
      setSelectedEvent(null);
      setSelectedSlot(null);
      window.location.reload();
    } catch (error) {
      console.error('Error deleting booking:', error);
    }
  }, [selectedEvent?.id, reset]);

  return (
    <>
      {!fourthTechnician ? (
        <div className="mx-auto my-10 max-w-300 flex items-center justify-center h-96">
          <div className="text-center">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p className="mt-4 text-gray-600">Laddar kalender...</p>
          </div>
        </div>
      ) : (
        <EventCalendar
          className="mx-auto my-10 max-w-300"
          editable
          selectable
          droppable
          nowIndicator
          navLinks
          locale="sv"
          initialView="timeGridWeek"
          firstDay={1}
          timeZone="Europe/Stockholm"
          events={`/api/calendar/bookings?service_user_id=${fourthTechnician.id}`}
          resources="/calendar/resources"
          select={handleDateSelect}
          eventClick={handleEventClick}
          eventDrop={handleEventDrop}
          eventResize={handleEventResize}
          headerToolbar={{ left: '', center: '', right: '' }}
          slotMinTime="07:00:00"
          slotMaxTime="17:00:00"
          slotDuration="01:00:00"
          weekends={true}
          addButton={{ text: `${fourthTechnician.title}`, click() { setIsEditMode(false); setSelectedSlot({ start: new Date(), end: new Date(Date.now() + 60 * 60 * 1000), allDay: false }); setShowBookingModal(true); } }}
        />
      )}

      {showBookingModal && (
        <div className="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-black">
          <div className="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-lg bg-white p-6">
            <h2 className="mb-4 text-xl font-bold">{isEditMode ? 'Redigera Bokning' : 'Ny Bokning'}</h2>

            {successMessage && (
              <div className="mb-4 rounded-md bg-green-50 p-4"><div className="text-green-800">{successMessage}</div></div>
            )}

            {errors.length > 0 && (
              <div className="mb-4 rounded-md bg-red-50 p-4"><div className="text-red-800">{errors.map((error, index) => (<div key={index} className="mb-1">{error}</div>))}</div></div>
            )}

            <form onSubmit={handleSubmit} className="space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="mb-1 block text-sm font-medium text-gray-700">Datum</label>
                  <input type="date" value={data.service_date} onChange={(e) => setData('service_date', e.target.value)} className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required />
                </div>

                <div>
                  <label className="mb-1 block text-sm font-medium text-gray-700">Status</label>
                  <select value={data.status} onChange={(e) => setData('status', e.target.value)} className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="booked">Bokad</option>
                    <option value="confirmed">Bekräftad</option>
                    <option value="cancelled">Inställd</option>
                    <option value="completed">Genomförd</option>
                  </select>
                </div>
              </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Starttid
                                    </label>
                                    <input
                                        type="time"
                                        value={data.start_time}
                                        onChange={(e) =>
                                            setData(
                                                'start_time',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Sluttid
                                    </label>
                                    <input
                                        type="time"
                                        value={data.end_time}
                                        onChange={(e) =>
                                            setData('end_time', e.target.value)
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        required
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Kund
                                    </label>

                                    <div className="flex items-center space-x-3">
                                        <select
                                            value={data.booking_client_id}
                                            onChange={(e) =>
                                                setData(
                                                    'booking_client_id',
                                                    e.target.value,
                                                )
                                            }
                                            className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        >
                                            <option value="">Välj kund</option>
                                            {dropdownData.clients.map((client: any) => (
                                                <option key={client.id} value={client.id}>{client.name}</option>
                                            ))}
                                        </select>

                                        <button type="button" className="text-sm text-blue-600 hover:underline" onClick={() => { setShowNewClientForm((s) => !s); setNewClientErrors([]); }}>
                                            Lägg till ny kund
                                        </button>
                                    </div>

                                    {showNewClientForm && (
                                        <div className="mt-3 space-y-2 rounded-md border border-gray-200 p-3">
                                            {newClientErrors.length > 0 && (
                                                <div className="rounded-md bg-red-50 p-2 text-sm text-red-700">{newClientErrors.map((err, idx) => (<div key={idx}>{err}</div>))}</div>
                                            )}

                                            <input type="text" placeholder="Namn" value={newClient.name} onChange={(e) => setNewClient((c) => ({ ...c, name: e.target.value }))} className="w-full rounded-md border border-gray-300 px-3 py-2" />
                                            <input type="email" placeholder="E-post (valfritt)" value={newClient.email} onChange={(e) => setNewClient((c) => ({ ...c, email: e.target.value }))} className="w-full rounded-md border border-gray-300 px-3 py-2" />
                                            <input type="text" placeholder="Telefon (valfritt)" value={newClient.phone} onChange={(e) => setNewClient((c) => ({ ...c, phone: e.target.value }))} className="w-full rounded-md border border-gray-300 px-3 py-2" />

                                            <div className="flex justify-end">
                                                <button type="button" onClick={() => { setShowNewClientForm(false); setNewClient({ name: '', email: '', phone: '' }); setNewClientErrors([]); }} className="mr-2 rounded-md bg-gray-200 px-3 py-1 text-sm">Avbryt</button>

                                                <button type="button" disabled={newClientProcessing} onClick={async () => {
                                                    setNewClientErrors([]);
                                                    setNewClientProcessing(true);
                                                    try {
                                                        const res = await fetch('/api/calendar/clients', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                                            },
                                                            body: JSON.stringify(newClient),
                                                        });
                                                        const payload = await res.json();
                                                        if (!res.ok) {
                                                            if (payload.errors) {
                                                                const errs = Object.values(payload.errors).flat();
                                                                setNewClientErrors(errs as string[]);
                                                            } else if (payload.message) {
                                                                setNewClientErrors([payload.message]);
                                                            } else {
                                                                setNewClientErrors(['Ett fel uppstod.']);
                                                            }
                                                            setNewClientProcessing(false);
                                                            return;
                                                        }

                                                        setDropdownData((prev: any) => ({ ...prev, clients: [payload, ...prev.clients] }));
                                                        setData('booking_client_id', payload.id);
                                                        setShowNewClientForm(false);
                                                        setNewClient({ name: '', email: '', phone: '' });
                                                    } catch (err) {
                                                        console.error('Error creating client', err);
                                                        setNewClientErrors(['Ett fel uppstod.']);
                                                    } finally {
                                                        setNewClientProcessing(false);
                                                    }
                                                }} className="rounded-md bg-blue-600 px-3 py-1 text-white disabled:opacity-50 text-sm">{newClientProcessing ? 'Sparar...' : 'Skapa kund'}</button>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Tjänst
                                    </label>
                                    <select
                                        value={data.service_id}
                                        onChange={(e) =>
                                            setData(
                                                'service_id',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    >
                                        <option value="">Välj tjänst</option>
                                        {dropdownData.services.map(
                                            (service: any) => (
                                                <option
                                                    key={service.id}
                                                    value={service.id}
                                                >
                                                    {service.name}
                                                </option>
                                            ),
                                        )}
                                    </select>
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Plats
                                    </label>
                                    <select
                                        value={data.booking_location_id}
                                        onChange={(e) =>
                                            setData(
                                                'booking_location_id',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    >
                                        <option value="">Välj plats</option>
                                        {dropdownData.locations.map(
                                            (location: any) => (
                                                <option
                                                    key={location.id}
                                                    value={location.id}
                                                >
                                                    {location.name}
                                                </option>
                                            ),
                                        )}
                                    </select>
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Tekniker
                                    </label>
                                    <select
                                        value={data.service_user_id}
                                        onChange={(e) =>
                                            setData(
                                                'service_user_id',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    >
                                        <option value="">Välj tekniker</option>
                                        {dropdownData.serviceUsers.map(
                                            (user: any) => (
                                                <option
                                                    key={user.id}
                                                    value={user.id}
                                                >
                                                    {user.name}
                                                </option>
                                            ),
                                        )}
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-gray-700">
                                    Pris (SEK)
                                </label>
                                <input
                                    type="number"
                                    value={data.total_price}
                                    onChange={(e) =>
                                        setData('total_price', e.target.value)
                                    }
                                    className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    min="0"
                                    step="0.01"
                                />
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-gray-700">
                                    Interna anteckningar
                                </label>
                                <textarea
                                    value={data.notes}
                                    onChange={(e) =>
                                        setData('notes', e.target.value)
                                    }
                                    rows={3}
                                    className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                />
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-gray-700">
                                    Service anteckningar
                                </label>
                                <textarea
                                    value={data.service_note}
                                    onChange={(e) =>
                                        setData('service_note', e.target.value)
                                    }
                                    rows={3}
                                    className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                />
                            </div>

                            <div className="flex justify-between pt-4">
                                <div>
                                    {isEditMode && (
                                        <button
                                            type="button"
                                            onClick={handleDelete}
                                            className="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:outline-none"
                                        >
                                            Radera
                                        </button>
                                    )}
                                </div>

                                <div className="space-x-3">
                                    <button
                                        type="button"
                                        onClick={() => {
                                            setShowBookingModal(false);
                                            reset();
                                            setSelectedEvent(null);
                                            setSelectedSlot(null);
                                        }}
                                        className="rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400 focus:ring-2 focus:ring-gray-500 focus:outline-none"
                                    >
                                        Avbryt
                                    </button>

                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:opacity-50"
                                    >
                                        {processing
                                            ? 'Sparar...'
                                            : isEditMode
                                              ? 'Uppdatera'
                                              : 'Skapa'}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </>
    );
}
