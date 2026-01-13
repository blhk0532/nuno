import { EventCalendar } from '@/components/event-calendar'


export function EventCalendarDemo8() {
  return (
    <EventCalendar
      className='max-w-300 my-10 mx-auto'
      editable
      selectable
      droppable
      nowIndicator
      navLinks
      locale='sv'
      initialView='listWeek'
      timeZone='UTC'
      events='http://localhost:8000/calendar/events?resourceId=17'
      addButton={{
        text: 'Tekniker 2',
        click() {
          alert('Tekniker 2 ...')
        }
      }}
    />
  )
}
