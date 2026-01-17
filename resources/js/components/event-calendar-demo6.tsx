import { EventCalendar } from '@/components/event-calendar'


export function EventCalendarDemo6() {
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
          slotMinTime="07:00:00"
    slotMaxTime="17:00:00"
    slotDuration="01:00:00"
      events='calendar/events?resourceId=18'
      addButton={{
        text: 'Tekniker 6',
        click() {
          alert('Tekniker 6 ...')
        }
      }}
    />
  )
}
