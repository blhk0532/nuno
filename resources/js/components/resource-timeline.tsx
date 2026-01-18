import { useCalendarController } from '@fullcalendar/react'
import { type CalendarOptions } from '@fullcalendar/core'
import adaptivePlugin from '@fullcalendar/adaptive'
import resourceTimelinePlugin from '@fullcalendar/resource-timeline'
import interactionPlugin from '@fullcalendar/interaction'
import { EventCalendarContainer } from '@/components/ui/event-calendar-container'
import { EventCalendarCloseIcon, EventCalendarExpanderIcon } from '@/components/event-calendar-icons'
import { EventCalendarToolbar } from '@/components/event-calendar-toolbar'
import { SchedulerViews } from '@/components/ui/scheduler-views'

const plugins = [
  adaptivePlugin,
  interactionPlugin,
  resourceTimelinePlugin,
]
const defaultAvailableViews = [
  'resourceTimelineDay',
  'resourceTimelineWeek',
]
const navLinkDayClick = 'resourceTimelineDay'
const navLinkWeekClick = 'resourceTimelineWeek'

export interface ResourceTimelineProps extends Omit<CalendarOptions, 'class'> {
  availableViews?: string[]
  addButton?: {
    isPrimary?: boolean
    text?: string
    hint?: string
    click?: (ev: MouseEvent) => void
  }
}

export function ResourceTimeline({
  availableViews = defaultAvailableViews,
  addButton,
  className,
  height,
  contentHeight,
  direction,
  plugins: userPlugins = [],
  ...restOptions
}: ResourceTimelineProps) {
  const controller = useCalendarController()
  const autoHeight = height === 'auto' || contentHeight === 'auto'

  return (
    <EventCalendarContainer
      direction={direction}
      className={className}
      height={height}
      borderless={restOptions.borderless}
      borderlessX={restOptions.borderlessX}
      borderlessTop={restOptions.borderlessTop}
      borderlessBottom={restOptions.borderlessBottom}
    >
      <EventCalendarToolbar
        controller={controller}
        availableViews={availableViews}
        addButton={addButton}
      />
      <SchedulerViews
        controller={controller}
        liquidHeight={!autoHeight && height !== undefined}
        height={autoHeight ? 'auto' : contentHeight}
        initialView={availableViews[0]}
        navLinkDayClick={navLinkDayClick}
        navLinkWeekClick={navLinkWeekClick}
        plugins={[...plugins, ...userPlugins]}
        popoverCloseContent={() => (
          <EventCalendarCloseIcon />
        )}
        resourceExpanderContent={(data) => (
          <EventCalendarExpanderIcon isExpanded={data.isExpanded} />
        )}
        firstDay={1}
        {...restOptions}
      />
    </EventCalendarContainer>
  )
}
