import { EventCalendar } from '@/components/event-calendar'


export function EventCalendarDemo4() {
  return (
    <EventCalendar
      className='max-w-300 my-10 mx-auto'
      editable
      selectable
      droppable
      nowIndicator
      navLinks
      locale='sv'
      initialView='dayGridMonth'
      timeZone='UTC'
      events='calendar/events?resourceId=16'
      addButton={{
        text: 'Tekniker 1',
        click() {
          alert('Tekniker 1 ...')
        }
      }}
    />
  )
}
