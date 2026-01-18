import { EventCalendar } from '@/components/event-calendar'
import { useState, useEffect } from 'react'

export function EventCalendarDemo5() {
  const [fifthTechnician, setFifthTechnician] = useState<any>(null);

  useEffect(() => {
    const loadResources = async () => {
      try {
        const response = await fetch('/calendar/resources');
        const resources = await response.json();
        if (resources && resources.length > 4) {
          setFifthTechnician(resources[4]);
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
      events={fifthTechnician ? `calendar/events?resourceId=${fifthTechnician.id}` : 'calendar/events?resourceId=17'}
      addButton={{
        text: fifthTechnician ? fifthTechnician.title : 'Tekniker 5',
        click() {
          alert(`${fifthTechnician ? fifthTechnician.title : 'Tekniker 5'} ...`)
        }
      }}
    />
  )
}
