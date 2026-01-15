import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Booking Calendar',
        href: '/booking-calendar',
    },
];

export default function BookingCalendar() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Booking Calendar" />
            <div className="container mx-auto px-4 py-8">
                <h1 className="text-2xl font-bold mb-6">Booking Calendar</h1>
                <p className="text-gray-600 mb-4">Calendar for booking management.</p>
                {/* Add your booking calendar component here */}
                <div className="bg-white rounded-lg shadow p-6 min-h-[600px]">
                    <p>Booking Calendar content goes here...</p>
                </div>
            </div>
        </AppLayout>
    );
}
