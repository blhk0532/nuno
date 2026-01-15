'use client';

import { ChevronLeft, ChevronRight, Plus } from 'lucide-react';
import { Button } from '../ui/button';
import { TimeFormatToggle } from './ui/time-format-toggel';
import { TodayButton } from './ui/today-button';
import { ViewModeToggle } from './ui/view-mode-toggle';
import { SearchYearPicker } from './ui/search-year-picker';
import { SearchMonthPicker } from './ui/search-month-picker';
import { SearchDayPicker } from './ui/search-day-picker';
import { CalendarViewType, TimeFormatType, ViewModeType } from '@/types/event';
import { useEventCalendarStore } from '@/hooks/use-event';
import { EventCalendarTabs } from './event-calendar-tabs';
import { useShallow } from 'zustand/shallow';
import { useCallback, useEffect, useState } from 'react';
import {
  addDays,
  addMonths,
  addWeeks,
  addYears,
  subDays,
  subMonths,
  subWeeks,
  subYears,
} from 'date-fns';
import { EventCalendarFilters } from './event-calendar-filters';
import CalendarSettingsDialog from './event-calendar-setting-dialog';
import { getLocaleFromCode } from '@/lib/event';
import type { IUser } from '@/components/calendar/interfaces';
import type { CalendarTechnician } from '@/components/event-calendar/types';
import type { CalendarCategoryOption } from '@/types/event';

interface EventCalendarToolbarProps {
  users?: IUser[];
  selectedTechnicianId?: string;
  onTechnicianChange?: (id: string) => void;
  totalEvents?: number;
  categoryOptions?: CalendarCategoryOption[];
  currentDate: Date;
  onDateChange: (date: Date) => void;
}

type TechnicianMap = Record<string, CalendarTechnician>;

