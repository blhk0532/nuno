import { EventCalendar } from '@/components/event-calendar'


export function EventCalendarDemo() {
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
      events='calendar/events'
      addButton={{
        text: 'Ny Bokning',
        click() {
          alert('Ny Bokning...')
        }
      }}
    />
  )
}
