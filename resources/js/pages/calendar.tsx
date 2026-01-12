import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { calendar } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { EventCalendarDemo } from '@/components/event-calendar-demo'
import { ResourceTimelineDemo } from '@/components/resource-timeline-demo'
import { ResourceTimeGridDemo } from '@/components/resource-timegrid-demo'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Calendar',
        href: calendar().url,
    },
];

export default function Calendar() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Calendar" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
   
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                  <EventCalendarDemo />
                     </div>
                     
            </div>
        </AppLayout>
    );
}
