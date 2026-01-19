'use client';

import { useState, useMemo, useRef, useCallback } from 'react';
import { formatDate, generateTimeSlots, getCurrentTimeInSweden, formatTimeDisplay } from '@/lib/date';
import { isSameDay, format } from 'date-fns';
import { ScrollArea } from '../ui/scroll-area';
import { Events, HoverPositionType } from '@/types/event';
import { WeekDayHeaders } from './ui/week-days-header';
import { TimeColumn } from './ui/time-column';
import { CurrentTimeIndicator } from './ui/current-time-indicator';
import { HoverTimeIndicator } from './ui/hover-time-indicator';
import { TimeGrid } from './ui/time-grid';
import { EventDialogTrigger } from './event-dialog-trigger';
import {
  getLocaleFromCode,
  useEventPositions,
  useFilteredEvents,
  useMultiDayEventRows,
  useWeekDays,
} from '@/lib/event';
import { useEventCalendarStore } from '@/hooks/use-event';
import { useShallow } from 'zustand/shallow';
import { Button } from '../ui/button';
import { ChevronDown, ChevronUp } from 'lucide-react';
import { MultiDayEventSection } from './ui/multi-day-event';
import { cn } from '@/lib/utils';
import { Tooltip, TooltipContent, TooltipTrigger } from '../ui/tooltip';

const HOUR_HEIGHT = 64; // Height in pixels for 1 hour
const START_HOUR = 7; // 08:00
const END_HOUR = 17; // 18:00
const DAYS_IN_WEEK = 7;
const DAY_WIDTH_PERCENT = 100 / DAYS_IN_WEEK;
const MULTI_DAY_ROW_HEIGHT = 64;

const getLocationDisplay = (event: Events): string => {
  if (!event.location) return event.title;
  
  const technicianName = event.technicianName || '';
  if (!technicianName) return event.location;
  
  // Get first and last letter of technician name
  const firstLetter = technicianName.charAt(0).toUpperCase();
  const lastLetter = technicianName.charAt(technicianName.length - 1).toUpperCase();
  const initials = `${firstLetter}${lastLetter}`;
  
  return `${initials} @ ${event.location}`;
};

interface CalendarWeekProps {
  events: Events[];
  currentDate: Date;
}

