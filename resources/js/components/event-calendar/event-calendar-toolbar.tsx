'use client';

import {
  ChevronLeft,
  ChevronRight,
  Plus,
  Search,
  X,
  Tag,
  Repeat,
  Clock,
  Users,
} from 'lucide-react';
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
import CalendarSettingsDialog from './event-calendar-setting-dialog';
import { getLocaleFromCode } from '@/lib/event';
import type { IUser } from '@/components/calendar/interfaces';
import type { CalendarTechnician } from '@/components/event-calendar/types';
import type { CalendarCategoryOption } from '@/types/event';
import { Label } from '../ui/label';
import { Badge } from '../ui/badge';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '../ui/select';
import { Checkbox } from '../ui/checkbox';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '../ui/popover';
import { EVENT_COLORS } from '@/constants/calendar-constant';
import { getColorClasses } from '@/lib/event';
import { EventSearchDialog } from './event-search-dialog';
import { ToggleTheme } from '@/components/layout/change-theme';

interface EventCalendarToolbarProps {
  users?: IUser[];
  selectedTechnicianId?: string;
  onTechnicianChange?: (id: string) => void;
  totalEvents?: number;
  categoryOptions?: CalendarCategoryOption[];
  currentDate: Date;
  onDateChange: (date: Date) => void;
}

type FiltersState = {
  categories: string[];
  locations: string[];
  colors: string[];
  isRepeating: string;
  repeatingTypes: string[];
  dateStart: string;
  dateEnd: string;
  search: string;
};

const INITIAL_FILTERS: FiltersState = {
  categories: [],
  locations: [],
  colors: [],
  isRepeating: '',
  repeatingTypes: [],
  dateStart: '',
  dateEnd: '',
  search: '',
};

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
    openEventDialog,
    daysCount,
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
      openEventDialog: state.openEventDialog,
      daysCount: state.daysCount,
    })),
  );
  const localeObj = getLocaleFromCode(locale);

  const [searchDialogOpen, setSearchDialogOpen] = useState(false);
  const [filters, setFilters] = useState<FiltersState>(INITIAL_FILTERS);

  const getActiveFiltersCount = () => {
    let count = 0;
    count += filters.categories.length;
    count += filters.locations.length;
    count += filters.colors.length;
    count += filters.repeatingTypes.length;
    if (filters.isRepeating) count += 1;
    if (filters.dateStart || filters.dateEnd) count += 1;
    if (filters.search) count += 1;
    return count;
  };

  const toggleArrayFilter = (
    key: keyof Pick<FiltersState, 'categories' | 'locations' | 'colors' | 'repeatingTypes'>,
    value: string,
  ) => {
    const currentArray = filters[key];
    const newArray = currentArray.includes(value)
      ? currentArray.filter((item) => item !== value)
      : [...currentArray, value];

    setFilters((prev) => ({ ...prev, [key]: newArray }));
  };

  const updateSingleFilter = (key: keyof FiltersState, value: string) => {
    setFilters((prev) => ({ ...prev, [key]: value }));
  };

  const clearAllFilters = () => {
    setFilters(INITIAL_FILTERS);
  };

  const clearSingleArrayFilter = (
    key: keyof Pick<FiltersState, 'categories' | 'locations' | 'colors' | 'repeatingTypes'>,
    value: string,
  ) => {
    const currentArray = filters[key];
    const newArray = currentArray.filter((item) => item !== value);
    setFilters((prev) => ({ ...prev, [key]: newArray }));
  };

  const activeFiltersCount = getActiveFiltersCount();

  const handleNavigateNext = useCallback(() => {
    let newDate = new Date(currentDate);

    switch (currentView) {
      case 'day':
        newDate = addDays(newDate, 1);
        break;
      case 'days':
        newDate = addDays(newDate, daysCount || 1);
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
      default:
        newDate = addDays(newDate, 1);
        break;
    }

    onDateChange(newDate);
  }, [currentDate, currentView, daysCount, onDateChange]);

  const handleNavigatePrevious = useCallback(() => {
    let newDate = new Date(currentDate);

    switch (currentView) {
      case 'day':
        newDate = subDays(newDate, 1);
        break;
      case 'days':
        newDate = subDays(newDate, daysCount || 1);
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
      default:
        newDate = subDays(newDate, 1);
        break;
    }

    onDateChange(newDate);
  }, [currentDate, currentView, daysCount, onDateChange]);

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
      <div className="bg-muted/30 flex flex-col">
        <div className="flex flex-wrap items-center justify-center lg:justify-between gap-x-4 gap-y-0 px-2">
          <div className="flex flex-wrap items-center justify-center lg:justify-start gap-2">
            <div className="flex flex-wrap items-center justify-center lg:justify-start gap-1 sm:gap-2">
