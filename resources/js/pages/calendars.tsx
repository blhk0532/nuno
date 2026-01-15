import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { dashboard, calendars } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { EventCalendarDemo } from '@/components/event-calendar-demo';
import { EventCalendarDemo1 } from '@/components/event-calendar-demo1';
import { EventCalendarDemo2 } from '@/components/event-calendar-demo2';
import { EventCalendarDemo3 } from '@/components/event-calendar-demo3';
import { EventCalendarDemo4 } from '@/components/event-calendar-demo4';
import { EventCalendarDemo5 } from '@/components/event-calendar-demo5';
import { EventCalendarDemo6 } from '@/components/event-calendar-demo6';
import { EventCalendarDemo7 } from '@/components/event-calendar-demo7';
import { EventCalendarDemo8 } from '@/components/event-calendar-demo8';
import { EventCalendarDemo9 } from '@/components/event-calendar-demo9';
import { ResourceTimeGridDemo } from '@/components/resource-timegrid-demo';
import { ResourceTimelineDemo } from '@/components/resource-timeline-demo';
import { ResourceTimeGridDemo1 } from '@/components/resource-timegrid-demo1';
import { ResourceTimelineDemo1 } from '@/components/resource-timeline-demo1';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Calendars',
        href: calendars().url,
    },
];

export default function Dashboard() {
    return (
            <AppLayout breadcrumbs={breadcrumbs}>
                <Head title="Dashboard" />
                <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl bg-background p-4">

                    <div className="relative max-h-[680px] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <EventCalendarDemo />
                    </div>

                    <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                        <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                            <EventCalendarDemo1 />
                        </div>
                        <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                            <EventCalendarDemo2 />
                        </div>
                        <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                            <EventCalendarDemo3 />
                        </div>
                    </div>

                </div>
            </AppLayout>
    );
}