export function EventCalendarWeek({ events, currentDate }: CalendarWeekProps) {
  const {
    timeFormat,
    locale,
    firstDayOfWeek,
    viewSettings,
    openQuickAddDialog,
    openEventDialog,
  } = useEventCalendarStore(
    useShallow((state) => ({
      timeFormat: state.timeFormat,
      viewSettings: state.viewSettings,
      locale: state.locale,
      firstDayOfWeek: state.firstDayOfWeek,
      openDayEventsDialog: state.openDayEventsDialog,
      openQuickAddDialog: state.openQuickAddDialog,
      openEventDialog: state.openEventDialog,
    })),
  );
  const [hoverPosition, setHoverPosition] = useState<
    HoverPositionType | undefined
  >(undefined);
  const [isMultiDayExpanded, setIsMultiDayExpanded] = useState(false);
  const timeColumnRef = useRef<HTMLDivElement>(null);

  // Get current time in Europe/Stockholm timezone
  const now = getCurrentTimeInSweden();
  const currentHour = now.getUTCHours();
  const currentMinute = now.getUTCMinutes();
  const currentTimeLabel = formatTimeDisplay(now.getHours(), timeFormat, now.getMinutes());
  const localeObj = getLocaleFromCode(locale);

  const { weekNumber, weekDays, todayIndex } = useWeekDays(
    currentDate,
    DAYS_IN_WEEK,
    localeObj,
    firstDayOfWeek,
  );
  const { singleDayEvents, multiDayEvents, allDayEvents } = useFilteredEvents(
    events,
    weekDays,
  );
  const eventsPositions = useEventPositions(
    singleDayEvents,
    weekDays,
    HOUR_HEIGHT,
    START_HOUR,
  );

  const multiDayEventRows = useMultiDayEventRows(multiDayEvents, weekDays);
  const timeSlots = useMemo(() => generateTimeSlots(START_HOUR, END_HOUR), []);

  // Group all-day events by day
  const allDayEventsByDay = useMemo(() => {
    const grouped: Record<string, Events[]> = {};
    weekDays.forEach((day) => {
      grouped[format(day, 'yyyy-MM-dd')] = [];
    });

    allDayEvents.forEach((event) => {
      const dateKey = format(event.startDate, 'yyyy-MM-dd');
      if (grouped[dateKey]) {
        grouped[dateKey].push(event);
      }
    });

    return grouped;
  }, [allDayEvents, weekDays]);

  const totalMultiDayRows =
    multiDayEventRows.length > 0
      ? Math.max(...multiDayEventRows.map((r) => r.row)) + 1
      : 1;

  const handleTimeHover = useCallback((hour: number) => {
    setHoverPosition((prev) => ({ ...prev, hour, minute: 0, dayIndex: -1 }));
  }, []);

  const handlePreciseHover = useCallback(
    (event: React.MouseEvent<HTMLButtonElement>, hour: number) => {
      if (!timeColumnRef.current) return;

      const slotRect = event.currentTarget.getBoundingClientRect();
      const cursorY = event.clientY - slotRect.top;
      const minutes = Math.floor((cursorY / slotRect.height) * 60);

      setHoverPosition({
        hour,
        minute: Math.max(0, Math.min(59, minutes)),
        dayIndex: -1,
      });
    },
    [],
  );

  const handleTimeLeave = useCallback(() => {
    setHoverPosition(undefined);
  }, []);

  const handleTimeSlotClick = useCallback(() => {
    if (!viewSettings.week.enableTimeSlotClick || !hoverPosition) return;

    openQuickAddDialog({
      date: currentDate,
      position: hoverPosition,
    });
  }, [
    currentDate,
    hoverPosition,
    openQuickAddDialog,
    viewSettings.week.enableTimeSlotClick,
  ]);

  const showEventDetail = useCallback(
    (_event: Events) => {
      openEventDialog(_event);
    },
    [openEventDialog],
  );

  const handleTimeBlockClick = useCallback(
    (data: { date: Date; startTime: string; endTime: string }) => {
      if (!viewSettings.week.enableTimeBlockClick) return;
      openQuickAddDialog({
        date: data.date,
        startTime: data.startTime,
        endTime: data.endTime,
        position: hoverPosition,
      });
    },
    [hoverPosition, openQuickAddDialog, viewSettings.week.enableTimeBlockClick],
  );

  const toggleMultiDayExpand = useCallback(() => {
    setIsMultiDayExpanded((prev) => !prev);
  }, []);

  return (
    <div className="flex h-full flex-col border">
      <div className="bg-background border-border sticky top-0 z-30 flex flex-col items-center justify-center pr-4">
        <WeekDayHeaders
          weekNumber={weekNumber}
          daysInWeek={weekDays}
          formatDate={formatDate}
          locale={localeObj}
          firstDayOfWeek={0}
          showWeekNumber={true}
          showDayNumber={true}
          highlightToday={true}
        />
      </div>
      {multiDayEventRows.length > 0 &&
        viewSettings.week.expandMultiDayEvents && (
          <div className="bg-background border-border sticky top-18 z-50 mb-2 flex border-b pr-4">
            <div className="flex h-[64px] w-14 items-center justify-center sm:w-32">
              <Tooltip>
                <TooltipTrigger asChild>
                  <Button
                    variant="ghost"
                    size="icon"
                    className="text-muted-foreground hover:text-primary h-10 w-10"
                    onClick={toggleMultiDayExpand}
                  >
                    <span className="sr-only">
                      {isMultiDayExpanded ? 'Collapse' : 'Expand'} multi-day
                    </span>
                    {isMultiDayExpanded ? <ChevronUp /> : <ChevronDown />}
                  </Button>
                </TooltipTrigger>
                <TooltipContent>
                  {isMultiDayExpanded ? 'Collapse' : 'Expand'} multi-day
                </TooltipContent>
              </Tooltip>
            </div>
            <div
              className="relative flex-1"
              style={{
                height: isMultiDayExpanded
                  ? `${totalMultiDayRows * MULTI_DAY_ROW_HEIGHT}px`
                  : `${MULTI_DAY_ROW_HEIGHT}px`,
                transition: 'height 0.3s ease',
              }}
            >
              <div className="absolute inset-0">
                <div className="relative">
                  {Array.from({
                    length: isMultiDayExpanded ? totalMultiDayRows : 1,
                  }).map((_, rowIndex) => (
                    <div
                      key={`multi-day-row-${rowIndex}`}
                      className="border-border flex h-16 border-t"
                    >
                      {weekDays.map((day, dayIndex) => (
                        <div
                          key={`multi-day-cell-${rowIndex}-${dayIndex}`}
                          data-testid={`multi-day-cell-${rowIndex}-${dayIndex}`}
                          className={cn(
                            'relative flex items-center justify-center border-r last:border-r-0',
                            todayIndex === dayIndex && 'bg-primary/10',
                            'flex-1',
                          )}
                        ></div>
                      ))}
                    </div>
                  ))}
                </div>
              </div>
              <MultiDayEventSection
                rows={multiDayEventRows}
                daysInWeek={weekDays}
                multiDayRowHeight={MULTI_DAY_ROW_HEIGHT}
                showEventDetail={showEventDetail}
                isExpanded={isMultiDayExpanded}
              />
            </div>
          </div>
        )}
      {/* All-day events section */}
      <div className="bg-background border-border sticky top-18 z-40 mb-2 flex border-b pr-4">
        <div className="flex h-[32px] w-14 items-center justify-center text-xs font-medium text-muted-foreground sm:w-32">
          All Day
        </div>
        <div className="relative flex-1">
          <div className="flex daily-location-events">
            {weekDays.map((day, dayIndex) => {
              const dateKey = format(day, 'yyyy-MM-dd');
              const dayAllDayEvents = allDayEventsByDay[dateKey] || [];
              const hasEvents = dayAllDayEvents.length > 0;

              return (
                <div
                  key={`all-day-cell-${dayIndex}`}
                  className={cn(
                    'relative flex items-center justify-center border-r px-1 last:border-r-0',
                    todayIndex === dayIndex && 'bg-primary/10',
                    'flex-1',
                  )}
                >
                  {hasEvents && (
                    <div className="flex flex-wrap gap-0.5 mb-1 text-center truncate max-w-full w-full justify-center">
                      {dayAllDayEvents.slice(0, 2).map((event) => (
                        <div
                          key={event.id}
                          className="bg-muted text-muted-foreground rounded px-1 pb-1 mt-1 pt-1 text-sm truncate max-w-full font-bold  pl-2 pr-2 w-full"
                        >
                          {getLocationDisplay(event)}
                        </div>
                      ))}
                      {dayAllDayEvents.length > 2 && (
                        <div className="text-muted-foreground text-xs">
                          +{dayAllDayEvents.length - 2}
                        </div>
                      )}
                    </div>
                  )}
                </div>
              );
            })}
          </div>
        </div>
      </div>
      <div className="h-full">
        <ScrollArea className="h-full w-full">
          <div className="relative flex flex-1 overflow-hidden pr-4">
            <TimeColumn
              ref={timeColumnRef}
              timeSlots={timeSlots}
              timeFormat={timeFormat}
              onTimeHover={handleTimeHover}
              onPreciseHover={handlePreciseHover}
              onLeave={handleTimeLeave}
              onTimeSlotClick={handleTimeSlotClick}
              variant="week"
              className="p w-14 sm:w-32"
            />
            {viewSettings.week.showCurrentTimeIndicator && (
              <CurrentTimeIndicator
                currentHour={currentHour}
                currentMinute={currentMinute}
                timeFormat={timeFormat}
                hourHeight={HOUR_HEIGHT}
                formattedTime={currentTimeLabel}
              />
            )}
            {hoverPosition && viewSettings.week.showHoverTimeIndicator && (
              <HoverTimeIndicator
                hour={hoverPosition.hour}
                minute={hoverPosition.minute}
                timeFormat={timeFormat}
                hourHeight={HOUR_HEIGHT}
              />
            )}
            <div className="relative flex-1 overflow-y-auto">
              <TimeGrid
                highlightToday={viewSettings.week.highlightToday}
                timeSlots={timeSlots}
                daysInWeek={weekDays}
                todayIndex={todayIndex}
                onTimeBlockClick={handleTimeBlockClick}
              />
              <div className="pointer-events-none absolute inset-0">
                {singleDayEvents.map((event) => {
                  const eventDate = new Date(event.startDate);
                  const dayIndex = weekDays.findIndex((day) =>
                    isSameDay(day, eventDate),
                  );

                  if (dayIndex === -1) return null;

                  const position = eventsPositions[`${dayIndex}-${event.id}`];
                  if (!position) return null;

                  // Calculate width and horizontal position
                  const OVERLAP_FACTOR = 0.5;
                  const columnWidth =
                    (DAY_WIDTH_PERCENT +
                      OVERLAP_FACTOR / position.totalColumns) /
                    position.totalColumns;
                  const leftPercent =
                    dayIndex * DAY_WIDTH_PERCENT +
                    position.column * columnWidth -
                    OVERLAP_FACTOR / (position.totalColumns * 2);
                  const rightPercent = 100 - (leftPercent + columnWidth);

                  return (
                    <EventDialogTrigger
                      event={event}
                      key={event.id}
                      position={position}
                      leftOffset={leftPercent}
                      rightOffset={rightPercent}
                      onClick={openEventDialog}
                    />
                  );
                })}
              </div>
            </div>
          </div>
        </ScrollArea>
      </div>
    </div>
  );
}
