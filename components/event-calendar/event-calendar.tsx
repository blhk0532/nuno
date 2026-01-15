'use client';

import { EventsList } from './event-list';
import { EventCalendarDay } from './event-calendar-day';
import { EventCalendarWeek } from './event-calendar-week';
import EventDialog from './event-dialog';
import { useEventCalendarStore } from '@/hooks/use-event';
import { EventCalendarMonth } from './event-calendar-month';
import { MonthDayEventsDialog } from './day-events-dialog';
import EventCreateDialog from './event-create-dialog';
import { useShallow } from 'zustand/shallow';
import { useMemo, useState } from 'react';
import { EventCalendarYear } from './event-calendar-year';
import { EventCalendarDays } from './event-calendar-days';
import CalendarToolbar from './event-calendar-toolbar';
import { Events } from '@/resources/js/types/event';

interface EventCalendarProps {
  events: Events[];
  initialDate: Date;
}

export function EventCalendar({ initialDate, events }: EventCalendarProps) {
  const { viewMode, currentView, daysCount } = useEventCalendarStore(
    useShallow((state) => ({
      viewMode: state.viewMode,
      currentView: state.currentView,
      daysCount: state.daysCount,
    })),
  );

  const [currentDate, setCurrentDate] = useState(initialDate);

  const renderCalendarView = useMemo(() => {
    if (viewMode === 'list') {
      return <EventsList events={events} currentDate={currentDate} />;
    }
    switch (currentView) {
      case 'day':
        return <EventCalendarDay events={events} currentDate={currentDate} />;
      case 'days':
        return (
          <EventCalendarDays
            events={events}
            daysCount={daysCount}
            currentDate={currentDate}
          />
        );
      case 'week':
        return <EventCalendarWeek events={events} currentDate={currentDate} />;
      case 'month':
        return <EventCalendarMonth events={events} baseDate={currentDate} />;
      case 'year':
        return <EventCalendarYear events={events} currentDate={currentDate} />;
      default:
        return <EventCalendarDay events={events} currentDate={currentDate} />;
    }
  }, [currentView, daysCount, events, currentDate, viewMode]);

  return (
    <>
      <EventDialog />
      <MonthDayEventsDialog />
      <EventCreateDialog />
      <div className="bg-background overflow-hidden rounded-xl border shadow-sm">
        <CalendarToolbar
          currentDate={currentDate}
          onDateChange={setCurrentDate}
        />
        <div className="overflow-hidden p-0">{renderCalendarView}</div>
      </div>
    </>
  );
}
