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
      timeZone='UTC'
      events=''
      addButton={{
        text: 'Add Event',
        click() {
          alert('add event...')
        }
      }}
    />
  )
}
