<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // User is authenticated via middleware
    }

    public function rules(): array
    {
        return [
            'service_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'booking_client_id' => 'nullable|integer|exists:booking_clients,id',
            'service_id' => 'nullable|integer|exists:booking_services,id',
            'booking_location_id' => 'nullable|integer|exists:booking_locations,id',
            'service_user_id' => 'nullable|integer|exists:users,id',
            'booking_calendar_id' => 'nullable|integer|exists:booking_calendars,id',
            'status' => ['nullable', Rule::in(['booked', 'confirmed', 'cancelled', 'completed'])],
            'total_price' => 'nullable|numeric|min:0|max:999999.99',
            'notes' => 'nullable|string|max:1000',
            'service_note' => 'nullable|string|max:1000',
            'title' => 'required|string|max:256',
            'description' => 'required|string|max:1000',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:256',
            'color' => 'nullable|string|max:64',
            'google_event_id' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'service_date.after_or_equal' => 'Bokningsdatumet kan inte vara i det förflutna.',
            'end_time.after' => 'Sluttiden måste vara efter starttiden.',
            'total_price.max' => 'Priset får inte överstiga 999 999 SEK.',
            'notes.max' => 'Anteckningar får inte vara längre än 1000 tecken.',
            'service_note.max' => 'Serviceanteckningar får inte vara längre än 1000 tecken.',
        ];
    }
}
