import { EventCalendar } from '@/components/event-calendar'
import { useState, useEffect } from 'react'

export function EventCalendarDemo6() {
  const [sixthTechnician, setSixthTechnician] = useState<any>(null);

  useEffect(() => {
    const loadResources = async () => {
      try {
        const response = await fetch('/calendar/resources');
        const resources = await response.json();
        if (resources && resources.length > 5) {
          setSixthTechnician(resources[5]);
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
      events={sixthTechnician ? `calendar/events?resourceId=${sixthTechnician.id}` : 'calendar/events?resourceId=18'}
      addButton={{
        text: sixthTechnician ? sixthTechnician.title : 'Tekniker 6',
        click() {
          alert(`${sixthTechnician ? sixthTechnician.title : 'Tekniker 6'} ...`)
        }
      }}
    />
  )
}
