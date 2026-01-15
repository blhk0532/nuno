import React from 'react';
import { Head } from '@inertiajs/react';

export default function CalendarOne() {
    return (
        <>
            <Head title="Calendar One" />
            <div className="container mx-auto px-4 py-8">
                <h1 className="text-2xl font-bold mb-6">Calendar One</h1>
                <p className="text-gray-600 mb-4">Single calendar view implementation.</p>
                {/* Add your calendar component here */}
                <div className="bg-white rounded-lg shadow p-6">
                    <p>Calendar One content goes here...</p>
                </div>
            </div>
        </>
    );
}
