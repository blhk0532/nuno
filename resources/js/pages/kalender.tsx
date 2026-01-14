import { EventCalendarDemo } from '@/components/event-calendar-demo';
import { EventCalendarDemo1 } from '@/components/event-calendar-demo1';
import { EventCalendarDemo2 } from '@/components/event-calendar-demo2';
import { EventCalendarDemo3 } from '@/components/event-calendar-demo3';
import { ResourceTimeGridDemo } from '@/components/resource-timegrid-demo';
import { ResourceTimelineDemo } from '@/components/resource-timeline-demo';
import AppLayout from '@/layouts/app-layout';
import { calendar } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { ka } from 'date-fns/locale';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kalender',
        href: calendar().url,
    },
];

export default function Calendar() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Kalender" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl bg-background p-4">
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
                                <div className="relative max-h-[284px] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <ResourceTimelineDemo />
                </div>
                <div className="relative min-h-[100vh] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <EventCalendarDemo />
                </div>

                <div className="relative min-h-[100vh] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <ResourceTimeGridDemo />
                </div>
            </div>
        </AppLayout>
    );
}
