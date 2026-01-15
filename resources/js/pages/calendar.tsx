import { EventCalendarDemo } from '@/components/event-calendar-demo';
import { CalendarStats } from '@/components/calendar-stats';
import AppLayout from '@/layouts/app-layout';
import { calendar } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

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
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl bg-background p-4">

                <div className="relative min-h-[100vh] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <EventCalendarDemo />
                </div>
                   <div className="mb-6">
                    <CalendarStats />
                </div>
            </div>
        </AppLayout>
    );
}
