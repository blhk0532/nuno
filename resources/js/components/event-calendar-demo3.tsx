import { EventCalendar } from '@/components/event-calendar'
import { useState, useEffect } from 'react'

export function EventCalendarDemo3() {
  const [thirdTechnician, setThirdTechnician] = useState<any>(null);

  useEffect(() => {
    const loadResources = async () => {
      try {
        const response = await fetch('/calendar/resources');
        const resources = await response.json();
        if (resources && resources.length > 2) {
          setThirdTechnician(resources[2]);
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
      events={thirdTechnician ? `calendar/events?resourceId=${thirdTechnician.id}` : 'calendar/events?resourceId=18'}
      addButton={{
        text: thirdTechnician ? thirdTechnician.title : 'Tekniker 3',
        click() {
          alert(`${thirdTechnician ? thirdTechnician.title : 'Tekniker 3'} ...`)
        }
      }}
    />
  )
}
