import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { BookingCalendar } from '@/components/booking-calendar';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bokningar',
        href: dashboard().url,
    },
];

export default function Bokningar() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Bokningar" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 bg-background">
                <BookingCalendar />
            </div>
        </AppLayout>
    );
}
