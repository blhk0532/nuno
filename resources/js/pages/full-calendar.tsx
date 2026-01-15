import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Full Calendar',
        href: '/full-calendar',
    },
];

export default function FullCalendar() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Full Calendar" />
            <div className="container mx-auto px-4 py-8">
                <h1 className="text-2xl font-bold mb-6">Full Calendar</h1>
                <p className="text-gray-600 mb-4">Complete calendar view implementation.</p>
                {/* Add your full calendar component here */}
                <div className="bg-white rounded-lg shadow p-6 min-h-[600px]">
                    <p>Full Calendar content goes here...</p>
                </div>
            </div>
        </AppLayout>
    );
}