export default function EventCalendarToolbar({
  users,
  selectedTechnicianId,
  onTechnicianChange,
  totalEvents,
  categoryOptions,
  currentDate,
  onDateChange,
}: EventCalendarToolbarProps) {
  const [technicians, setTechnicians] = useState<TechnicianMap>({});
  const {
    viewMode,
    locale,
    timeFormat,
    currentView,
    setView,
    setTimeFormat,
    setMode,
    openQuickAddDialog,
    setQuickAddDefaults,
  } = useEventCalendarStore(
    useShallow((state) => ({
      viewMode: state.viewMode,
      locale: state.locale,
      timeFormat: state.timeFormat,
      currentView: state.currentView,
      setView: state.setView,
      setTimeFormat: state.setTimeFormat,
      setMode: state.setMode,
      openQuickAddDialog: state.openQuickAddDialog,
      setQuickAddDefaults: state.setQuickAddDefaults,
    })),
  );
  const localeObj = getLocaleFromCode(locale);

  const handleNavigateNext = useCallback(() => {
    let newDate = new Date(currentDate);

    switch (currentView) {
      case 'day':
        newDate = addDays(newDate, 1);
        break;
      case 'week':
        newDate = addWeeks(newDate, 1);
        break;
      case 'month':
        newDate = addMonths(newDate, 1);
        break;
      case 'year':
        newDate = addYears(newDate, 1);
        break;
    }

    onDateChange(newDate);
  }, [currentDate, currentView, onDateChange]);

  const handleNavigatePrevious = useCallback(() => {
    let newDate = new Date(currentDate);

    switch (currentView) {
      case 'day':
        newDate = subDays(newDate, 1);
        break;
      case 'week':
        newDate = subWeeks(newDate, 1);
        break;
      case 'month':
        newDate = subMonths(newDate, 1);
        break;
      case 'year':
        newDate = subYears(newDate, 1);
        break;
    }

    onDateChange(newDate);
  }, [currentDate, currentView, onDateChange]);

  const handleTimeFormatChange = useCallback(
    (format: TimeFormatType) => {
      setTimeFormat(format);
    },
    [setTimeFormat],
  );

  const handleViewModeChange = useCallback(
    (mode: ViewModeType) => {
      setMode(mode);
    },
    [setMode],
  );

  const handleViewTypeChange = useCallback(
    (viewType: CalendarViewType) => {
      setView(viewType);
    },
    [setView],
  );

  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === 'ArrowLeft') handleNavigatePrevious();
      if (e.key === 'ArrowRight') handleNavigateNext();
    };

    window.addEventListener('keydown', handleKeyDown);
    return () => window.removeEventListener('keydown', handleKeyDown);
  }, [handleNavigatePrevious, handleNavigateNext]);

  useEffect(() => {
    const fetchTechnicians = async () => {
      try {
        const response = await fetch('/api/calendar/service-users');
        if (!response.ok) throw new Error('Failed to fetch technicians');

        const data = (await response.json()) as CalendarTechnician[];
        const map: TechnicianMap = {};
        data.forEach((tech) => {
          map[String(tech.id)] = tech;
        });
        setTechnicians(map);
      } catch (error) {
        console.error('Error fetching technicians:', error);
      }
    };

    fetchTechnicians();
  }, []);

  useEffect(() => {
    if (!selectedTechnicianId || selectedTechnicianId === 'all') {
      setQuickAddDefaults({
        service_user_id: undefined,
        booking_calendar_id: undefined,
        google_event_id: undefined,
      });
      return;
    }

    const technician = technicians[selectedTechnicianId];
    const calendarId = technician?.calendar_ids?.[0];

    setQuickAddDefaults({
      service_user_id: selectedTechnicianId,
      booking_calendar_id: calendarId ? String(calendarId) : undefined,
      google_event_id: undefined,
    });
  }, [selectedTechnicianId, technicians, setQuickAddDefaults]);

  return (
    <div className="flex flex-col">
      <div className="flex flex-col space-y-2 px-4 pt-3 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
        <div className="flex items-center space-x-3">
          <div className="flex w-full flex-col items-center justify-between gap-5 space-x-2 sm:flex-row sm:gap-0">
            <div className="flex w-full items-center justify-around sm:hidden">
              <Button
                variant="outline"
                className="hover:bg-muted rounded-full"
                onClick={handleNavigatePrevious}
              >
                <ChevronLeft className="h-4 w-4" />
                Previous
              </Button>
              <Button
                variant={'outline'}
                className="hover:bg-muted rounded-full"
                onClick={handleNavigateNext}
              >
                <ChevronRight className="h-4 w-4" />
                Next
              </Button>
            </div>
            <Button
              variant="ghost"
              size="icon"
              className="hover:bg-muted hidden h-8 w-8 rounded-full sm:block"
              onClick={handleNavigatePrevious}
            >
              <ChevronLeft className="h-4 w-4" />
            </Button>
            <div className="flex items-center space-x-2">
              {currentView === 'day' && (
                <SearchDayPicker
                  locale={localeObj}
                  weekStartsOn={0}
                  placeholder="Select day"
                />
              )}
              {currentView !== 'year' && (
                <SearchMonthPicker locale={localeObj} monthFormat="LLLL" />
              )}
              <SearchYearPicker yearRange={20} minYear={2000} maxYear={2030} />
            </div>
            <Button
              variant="ghost"
              size="icon"
              className="hover:bg-muted hidden h-8 w-8 rounded-full sm:block"
              onClick={handleNavigateNext}
            >
              <ChevronRight className="h-4 w-4" />
            </Button>
          </div>
        </div>
        <div className="flex items-center justify-center space-x-3 sm:justify-start">
          <TodayButton
            viewType={currentView}
            currentDate={currentDate}
            onDateChange={onDateChange}
          />
          <Button
            onClick={() => openQuickAddDialog({ date: new Date() })}
            className="h-9 gap-1.5 px-3"
          >
            <Plus className="h-3.5 w-3.5" />
            Add Event
          </Button>
        </div>
      </div>
      <EventCalendarFilters
        users={users}
        selectedTechnicianId={selectedTechnicianId}
        onTechnicianChange={onTechnicianChange}
        totalEvents={totalEvents}
        categoryOptions={categoryOptions}
      />
      <div className="bg-muted/30 flex items-center justify-between border-b px-4 py-2">
        <EventCalendarTabs
          viewType={currentView}
          onChange={handleViewTypeChange}
        />
        <div className="flex items-center sm:space-x-2">
          <TimeFormatToggle
            format={timeFormat}
            onChange={handleTimeFormatChange}
          />
          <ViewModeToggle mode={viewMode} onChange={handleViewModeChange} />
          <CalendarSettingsDialog />
        </div>
      </div>
    </div>
  );
}
