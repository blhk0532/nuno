import { EventCalendar } from '@/components/event-calendar'
import { useState, useEffect } from 'react'

export function EventCalendarDemo4() {
  const [fourthTechnician, setFourthTechnician] = useState<any>(null);

  useEffect(() => {
    const loadResources = async () => {
      try {
        const response = await fetch('/calendar/resources');
        const resources = await response.json();
        if (resources && resources.length > 3) {
          setFourthTechnician(resources[3]);
        }
      } catch (error) {
        console.error('Error loading resources:', error);
      }
    };

    loadResources();
  }, []);

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
      firstDay={1}
      timeZone='UTC'
      slotMinTime="07:00:00"
      slotMaxTime="17:00:00"
      slotDuration="01:00:00"
      events={fourthTechnician ? `calendar/events?resourceId=${fourthTechnician.id}` : 'calendar/events?resourceId=16'}
      addButton={{
        text: fourthTechnician ? fourthTechnician.title : 'Tekniker 4',
        click() {
          alert(`${fourthTechnician ? fourthTechnician.title : 'Tekniker 4'} ...`)
        }
      }}
    />
  )
}
