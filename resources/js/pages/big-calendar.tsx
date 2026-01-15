import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

// Import the advanced calendar system
import { Calendar } from '@/components/calendar/calendar';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Big Calendar',
        href: '/big-calendar',
    },
];

export default function BigCalendar() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Big Calendar" />
            <div className="mx-auto w-full h-full">
                {/* Advanced Calendar Implementation */}
                <Calendar />
            </div>
        </AppLayout>
    );
}
