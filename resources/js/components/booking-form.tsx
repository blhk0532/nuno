import React, { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface BookingFormProps {
  onSubmit?: (data: BookingFormData) => void;
  loading?: boolean;
}

export interface BookingFormData {
  service_date: string;
  start_time: string;
  end_time: string;
  booking_client_id?: number;
  service_id?: number;
  booking_location_id?: number;
  service_user_id?: number;
  booking_calendar_id?: number;
  status?: string;
  total_price?: number;
  notes?: string;
  service_note?: string;
  phone?: string;
  email?: string;
}

export function BookingForm({ onSubmit, loading = false }: BookingFormProps) {
  const [formData, setFormData] = useState<BookingFormData>({
    service_date: new Date().toISOString().split('T')[0],
    start_time: '09:00',
    end_time: '10:00',
    status: 'booked',
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
    const { name, value, type } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: type === 'number' ? parseFloat(value) : value,
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit?.(formData);
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        {/* Service Date */}
        <div>
          <Label htmlFor="service_date" className="text-sm">
            Servicedatum *
          </Label>
          <Input
            id="service_date"
            name="service_date"
            type="date"
            value={formData.service_date}
            onChange={handleChange}
            required
          />
        </div>

        {/* Start Time */}
        <div>
          <Label htmlFor="start_time" className="text-sm">
            Starttid *
          </Label>
          <Input
            id="start_time"
            name="start_time"
            type="time"
            value={formData.start_time}
            onChange={handleChange}
            required
          />
        </div>

        {/* End Time */}
        <div>
          <Label htmlFor="end_time" className="text-sm">
            Sluttid *
          </Label>
          <Input
            id="end_time"
            name="end_time"
            type="time"
            value={formData.end_time}
            onChange={handleChange}
            required
          />
        </div>

        {/* Status */}
        <div>
          <Label htmlFor="status" className="text-sm">
            Status
          </Label>
          <select
            id="status"
            name="status"
            value={formData.status || 'booked'}
            onChange={handleChange}
            className="w-full px-3 py-2 border border-input rounded-md bg-background"
          >
            <option value="booked">Bokad</option>
            <option value="confirmed">Bekräftad</option>
            <option value="cancelled">Inställd</option>
            <option value="completed">Slutförd</option>
          </select>
        </div>

        {/* Phone */}
        <div>
          <Label htmlFor="phone" className="text-sm">
            Telefon
          </Label>
          <Input
            id="phone"
            name="phone"
            type="tel"
            placeholder="+46..."
            value={formData.phone || ''}
            onChange={handleChange}
          />
        </div>

        {/* Email */}
        <div>
          <Label htmlFor="email" className="text-sm">
            E-post
          </Label>
          <Input
            id="email"
            name="email"
            type="email"
            placeholder="namn@exempel.se"
            value={formData.email || ''}
            onChange={handleChange}
          />
        </div>

        {/* Total Price */}
        <div>
          <Label htmlFor="total_price" className="text-sm">
            Pris (SEK)
          </Label>
          <Input
            id="total_price"
            name="total_price"
            type="number"
            step="0.01"
            min="0"
            placeholder="0.00"
            value={formData.total_price || ''}
            onChange={handleChange}
          />
        </div>

        {/* Service User ID */}
        <div>
          <Label htmlFor="service_user_id" className="text-sm">
            Tekniker ID
          </Label>
          <Input
            id="service_user_id"
            name="service_user_id"
            type="number"
            placeholder="ID"
            value={formData.service_user_id || ''}
            onChange={handleChange}
          />
        </div>
      </div>

      {/* Notes */}
      <div>
        <Label htmlFor="notes" className="text-sm">
          Anteckningar
        </Label>
        <textarea
          id="notes"
          name="notes"
          rows={3}
          placeholder="Lägg till anteckningar om bokningen..."
          value={formData.notes || ''}
          onChange={handleChange}
          className="w-full px-3 py-2 border border-input rounded-md bg-background text-sm"
        />
      </div>

      {/* Service Notes */}
      <div>
        <Label htmlFor="service_note" className="text-sm">
          Serviceanteckningar
        </Label>
        <textarea
          id="service_note"
          name="service_note"
          rows={3}
          placeholder="Interna anteckningar för serviceteamet..."
          value={formData.service_note || ''}
          onChange={handleChange}
          className="w-full px-3 py-2 border border-input rounded-md bg-background text-sm"
        />
      </div>

      {/* Submit Button */}
      <Button type="submit" disabled={loading} className="w-full">
        {loading ? 'Sparar...' : 'Skapa bokning'}
      </Button>
    </form>
  );
}
