import { ResourceTimeline } from '@/components/resource-timeline'

export function ResourceTimelineDemo() {
  return (
    <ResourceTimeline
      className='max-w-300 my-10 mx-auto'
      schedulerLicenseKey='CC-Attribution-NonCommercial-NoDerivatives'
      editable
      selectable
      nowIndicator
      navLinks
      locale='sv'
      initialView='resourceTimelineDay'
      height='300px'
      contentHeight={300}
      aspectRatio={1.5}
      timeZone='UTC'
      resourceColumnHeaderContent='Rooms'
      resources='calendar/resources?with-nesting&with-colors'
      events='calendar/events?single-day&for-resource-timeline'
      addButton={{
        text: 'Ny Tekniker',
        click() {
          alert('Ny Tekniker...')
        }
      }}
    />
  )
}
