import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { calendarMulti } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Calendar Multi',
        href: calendarMulti().url,
    },
];

export default function CalendarMulti() {
     return (
         <AppLayout breadcrumbs={breadcrumbs}>
             <Head title="Calendar" />
             <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl bg-background p-4">

                 <div className="relative min-h-[100vh] w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">

                 </div>
                    <div className="mb-6">

                 </div>
             </div>
         </AppLayout>
     );
}
