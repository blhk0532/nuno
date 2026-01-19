import { EventCalendar } from '@/components/event-calendar';
import { useForm } from '@inertiajs/react';
import { useCallback, useEffect, useState } from 'react';

export function EventCalendarDemo1() {
    const [showBookingModal, setShowBookingModal] = useState(false);
    const [selectedSlot, setSelectedSlot] = useState<any>(null);
    const [selectedEvent, setSelectedEvent] = useState<any>(null);
    const [isEditMode, setIsEditMode] = useState(false);
    const [dropdownData, setDropdownData] = useState({
        clients: [],
        services: [],
        locations: [],
        serviceUsers: [],
        calendars: [],
    });
    const [firstTechnician, setFirstTechnician] = useState<any>(null);
    const [showNewClientForm, setShowNewClientForm] = useState(false);
    const [newClient, setNewClient] = useState({ name: '', email: '', phone: '' });
    const [newClientErrors, setNewClientErrors] = useState<string[]>([]);
    const [newClientProcessing, setNewClientProcessing] = useState(false);
    const [errors, setErrors] = useState<string[]>([]);
    const [successMessage, setSuccessMessage] = useState<string>('');

    const {
        data,
        setData,
        post,
        put,
        delete: destroy,
        processing,
        reset,
    } = useForm({
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

    // Load first technician ASAP to show calendar quickly
    useEffect(() => {
        const loadFirstTechnician = async () => {
            try {
                const resourcesRes = await fetch('/calendar/resources');
                const resources = await resourcesRes.json();

                if (resources && resources.length > 0) {
                    setFirstTechnician(resources[0]);
                }
            } catch (error) {
                console.error('Error loading technicians:', error);
            }
        };

        loadFirstTechnician();
    }, []);

    // Load dropdown data separately (doesn't block calendar display)
    useEffect(() => {
        const loadDropdownData = async () => {
            try {
                const [
                    clientsRes,
                    servicesRes,
                    locationsRes,
                    usersRes,
                    calendarsRes,
                ] = await Promise.all([
                    fetch('/api/calendar/clients'),
                    fetch('/api/calendar/services'),
                    fetch('/api/calendar/locations'),
                    fetch('/api/calendar/service-users'),
                    fetch('/api/calendar/calendars'),
                ]);

                const [clients, services, locations, serviceUsers, calendars] =
                    await Promise.all([
                        clientsRes.json(),
                        servicesRes.json(),
                        locationsRes.json(),
                        usersRes.json(),
                        calendarsRes.json(),
                    ]);

                setDropdownData({
                    clients,
                    services,
                    locations,
                    serviceUsers,
                    calendars,
                });
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

            setSelectedSlot({
                start: start,
                end: end,
                allDay: info.allDay,
                resourceId: info.resource?.id,
            });

            // Pre-fill form with selected date/time
            setData((currentData) => ({
                ...currentData,
                service_date: start.toISOString().split('T')[0],
                start_time: start.toTimeString().slice(0, 5),
                end_time: end ? end.toTimeString().slice(0, 5) : '',
                service_user_id: info.resource?.id || '',
            }));

            setIsEditMode(false);
            setShowBookingModal(true);
        },
        [data, setData],
    );

    const handleEventClick = useCallback(
        (info: any) => {
            const event = info.event;

            setSelectedEvent({
                id: event.id,
                title: event.title,
                start: event.start,
                end: event.end,
                extendedProps: event.extendedProps,
            });

            // Pre-fill form with event data for editing
            const props = event.extendedProps;
            setData((currentData) => ({
                ...currentData,
                service_date:
                    props.service_date ||
                    event.start?.toISOString().split('T')[0] ||
                    '',
                start_time:
                    props.start_time ||
                    event.start?.toTimeString().slice(0, 5) ||
                    '',
                end_time:
                    props.end_time ||
                    event.end?.toTimeString().slice(0, 5) ||
                    '',
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
            const response = await fetch(
                `/api/calendar/bookings/${event.id}/move`,
                {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || '',
                    },
                    body: JSON.stringify({
                        start: newStart.toISOString(),
                        end: newEnd ? newEnd.toISOString() : null,
                        resource_id: resourceId,
                    }),
                },
            );

            if (!response.ok) {
                throw new Error('Failed to move booking');
                info.revert();
            }

            // Refresh calendar events
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
            const response = await fetch(
                `/api/calendar/bookings/${event.id}/resize`,
                {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || '',
                    },
                    body: JSON.stringify({
                        end: newEnd.toISOString(),
                    }),
                },
            );

            if (!response.ok) {
                throw new Error('Failed to resize booking');
                info.revert();
            }

            // Refresh calendar events
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
                const url = isEditMode
                    ? `/api/calendar/bookings/${selectedEvent?.id}`
                    : '/api/calendar/bookings';

                const method = isEditMode ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || '',
                    },
                    body: JSON.stringify(data),
                });

                const responseData = await response.json();

                if (!response.ok) {
                    if (responseData.errors) {
                        const errorMessages = Object.values(
                            responseData.errors,
                        ).flat() as string[];
                        setErrors(errorMessages);
                    } else {
                        setErrors([
                            responseData.message ||
                                `Failed to ${isEditMode ? 'update' : 'create'} booking`,
                        ]);
                    }
                    return;
                }

                // Close modal and refresh calendar
                setSuccessMessage(
                    responseData.message ||
                        `Booking ${isEditMode ? 'updated' : 'created'} successfully`,
                );
                setTimeout(() => {
                    setShowBookingModal(false);
                    reset();
                    setSelectedEvent(null);
                    setSelectedSlot(null);
                    window.location.reload();
                }, 1500);
            } catch (error) {
                console.error(
                    `Error ${isEditMode ? 'updating' : 'creating'} booking:`,
                    error,
                );
                setErrors(['An unexpected error occurred. Please try again.']);
            }
        },
        [data, isEditMode, selectedEvent?.id, reset],
    );

    const handleDelete = useCallback(async () => {
        if (!selectedEvent?.id) return;

        try {
            const response = await fetch(
                `/api/calendar/bookings/${selectedEvent.id}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || '',
                    },
                },
            );

            if (!response.ok) {
                throw new Error('Failed to delete booking');
            }

            // Close modal and refresh calendar
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
            {!firstTechnician ? (
                <div className="mx-auto my-10 max-w-300 flex items-center justify-center h-96">
                    <div className="text-center">
                        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-black dark:border-white mx-auto mb-4"></div>
                                      <svg version="1.2" id="nordic-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 336" width="200" height="34" fill="currentColor">
    <g><path fillRule="evenodd" className="s0" d="m1245.5 13.5q39 0 78 0 0.25 104-0.5 208-7.73 69.72-72.5 96.5-81.51 23.59-131.5-44.5-35.41-60.78 1-121 47.62-63.63 125.5-45 0-47 0-94zm-73 200q4.85 39.91 45 39.5 31.97-6.41 35-39-5.71-41.96-48-39.5-29.03 8.55-32 39z"></path></g>
    <g><path fillRule="evenodd" className="s0" d="m655.5 101.5q73.88-5.44 112.5 57 31.23 64.88-11 123-49.57 55.58-121.5 35.5-62.5-23.77-74.5-89.5-6.8-72.15 53.5-111.5 19.47-10.74 41-14.5zm-10 79.5q-23.59 23.82-7.5 53.5 21.72 25.85 52.5 11.5 20.62-12.99 19.5-37.5-7.55-39.17-47.5-36-9.15 2.65-17 8.5z"></path></g>
    <g><path fillRule="evenodd" className="s0" d="m1623.5 101.5q54.97-5.93 94 32.5-24.5 24.5-49 49-1.5 1-3 0-19.76-16.75-44-7-27.69 16.05-20.5 47.5 15.61 36.43 53.5 24.5 7.07-3.08 12.5-8.5 25.25 25.25 50.5 50.5-54.66 49.83-124 23-54.24-26.7-64.5-86.5-5.65-83.98 70.5-118.5 12.06-3.76 24-6.5z"></path></g>
    <g><path fillRule="evenodd" className="s0" d="m381.5 106.5q59 0 118 0 0 105 0 210-42 0-84 0 0-63 0-126-27 0-54 0 0 63 0 126-43 0-86 0-0.25-52 0.5-104 53.05-52.8 105.5-106z"></path></g>
    <g><path fillRule="evenodd" className="s0" d="m944.5 106.5q50 0 100 0 0 42 0 84-60 0-120 0 0 63 0 126-43 0-86 0-0.25-52 0.5-104 53.05-52.8 105.5-106z"></path></g>
    <g><path fillRule="evenodd" className="s0" d="m1385.5 106.5q42 0 84 0 0 105 0 210-42 0-84 0 0-105 0-210z"></path></g>
</svg>
                        <p className="mt-2 text-gray-600">Laddar kalender...</p>
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
                    events={`/api/calendar/bookings?service_user_id=${firstTechnician.id}`}
                    resources="/calendar/resources"
                    select={handleDateSelect}
                    eventClick={handleEventClick}
                    eventDrop={handleEventDrop}
                    eventResize={handleEventResize}
                    headerToolbar={{
                        left: '',
                        center: '',
                        right: '',
                    }}
                    slotMinTime="07:00:00"
                    slotMaxTime="17:00:00"
                    slotDuration="01:00:00"
                    weekends={true}
                    addButton={{
                        text: `${firstTechnician.title}`,
                        click() {
                            setIsEditMode(false);
                            setSelectedSlot({
                                start: new Date(),
                                end: new Date(Date.now() + 60 * 60 * 1000), // +1 hour
                                allDay: false,
                            });
                            setShowBookingModal(true);
                        },
                    }}
                />
            )}

            {/* Booking Modal */}
            {showBookingModal && (
                <div className="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center">
                    <div className="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-[550px]">
                        <h2 className="mb-4 text-xl font-bold">
                            {isEditMode ? 'Redigera Bokning' : 'Ny Bokning'}
                        </h2>

                        {/* Success Message */}
                        {successMessage && (
                            <div className="mb-4 rounded-md bg-green-50 p-4">
                                <div className="text-green-800">
                                    {successMessage}
                                </div>
                            </div>
                        )}

                        {/* Error Messages */}
                        {errors.length > 0 && (
                            <div className="mb-4 rounded-md bg-red-50 p-4">
                                <div className="text-red-800">
                                    {errors.map((error, index) => (
                                        <div key={index} className="mb-1">
                                            {error}
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Datum
                                    </label>
                                    <input
                                        type="date"
                                        value={data.service_date}
                                        onChange={(e) =>
                                            setData(
                                                'service_date',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-medium text-gray-700">
                                        Status
                                    </label>
                                    <select
                                        value={data.status}
                                        onChange={(e) =>
                                            setData('status', e.target.value)
                                        }
                                        className="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    >
                                        <option value="booked">Bokad</option>
                                        <option value="confirmed">
                                            Bekräftad
                                        </option>
                                        <option value="cancelled">
                                            Inställd
                                        </option>
                                        <option value="completed">
                                            Genomförd
                                        </option>
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
                                                <div className="rounded-md bg-red-50 p-2 text-sm text-red-700">
                                                    {newClientErrors.map((err, idx) => (
                                                        <div key={idx}>{err}</div>
                                                    ))}
                                                </div>
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

                                                        // success: add to dropdown and select
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
