import { EventCalendar } from '@/components/event-calendar'


export function EventCalendarDemo3() {
  return (
    <EventCalendar
      className='max-w-300 my-10 mx-auto'
      editable
      selectable
      droppable
      nowIndicator
      navLinks
      locale='sv'
      initialView='timeGridWeek'
      timeZone='UTC'
      events='http://localhost:8000/calendar/events?resourceId=18'
      addButton={{
        text: 'Tekniker 3',
        click() {
          alert('Tekniker 3 ...')
        }
      }}
    />
  )
}
