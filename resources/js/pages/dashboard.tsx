import { EventCalendarDemo } from '@/components/event-calendar-demo';
import { EventCalendarDemo1 } from '@/components/event-calendar-demo1';
import { EventCalendarDemo2 } from '@/components/event-calendar-demo2';
import { EventCalendarDemo3 } from '@/components/event-calendar-demo3';
import { EventCalendarDemo4 } from '@/components/event-calendar-demo4';
import { EventCalendarDemo5 } from '@/components/event-calendar-demo5';
import { EventCalendarDemo6 } from '@/components/event-calendar-demo6';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { dashboard } from '../routes';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
        <div id="dashboard-container" className="w-full max-w-[100%] max-h-[96vh] overflow-auto">
            <div className="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl bg-background p-4">
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
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <EventCalendarDemo4 />
                    </div>
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <EventCalendarDemo5 />
                    </div>
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <EventCalendarDemo6 />
                    </div>
                </div>

                    <div className="relative max-h-[560px] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <EventCalendarDemo />
                    </div>
            </div>
        </div>
        </AppLayout>
    );
}
