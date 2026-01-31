import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import { Calendar } from '@/components/calendar/calendar';

type RingaData = {
    id: number;
    name: string;
    phone: string;
    email: string;
    status: string;
    outcome: string | null;
    created_at: string;
    updated_at: string;
};

type BreadcrumbItem = {
    title: string;
    href: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ringlistan',
        href: '/queue',
    },
];

interface QueueProps {
    records: RingaData[];
    selectedRecordId: number | null;
}

export default function Queue({ records = [], selectedRecordId: initialSelectedId = null }: QueueProps) {
    const [selectedRecordId, setSelectedRecordId] = useState<number | null>(initialSelectedId);
    const [filteredRecords, setFilteredRecords] = useState<RingaData[]>(records);

    // Filter records where outcome is null (pending records)
    useEffect(() => {
        const pending = records.filter(record => !record.outcome);
        setFilteredRecords(pending);

        // Set first record as selected if none selected
        if (!selectedRecordId && pending.length > 0) {
            setSelectedRecordId(pending[0].id);
        }
    }, [records, selectedRecordId]);

    const selectedRecord = filteredRecords.find(r => r.id === selectedRecordId);

    const handleSelectRecord = (recordId: number) => {
        setSelectedRecordId(recordId);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Ringlistan" />
            <div className="mx-auto w-full h-full">
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                    {/* Left: Queue List */}
                    <div className="lg:col-span-1">
                        <div className="bg-white rounded-lg shadow">
                            <div className="p-4 border-b">
                                <h2 className="text-lg font-semibold text-gray-900">
                                    Kö ({filteredRecords.length})
                                </h2>
                            </div>
                            <div className="overflow-y-auto max-h-96">
                                {filteredRecords.length === 0 ? (
                                    <div className="p-4 text-center text-gray-500">
                                        Ingen kötransaktioner
                                    </div>
                                ) : (
                                    <ul className="divide-y">
                                        {filteredRecords.map(record => (
                                            <li key={record.id}>
                                                <button
                                                    onClick={() => handleSelectRecord(record.id)}
                                                    className={`w-full text-left p-4 hover:bg-gray-50 transition ${
                                                        selectedRecordId === record.id
                                                            ? 'bg-blue-50 border-l-4 border-blue-500'
                                                            : ''
                                                    }`}
                                                >
                                                    <div className="font-medium text-gray-900">
                                                        {record.name}
                                                    </div>
                                                    <div className="text-sm text-gray-500">
                                                        {record.phone}
                                                    </div>
                                                    <div className="text-xs text-gray-400 mt-1">
                                                        ID: {record.id}
                                                    </div>
                                                </button>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Right: Details and Actions */}
                    <div className="lg:col-span-2">
                        {selectedRecord ? (
                            <div className="space-y-6">
                                {/* Record Details */}
                                <div className="bg-white rounded-lg shadow p-6">
                                    <h3 className="text-xl font-semibold text-gray-900 mb-4">
                                        Detaljer
                                    </h3>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">
                                                Namn
                                            </label>
                                            <p className="mt-1 text-gray-900">{selectedRecord.name}</p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">
                                                Telefon
                                            </label>
                                            <p className="mt-1 text-gray-900">
                                                <a
                                                    href={`tel:${selectedRecord.phone}`}
                                                    className="text-blue-600 hover:text-blue-800"
                                                >
                                                    {selectedRecord.phone}
                                                </a>
                                            </p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">
                                                Email
                                            </label>
                                            <p className="mt-1 text-gray-900">
                                                <a
                                                    href={`mailto:${selectedRecord.email}`}
                                                    className="text-blue-600 hover:text-blue-800"
                                                >
                                                    {selectedRecord.email}
                                                </a>
                                            </p>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">
                                                Status
                                            </label>
                                            <p className="mt-1">
                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {selectedRecord.status || 'Väntande'}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div className="mt-4 pt-4 border-t">
                                        <p className="text-xs text-gray-500">
                                            Skapad:{' '}
                                            {new Date(selectedRecord.created_at).toLocaleString(
                                                'sv-SE'
                                            )}
                                        </p>
                                        <p className="text-xs text-gray-500">
                                            Uppdaterad:{' '}
                                            {new Date(selectedRecord.updated_at).toLocaleString(
                                                'sv-SE'
                                            )}
                                        </p>
                                    </div>
                                </div>

                                {/* Outcome Form */}
                                <div className="bg-white rounded-lg shadow p-6">
                                    <h3 className="text-xl font-semibold text-gray-900 mb-4">
                                        Resultat
                                    </h3>
                                    <OutcomeForm record={selectedRecord} />
                                </div>

                                {/* Calendar */}
                                <div className="bg-white rounded-lg shadow p-6">
                                    <h3 className="text-xl font-semibold text-gray-900 mb-4">
                                        Kalender
                                    </h3>
                                    <Calendar />
                                </div>
                            </div>
                        ) : (
                            <div className="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                                Välj en kötransaktion för att visa detaljer
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

// Outcome Form Component
function OutcomeForm({ record }: { record: RingaData }) {
    const [outcome, setOutcome] = useState<string>('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);

        try {
            const response = await fetch(`/api/ringa-data/${record.id}/outcome`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ) as HTMLMetaElement | null,
                },
                body: JSON.stringify({ outcome }),
            });

            if (response.ok) {
                setOutcome('');
                // Reload or update the records
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            setLoading(false);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div>
                <label className="block text-sm font-medium text-gray-700">
                    Välj resultat
                </label>
                <select
                    value={outcome}
                    onChange={e => setOutcome(e.target.value)}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    <option value="">-- Välj --</option>
                    <option value="completed">Slutförd</option>
                    <option value="no_answer">Inget svar</option>
                    <option value="busy">Upptagen</option>
                    <option value="declined">Avvisad</option>
                    <option value="callback">Återring senare</option>
                </select>
            </div>
            <button
                type="submit"
                disabled={!outcome || loading}
                className="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 transition"
            >
                {loading ? 'Sparar...' : 'Spara resultat'}
            </button>
        </form>
    );
}
