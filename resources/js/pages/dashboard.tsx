import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
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
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 bg-background">

                <div className="relative max-h-[76vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <EventCalendarDemo />
                </div>

                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <EventCalendarDemo1 />
                    </div>
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                   <EventCalendarDemo2 />
                    </div>
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                   <EventCalendarDemo3 />
                    </div>
                </div>

                 <div className="relative max-h-[256px] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <ResourceTimelineDemo />
                </div>

                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <EventCalendarDemo7 />
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                   <EventCalendarDemo8 />
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                   <EventCalendarDemo9 />
                    </div>
                </div>

                <div className="relative max-h-[76vh] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <ResourceTimeGridDemo />
                </div>
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <EventCalendarDemo4 />
                    </div>
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                   <EventCalendarDemo5 />
                    </div>
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                   <EventCalendarDemo6 />
                    </div>
                </div>
                <div className="relative max-h-[284px] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="opacity-50 absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <ResourceTimelineDemo1 />
                </div>
                 <div className="relative max-h-[76vh] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    <ResourceTimeGridDemo1 />
                </div>
            </div>
        </AppLayout>
    );
}
