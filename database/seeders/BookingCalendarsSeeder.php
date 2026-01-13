<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Adultdate\FilamentBooking\Models\BookingCalendar;

class BookingCalendarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calendars = [
            [
                'name' => 'Tekniker 1',
                'google_calendar_id' => '274c238f47b20623ea8d9a160e9fb4ec0e48568fa1e9556659a1ca414b83baac@group.calendar.google.com',
                'whatsapp_id' => null,
                'creator_id' => 1,
                'owner_id' => 16,
                'brand_id' => 1,
                'service_ids' => [1],
                'notify_emails' => 'admin@ndsth.com, super@ndsth.com',
                'access' => [1, 2, 3, 4, 5, 6, 8, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
                'is_active' => true,
                'notification_user_ids' => ['user-1', 'user-2', 'user-3'],
                'public_url' => 'https://calendar.google.com/calendar/embed?src=274c238f47b20623ea8d9a160e9fb4ec0e48568fa1e9556659a1ca414b83baac%40group.calendar.google.com&ctz=Europe%2FStockholm',
                'embed_code' => '<iframe src="https://calendar.google.com/calendar/embed?src=274c238f47b20623ea8d9a160e9fb4ec0e48568fa1e9556659a1ca414b83baac%40group.calendar.google.com&ctz=Europe%2FStockholm" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>',
                'public_address_ical' => 'https://calendar.google.com/calendar/ical/274c238f47b20623ea8d9a160e9fb4ec0e48568fa1e9556659a1ca414b83baac%40group.calendar.google.com/public/basic.ics',
                'secret_address_ical' => 'https://calendar.google.com/calendar/ical/274c238f47b20623ea8d9a160e9fb4ec0e48568fa1e9556659a1ca414b83baac%40group.calendar.google.com/private-b2a3ff8e71c77945102eb0110c4c175b/basic.ics',
                'whatsapp_numbers' => ['019bb5a1-ca44-70e8-b15a-4d1229d95cca', '019bb5a2-2508-71ff-9801-1dec9cddd906'],
                'shareable_link' => 'https://calendar.google.com/calendar/u/0?cid=Mjc0YzIzOGY0N2IyMDYyM2VhOGQ5YTE2MGU5ZmI0ZWMwZTQ4NTY4ZmExZTk1NTY2NTlhMWNhNDE0YjgzYmFhY0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t',
                'created_at' => '2026-01-12T15:40:57.000000Z',
                'updated_at' => '2026-01-13T05:47:34.000000Z',
            ],
            [
                'name' => 'Tekniker 2',
                'google_calendar_id' => '26823e687633703bb2d35cf812c2ba84757d8265115883e3e1c193bbea9b0011@group.calendar.google.com',
                'whatsapp_id' => null,
                'creator_id' => 1,
                'owner_id' => 17,
                'brand_id' => 1,
                'service_ids' => [1],
                'notify_emails' => 'admin@ndsth.com',
                'access' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15],
                'is_active' => true,
                'notification_user_ids' => ['user-1', 'user-3', 'user-2', 'user-5'],
                'public_url' => 'https://calendar.google.com/calendar/embed?src=26823e687633703bb2d35cf812c2ba84757d8265115883e3e1c193bbea9b0011%40group.calendar.google.com&ctz=Europe%2FStockholm',
                'embed_code' => '<iframe src="https://calendar.google.com/calendar/embed?src=26823e687633703bb2d35cf812c2ba84757d8265115883e3e1c193bbea9b0011%40group.calendar.google.com&ctz=Europe%2FStockholm" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>',
                'public_address_ical' => 'https://calendar.google.com/calendar/ical/26823e687633703bb2d35cf812c2ba84757d8265115883e3e1c193bbea9b0011%40group.calendar.google.com/public/basic.ics',
                'secret_address_ical' => 'https://calendar.google.com/calendar/ical/26823e687633703bb2d35cf812c2ba84757d8265115883e3e1c193bbea9b0011%40group.calendar.google.com/private-be644bdda22bea7fd8d7821ab9ac4f89/basic.ics',
                'whatsapp_numbers' => ['019bb5a1-ca44-70e8-b15a-4d1229d95cca', '019bb5a2-2508-71ff-9801-1dec9cddd906'],
                'shareable_link' => 'https://calendar.google.com/calendar/u/0?cid=MjY4MjNlNjg3NjMzNzAzYmIyZDM1Y2Y4MTJjMmJhODQ3NTdkODI2NTExNTg4M2UzZTFjMTkzYmJlYTliMDAxMUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t',
                'created_at' => '2026-01-13T05:50:19.000000Z',
                'updated_at' => '2026-01-13T05:50:19.000000Z',
            ],
            [
                'name' => 'Tekniker 3',
                'google_calendar_id' => '658e512f720f12b3eec6906205932eac87a67f53b20196f03b32dad1f646041f@group.calendar.google.com',
                'whatsapp_id' => null,
                'creator_id' => 1,
                'owner_id' => 18,
                'brand_id' => null,
                'service_ids' => [],
                'notify_emails' => 'admin@ndsth.com',
                'access' => [1, 2, 3, 4, 5, 6, 9, 10, 12, 13, 11, 14, 15, 18],
                'is_active' => true,
                'notification_user_ids' => ['user-1', 'user-2', 'user-3', 'user-4', 'user-5'],
                'public_url' => 'https://calendar.google.com/calendar/embed?src=658e512f720f12b3eec6906205932eac87a67f53b20196f03b32dad1f646041f%40group.calendar.google.com&ctz=Europe%2FStockholm',
                'embed_code' => '<iframe src="https://calendar.google.com/calendar/embed?src=658e512f720f12b3eec6906205932eac87a67f53b20196f03b32dad1f646041f%40group.calendar.google.com&ctz=Europe%2FStockholm" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>',
                'public_address_ical' => 'https://calendar.google.com/calendar/ical/658e512f720f12b3eec6906205932eac87a67f53b20196f03b32dad1f646041f%40group.calendar.google.com/public/basic.ics',
                'secret_address_ical' => 'https://calendar.google.com/calendar/ical/658e512f720f12b3eec6906205932eac87a67f53b20196f03b32dad1f646041f%40group.calendar.google.com/private-c8d84c6ec2bf489717a9e9df4aec6b2d/basic.ics',
                'whatsapp_numbers' => ['019bb5a1-ca44-70e8-b15a-4d1229d95cca', '019bb5a2-2508-71ff-9801-1dec9cddd906'],
                'shareable_link' => 'https://calendar.google.com/calendar/u/0?cid=NjU4ZTUxMmY3MjBmMTJiM2VlYzY5MDYyMDU5MzJlYWM4N2E2N2Y1M2IyMDE5NmYwM2IzMmRhZDFmNjQ2MDQxZkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t',
                'created_at' => '2026-01-13T05:53:06.000000Z',
                'updated_at' => '2026-01-13T05:53:06.000000Z',
            ],
        ];

        foreach ($calendars as $calendar) {
            BookingCalendar::create($calendar);
        }
    }
}
