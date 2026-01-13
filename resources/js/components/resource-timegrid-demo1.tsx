import { ResourceTimeGrid } from '@/components/resource-timegrid'

export function ResourceTimeGridDemo1() {
  return (
    <ResourceTimeGrid
      className='max-w-300 my-10 mx-auto'
      schedulerLicenseKey='CC-Attribution-NonCommercial-NoDerivatives'
      editable
      selectable
      nowIndicator
      navLinks
      locale='sv'
      initialView='resourceTimeGridWeek'
      dayMinWidth={200}
      timeZone='UTC'
      resources={[
        { id: '16', title: 'Tekinker 1' },
        { id: '17', title: 'Tekinker 2' },
        { id: '18', title: 'Tekinker 3' },
      ]}
      events='http://localhost:8000/calendar/events?with-resources=3&single-day'
      addButton={{
        text: 'Ny Kalender',
        click() {
          alert('Ny Kalender...')
        }
      }}
    />
  )
}
