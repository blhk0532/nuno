import { EventCalendar } from '@/components/event-calendar'


export function EventCalendarDemo2() {
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
      events='calendar/events?resourceId=17'
      addButton={{
        text: 'Tekniker 2',
        click() {
          alert('Tekniker 2 ...')
        }
      }}
    />
  )
}