<div className="min-w-[120px]">
    {users && users.length > 0 && onTechnicianChange && (
              <Select
                value={selectedTechnicianId}
                onValueChange={onTechnicianChange}
              >
                <SelectTrigger className="h-9 w-[120px] gap-2 text-sm font-medium">

                  <SelectValue placeholder="Tekniker" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all" className="text-sm">
                    Tekniker
                  </SelectItem>
                  {users.map((user) => (
                    <SelectItem key={user.id} value={user.id} className="text-sm">
                      {user.name}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            )}
</div>


<div className="flex flex-wrap items-center justify-center gap-2 lg:gap-4 min-w-[270px] max-w-[320px] relative min-[768px]:max-[1024px]:min-w-[250px]">
        {filters.isRepeating === 'repeating' && (
              <Popover>
                <PopoverTrigger asChild>
                  <Button
                    variant={
                      filters.repeatingTypes.length > 0 ? 'default' : 'outline'
                    }
                    size="sm"
                    className="h-9 gap-2 px-3 text-sm font-medium transition-all absolute l-0"
                  >
                    <Clock className="h-4 w-4" />
                    <span className="hidden sm:inline">Repeat</span>
                    {filters.repeatingTypes.length > 0 && (
                      <Badge variant="secondary" className="px-1.5 py-0">
                        {filters.repeatingTypes.length}
                      </Badge>
                    )}
                  </Button>
                </PopoverTrigger>
                <PopoverContent className="w-52 p-4">
                  <div className="space-y-3">
                    <h4 className="text-sm font-medium">Repeat Frequency</h4>
                    <div className="space-y-3">
                      {['daily', 'weekly', 'monthly'].map((type) => (
                        <div key={type} className="flex items-center space-x-3">
                          <Checkbox
                            id={`repeat-${type}`}
                            checked={filters.repeatingTypes.includes(type)}
                            onCheckedChange={() =>
                              toggleArrayFilter('repeatingTypes', type)
                            }
                          />
                          <Label
                            htmlFor={`repeat-${type}`}
                            className="cursor-pointer text-sm font-normal capitalize"
                          >
                            {type}
                          </Label>
                        </div>
                      ))}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
            )}

            {activeFiltersCount > 0 && (
              <Button
                variant="ghost"
                onClick={clearAllFilters}
                size="sm"
                className="h-8 gap-1 px-2 text-xs font-medium text-muted-foreground hover:text-foreground"
              >
                <X className="h-3 w-3" />
                Clear
              </Button>
            )}

              <Button
                variant="ghost"
                size="icon"
                className="hover:bg-muted h-9 w-9 rounded-full   absolute left-0 min-[768px]:max-[1024px]:hidden"
                onClick={handleNavigatePrevious}
              >
                <ChevronLeft className="h-4 w-4" />
              </Button>
              <div className="flex items-center space-x-1">
                {currentView === 'day' && (
                  <SearchDayPicker
                    date={currentDate}
                    onDateChange={onDateChange}
                    locale={localeObj}
                    weekStartsOn={0}
                    placeholder="Select day"
                  />
                )}


                {currentView !== 'year' && (
                  <SearchMonthPicker
                    date={currentDate}
                    onDateChange={onDateChange}
                    locale={localeObj}
                    monthFormat="LLL"
                  />
                )}
                <SearchYearPicker
                  date={currentDate}
                  onDateChange={onDateChange}
                  yearRange={20}
                  minYear={2000}
                  maxYear={2030}
                />
   </div>
              <Button
                variant="ghost"
                size="icon"
                className="hover:bg-muted h-9 w-9 rounded-full   absolute right-0 min-[768px]:max-[1024px]:hidden"
                onClick={handleNavigateNext}
              >
                <ChevronRight className="h-4 w-4" />
              </Button>
 </div>


            </div>





          </div>



    <EventCalendarTabs
            viewType={currentView}
            onChange={handleViewTypeChange}
          />



          <div className="flex flex-wrap items-center justify-center lg:justify-end gap-2 min-[768px]:max-[1024px]:hidden">



            <div className=" flex min-w-[240px] min-[768px]:max-[1320px]:hidden gap-2">

<ToggleTheme/>


            <TodayButton
              viewType={currentView}
              currentDate={currentDate}
              onDateChange={onDateChange}
            />







  <Popover>
                <PopoverTrigger asChild>
                  <Button
                    variant={
                      filters.categories.length > 0 ? 'default' : 'outline'
                    }
                    size="icon"
                    className="relative h-8 w-9 transition-all w-[50px]"
                  >
                    <Tag className="h-4 w-4" />
                    {filters.categories.length > 0 && (
                      <span className="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] text-primary-foreground">
                        {filters.categories.length}
                      </span>
                    )}
                  </Button>
                </PopoverTrigger>
                <PopoverContent className="w-64 p-4">
                  <div className="space-y-3">
                    <h4 className="text-sm font-medium">Välj Kategori</h4>
                    <div className="max-h-48 space-y-3 overflow-y-auto">
                      {categoryOptions && categoryOptions.length > 0 ? (
                        categoryOptions.map((category) => (
                          <div
                            key={category.value}
                            className="flex items-center space-x-3"
                          >
                            <Checkbox
                              id={`category-${category.value}`}
                              checked={filters.categories.includes(
                                category.value,
                              )}
                              onCheckedChange={() =>
                                toggleArrayFilter('categories', category.value)
                              }
                            />
                            <Label
                              htmlFor={`category-${category.value}`}
                              className="cursor-pointer text-sm font-normal"
                            >
                              {category.label}
                            </Label>
                          </div>
                        ))
                      ) : (
                        <div className="text-sm text-muted-foreground">
                          No categories configured
                        </div>
                      )}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>



              <TimeFormatToggle
                format={timeFormat}
                onChange={handleTimeFormatChange}
              />



   <Popover>
                <PopoverTrigger asChild>
                  <Button
                    variant={filters.colors.length > 0 ? 'default' : 'outline'}
                    size="icon"
                    className="relative h-9 w-9 transition-all hidden"
                  >
                    <div className="h-4 w-4 rounded-full bg-green-500 ring-2 ring-white" />
                    {filters.colors.length > 0 && (
                      <span className="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] text-primary-foreground">
                        {filters.colors.length}
                      </span>
                    )}
                  </Button>
                </PopoverTrigger>
                <PopoverContent className="w-64 p-4">
                  <div className="space-y-3">
                    <h4 className="text-sm font-medium">Filter Status</h4>
                    <div className="grid grid-cols-2 gap-3">
                      {EVENT_COLORS.map((color) => {
                        const validColors = getColorClasses(color.value);
                        return (
                          <div
                            key={color.value}
                            className="flex items-center space-x-3"
                          >
                            <Checkbox
                              id={`color-${color.value}`}
                              checked={filters.colors.includes(color.value)}
                              onCheckedChange={() =>
                                toggleArrayFilter('colors', color.value)
                              }
                            />
                            <div className="flex items-center gap-2">
                              <div
                                className={`h-4 w-4 rounded-full border border-white shadow-sm ${validColors.bg}`}
                              />
                              <Label
                                htmlFor={`color-${color.value}`}
                                className="cursor-pointer text-sm font-normal"
                              >
                                {color.label}
                              </Label>
                            </div>
                          </div>
                        );
                      })}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>




 </div>

<div className='min-[768px]:max-[1024px]:hidden'>
         <ViewModeToggle mode={viewMode} onChange={handleViewModeChange} />
</div>



          <Button
              variant={filters.search ? 'default' : 'outline'}
              onClick={() => setSearchDialogOpen(true)}
              className="h-9 gap-2 px-3 text-sm font-medium transition-all"
            >
              <Search className="h-4 w-4" />

              {filters.search && (
                <Badge variant="secondary" className="ml-1 px-1.5 py-0">
                  1
                </Badge>
              )}
            </Button>





            <Button
                onClick={() => openQuickAddDialog({ date: new Date() })}
                className="h-9 gap-2 px-3 text-sm font-medium transition-all hidden"
              >
                <Plus className="lucide lucide-plus h-4 w-4" />

              </Button>
              <CalendarSettingsDialog />


          </div>
        </div>

        {activeFiltersCount > 0 && (
          <div className="flex flex-wrap items-center gap-2 px-4 pb-2">
            {filters.search && (
              <Badge
                variant="outline"
                className="h-6 gap-1 border-blue-200 bg-blue-50 px-2 text-blue-700"
              >
                <Search className="h-3 w-3" />
                <span className="text-[10px]">"{filters.search}"</span>
                <button
                  onClick={() => updateSingleFilter('search', '')}
                  className="ml-1 rounded-full hover:bg-blue-200"
                >
                  <X className="h-2.5 w-2.5" />
                </button>
              </Badge>
            )}
            {filters.categories.map((catValue) => (
              <Badge
                key={catValue}
                variant="outline"
                className="h-6 gap-1 border-green-200 bg-green-50 px-2 text-green-700"
              >
                <Tag className="h-3 w-3" />
                <span className="text-[10px]">
                  {categoryOptions?.find((c) => c.value === catValue)?.label ||
                    catValue}
                </span>
                <button
                  onClick={() => clearSingleArrayFilter('categories', catValue)}
                  className="ml-1 rounded-full hover:bg-green-200"
                >
                  <X className="h-2.5 w-2.5" />
                </button>
              </Badge>
            ))}
            {filters.colors.map((colorValue) => (
              <Badge
                key={colorValue}
                variant="outline"
                className="h-6 gap-1 border-purple-200 bg-purple-50 px-2 text-purple-700"
              >
                <div
                  className={`h-2.5 w-2.5 rounded-full ${getColorClasses(colorValue).bg}`}
                />
                <span className="text-[10px]">
                  {EVENT_COLORS.find((c) => c.value === colorValue)?.label ||
                    colorValue}
                </span>
                <button
                  onClick={() => clearSingleArrayFilter('colors', colorValue)}
                  className="ml-1 rounded-full hover:bg-purple-200"
                >
                  <X className="h-2.5 w-2.5" />
                </button>
              </Badge>
            ))}
          </div>
        )}
      </div>

      <EventSearchDialog
        open={searchDialogOpen}
        onOpenChange={setSearchDialogOpen}
        searchQuery={filters.search}
        onSearchQueryChange={(query) => updateSingleFilter('search', query)}
        onEventSelect={openEventDialog}
        timeFormat={timeFormat}
      />
    </div>
  );
}
