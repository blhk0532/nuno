import { eventFormSchema } from '@/lib/validations';
import { Locale } from 'date-fns';
import { memo, useEffect, useMemo } from 'react';
import { UseFormReturn } from 'react-hook-form';
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '../ui/form';
import { Textarea } from '../ui/textarea';
import { DateSelector } from './ui/date-selector';
import { TimeSelector } from './ui/time-selector';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '../ui/select';
import type { CalendarCategoryOption } from '@/types/event';
import { z } from 'zod';
import type {
  CalendarBookingCalendar,
  CalendarClient,
  CalendarService,
  CalendarTechnician,
} from './types';

type EventFormValues = z.infer<typeof eventFormSchema>;

const FALLBACK_LOCATION = 'Location TBD';
const DEFAULT_TITLE = 'New Event';

type EventDetailsFormProps = {
  form: UseFormReturn<EventFormValues>;
  onSubmit: (values: EventFormValues) => void;
  locale: Locale;
  clients: CalendarClient[];
  services: CalendarService[];
  serviceUsers: CalendarTechnician[];
  calendars: CalendarBookingCalendar[];
  categoryOptions?: CalendarCategoryOption[];
};

const CLEAR_SELECTION_VALUE = '__none__';

export const EventDetailsForm = memo(
  ({
    form,
    onSubmit,
    locale,
    clients,
    services,
    serviceUsers,
    calendars,
    categoryOptions = [],
  }: EventDetailsFormProps) => {
    const serviceUserId = form.watch('service_user_id');
    const selectedClientId = form.watch('booking_client_id');
    const selectedServiceId = form.watch('service_id');

    const serviceUserCalendarMap = useMemo(() => {
      const map: Record<string, number> = {};

      serviceUsers.forEach((technician) => {
        if (technician.calendar_ids?.length) {
          map[String(technician.id)] = technician.calendar_ids[0];
        }
      });

      return map;
    }, [serviceUsers]);

    useEffect(() => {
      if (!serviceUserId) {
        return;
      }

      const preferredCalendarId = serviceUserCalendarMap[serviceUserId];
      const currentCalendar = form.getValues('booking_calendar_id');

      if (!currentCalendar && preferredCalendarId) {
        form.setValue('booking_calendar_id', String(preferredCalendarId));
      }
    }, [form, serviceUserCalendarMap, serviceUserId]);

    useEffect(() => {
      if (categoryOptions.length === 0) {
        return;
      }

      const currentCategory = form.getValues('category');
      const hasValidCategory = categoryOptions.some(
        (option) => option.value === currentCategory,
      );

      if (!currentCategory || !hasValidCategory) {
        form.setValue('category', categoryOptions[0].value);
      }
    }, [categoryOptions, form]);

    useEffect(() => {
      if (!selectedClientId) {
        form.setValue('title', DEFAULT_TITLE);
        return;
      }

      const client = clients.find((item) => String(item.id) === selectedClientId);

      if (client?.name) {
        form.setValue('title', client.name);
        return;
      }

      form.setValue('title', DEFAULT_TITLE);
    }, [clients, form, selectedClientId]);

    useEffect(() => {
      if (!selectedServiceId) {
        form.setValue('total_price', undefined);
        return;
      }

      const service = services.find((item) => String(item.id) === selectedServiceId);

      if (service?.price !== undefined && service?.price !== null) {
        form.setValue('total_price', service.price.toFixed(2));
        return;
      }

      form.setValue('total_price', undefined);
    }, [form, selectedServiceId, services]);

    useEffect(() => {
      const currentLocation = form.getValues('location');

      if (!selectedClientId) {
        if (!currentLocation || currentLocation === FALLBACK_LOCATION) {
          form.setValue('location', FALLBACK_LOCATION);
        }
        return;
      }

      const client = clients.find((item) => String(item.id) === selectedClientId);

      if (!client) {
        if (!currentLocation || currentLocation === FALLBACK_LOCATION) {
          form.setValue('location', FALLBACK_LOCATION);
        }
        return;
      }

      const addressParts = [client.address, client.city]
        .filter(Boolean)
        .map((part) => part?.toString().trim())
        .filter(Boolean);

      form.setValue('location', addressParts.join(', ') || FALLBACK_LOCATION);
    }, [clients, form, selectedClientId]);

    return (
      <Form {...form}>
        <form
          onSubmit={form.handleSubmit(onSubmit)}
          className="grid gap-5 px-2 py-3"
          data-testid="event-form"
        >
          <input type="hidden" {...form.register('google_event_id')} />
          <input type="hidden" {...form.register('title')} />
          <input type="hidden" {...form.register('category')} />
          <input type="hidden" {...form.register('color')} />
          <input type="hidden" {...form.register('location')} />
          <input type="hidden" {...form.register('total_price')} />
          {/* Title hidden; derived from selected client */}
          <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <FormField
              control={form.control}
              name="booking_client_id"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Client</FormLabel>
                  <FormControl>
                    <Select
                      onValueChange={(value) =>
                        field.onChange(
                          value === CLEAR_SELECTION_VALUE ? undefined : value,
                        )
                      }
                      value={field.value}
                    >
                      <FormControl>
                        <SelectTrigger className="w-full">
                          <SelectValue placeholder="Select a client" />
                        </SelectTrigger>
                      </FormControl>
                      <SelectContent>
                        <SelectItem value={CLEAR_SELECTION_VALUE}>
                          No client (optional)
                        </SelectItem>
                        {clients.length === 0 && (
                          <SelectItem value="__no-clients__" disabled>
                            No clients available yet
                          </SelectItem>
                        )}
                        {clients.map((client) => (
                          <SelectItem
                            key={client.id}
                            value={String(client.id)}
                          >
                            {client.name}
                            {client.email && ` · ${client.email}`}
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormField
              control={form.control}
              name="service_id"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Service</FormLabel>
                  <FormControl>
                    <Select
                      onValueChange={(value) =>
                        field.onChange(
                          value === CLEAR_SELECTION_VALUE ? undefined : value,
                        )
                      }
                      value={field.value}
                    >
                      <FormControl>
                        <SelectTrigger className="w-full">
                          <SelectValue placeholder="Select a service" />
                        </SelectTrigger>
                      </FormControl>
                      <SelectContent>
                        <SelectItem value={CLEAR_SELECTION_VALUE}>
                          No service selected
                        </SelectItem>
                        {services.length === 0 && (
                          <SelectItem value="__no-services__" disabled>
                            No services available yet
                          </SelectItem>
                        )}
                        {services.map((service) => (
                          <SelectItem
                            key={service.id}
                            value={String(service.id)}
                          >
                            {service.name}
                            {service.duration && ` · ${service.duration}m`}
                            {service.price && ` · ${service.price} SEK`}
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />
          </div>
          <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <FormField
              control={form.control}
              name="service_user_id"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Technician</FormLabel>
                  <FormControl>
                    <Select
                      onValueChange={(value) =>
                        field.onChange(
                          value === CLEAR_SELECTION_VALUE ? undefined : value,
                        )
                      }
                      value={field.value}
                    >
                      <FormControl>
                        <SelectTrigger className="w-full">
                          <SelectValue placeholder="Select a technician" />
                        </SelectTrigger>
                      </FormControl>
                      <SelectContent>
                        <SelectItem value={CLEAR_SELECTION_VALUE}>
                          No technician selected
                        </SelectItem>
                        {serviceUsers.length === 0 && (
                          <SelectItem value="__no-technicians__" disabled>
                            No technicians available
                          </SelectItem>
                        )}
                        {serviceUsers.map((technician) => (
                          <SelectItem
                            key={technician.id}
                            value={String(technician.id)}
                          >
                            {technician.name}
                            {technician.email && ` · ${technician.email}`}
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormField
              control={form.control}
              name="booking_calendar_id"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Calendar</FormLabel>
                  <FormControl>
                    <Select
                      onValueChange={(value) =>
                        field.onChange(
                          value === CLEAR_SELECTION_VALUE ? undefined : value,
                        )
                      }
                      value={field.value}
                    >
                      <FormControl>
                        <SelectTrigger className="w-full">
                          <SelectValue placeholder="Select a calendar" />
                        </SelectTrigger>
                      </FormControl>
                      <SelectContent>
                        <SelectItem value={CLEAR_SELECTION_VALUE}>
                          No calendar selected
                        </SelectItem>
                        {calendars.length === 0 && (
                          <SelectItem value="__no-calendars__" disabled>
                            No calendars configured
                          </SelectItem>
                        )}
                        {calendars.map((calendar) => (
                          <SelectItem
                            key={calendar.id}
                            value={String(calendar.id)}
                          >
                            {calendar.name}
                            {calendar.owner_id && ` · ${calendar.owner_id}`}
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />
          </div>
          <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <FormField
              control={form.control}
              name="startDate"
              render={({ field }) => (
                <DateSelector
                  value={field.value}
                  onChange={field.onChange}
                  label="Start Date"
                  locale={locale}
                  required
                />
              )}
            />
            <FormField
              control={form.control}
              name="startTime"
              render={({ field }) => (
                <TimeSelector
                  value={field.value}
                  onChange={field.onChange}
                  label="Start Time"
                  required
                />
              )}
            />
          </div>
          <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <FormField
              control={form.control}
              name="endDate"
              render={({ field }) => (
                <DateSelector
                  value={field.value}
                  onChange={field.onChange}
                  label="End Date"
                  locale={locale}
                  required
                />
              )}
            />
            <FormField
              control={form.control}
              name="endTime"
              render={({ field }) => (
                <TimeSelector
                  value={field.value}
                  onChange={field.onChange}
                  label="End Time"
                  required
                />
              )}
            />
          </div>
          <div className="grid grid-cols-1 gap-4">
            <FormField
              control={form.control}
              name="description"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Description</FormLabel>
                  <FormControl>
                    <Textarea
                      placeholder="Short description of the event"
                      rows={3}
                      {...field}
                      value={field.value || ''}
                    />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />
          </div>
        </form>
      </Form>
    );
  },
);

EventDetailsForm.displayName = 'EventDetailsForm';
