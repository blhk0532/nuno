'use client';

import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { useEventCalendarStore } from '@/hooks/use-event';
import { zodResolver } from '@hookform/resolvers/zod';
import { Save } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '../ui/dialog';
import { ScrollArea } from '../ui/scroll-area';
import { EventDetailsForm } from './event-detail-form';
import { EventPreviewCalendar } from './event-preview-calendar';
import { createEventSchema } from '@/lib/validations';
import { EVENT_DEFAULTS } from '@/constants/calendar-constant';
import { useShallow } from 'zustand/shallow';
import { toast } from 'sonner';
import { createEvent } from '@/app/actions';
import { getLocaleFromCode } from '@/lib/event';
import { useBookingDropdowns } from './hooks/use-booking-dropdowns';
import type { CalendarCategoryOption } from '@/types/event';

type EventFormValues = z.infer<typeof createEventSchema>;

type EventCreateDialogProps = {
  categoryOptions?: CalendarCategoryOption[];
};

const DEFAULT_FORM_VALUES: EventFormValues = {
  title: '',
  description: '',
  startDate: new Date(),
  endDate: new Date(),
  category: '',
  startTime: EVENT_DEFAULTS.START_TIME,
  endTime: EVENT_DEFAULTS.END_TIME,
  location: 'Location TBD',
  color: EVENT_DEFAULTS.COLOR,
  isRepeating: false,
  booking_client_id: undefined,
  service_id: undefined,
  service_user_id: undefined,
  booking_calendar_id: undefined,
  google_event_id: undefined,
  total_price: undefined,
};

export default function EventCreateDialog({
  categoryOptions = [],
}: EventCreateDialogProps) {
  const {
    isQuickAddDialogOpen,
    closeQuickAddDialog,
    timeFormat,
    locale,
    quickAddData,
  } = useEventCalendarStore(
    useShallow((state) => ({
      isQuickAddDialogOpen: state.isQuickAddDialogOpen,
      closeQuickAddDialog: state.closeQuickAddDialog,
      timeFormat: state.timeFormat,
      locale: state.locale,
      quickAddData: state.quickAddData,
    })),
  );
  const form = useForm<EventFormValues>({
    resolver: zodResolver(createEventSchema),
    defaultValues: DEFAULT_FORM_VALUES,
    mode: 'onChange',
  });
  const [isSubmitting, setIsSubmitting] = useState(false);
  const localeObj = getLocaleFromCode(locale);

  const {
    clients,
    services,
    technicians,
    calendars,
    loading: dropdownLoading,
    error,
    refetch,
  } = useBookingDropdowns();

  const watchedValues = form.watch();

  const handleSubmit = async (formValues: EventFormValues) => {
    setIsSubmitting(true);

    toast.promise(createEvent(formValues), {
      loading: 'Creating Event...',
      success: (result) => {
        if (!result.success) {
          throw new Error(result.error || 'Error Creating Event');
        }
        form.reset(DEFAULT_FORM_VALUES);
        setIsSubmitting(false);
        closeQuickAddDialog();
        return 'Event Succesfully created';
      },
      error: (error) => {
        console.error('Error:', error);
        if (error instanceof Error) {
          return error.message;
        } else if (typeof error === 'string') {
          return error;
        } else if (error && typeof error === 'object' && 'message' in error) {
          return String(error.message);
        }
        return 'Ops! something went wrong';
      },
    });
  };

  useEffect(() => {
    if (isQuickAddDialogOpen && quickAddData.date) {
      form.reset({
        ...DEFAULT_FORM_VALUES,
        startDate: quickAddData.date,
        endDate: quickAddData.date,
        startTime: quickAddData.startTime,
        endTime: quickAddData.endTime,
        service_user_id: quickAddData.service_user_id,
        booking_calendar_id: quickAddData.booking_calendar_id,
        google_event_id: quickAddData.google_event_id,
      });
    }
  }, [isQuickAddDialogOpen, quickAddData, form]);

  return (
    <Dialog
      open={isQuickAddDialogOpen}
      onOpenChange={(open) => !open && closeQuickAddDialog()}
      modal={false}
    >
      <DialogContent className="sm:max-w-[550px]">
        <DialogHeader>
          <DialogTitle>Add New Event</DialogTitle>
          <DialogDescription>
            Fill in the event details to add it to the calendar
          </DialogDescription>
        </DialogHeader>
          {error && (
            <div className="rounded border border-destructive/40 bg-destructive/10 p-3 text-sm text-destructive">
              Failed to load dropdown data.{' '}
              <button
                type="button"
                className="underline"
                onClick={() => refetch()}
              >
                Retry
              </button>
            </div>
          )}
        <Tabs className="w-full" defaultValue="edit">
          <TabsList className="grid w-full grid-cols-2">
            <TabsTrigger value="edit">Edit</TabsTrigger>
            <TabsTrigger value="preview">Preview</TabsTrigger>
          </TabsList>
          <TabsContent value="edit" className="mt-4">
            <ScrollArea className="h-[500px] w-full">
              <EventDetailsForm
                form={form}
                onSubmit={handleSubmit}
                locale={localeObj}
                clients={clients}
                services={services}
                serviceUsers={technicians}
                calendars={calendars}
                categoryOptions={categoryOptions}
              />
            </ScrollArea>
          </TabsContent>
          <TabsContent value="preview" className="mt-4">
            <ScrollArea className="h-[500px] w-full">
              <EventPreviewCalendar
                watchedValues={watchedValues}
                locale={localeObj}
                timeFormat={timeFormat}
                categoryOptions={categoryOptions}
              />
            </ScrollArea>
          </TabsContent>
        </Tabs>
        <DialogFooter className="mt-2">
          <Button
            onClick={form.handleSubmit(handleSubmit)}
            className="cursor-pointer"
            disabled={isSubmitting || dropdownLoading}
          >
            <Save className="mr-2 h-4 w-4" />
            {isSubmitting ? 'Saving' : 'Save'}
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}
