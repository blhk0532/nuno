<?php

namespace App\Filament\Actions\PostNummerChecks;

use App\Models\HittaData;
use App\Models\MerinfoData;
use App\Models\PostNum;
use App\Models\RatsitData;
use Filament\Notifications\Notification;

class CheckDbCountsAction
{
    /**
     * Count records in each data table for a given post_nummer and update the PostNum record.
     *
     * @param  PostNum  $record  The post_nummer record to update
     */
    public static function execute(PostNum $record): void
    {
        $postNum = $record->post_nummer;

        // Normalize postal code: remove spaces for Merinfo queries
        // Merinfo data uses format "15332", PostNum uses "153 32"
        $postNumNormalized = str_replace(' ', '', $postNum);

        // Count Hitta Data records - persons (not houses)
        $hittaPersonerSaved = HittaData::where('postnummer', $postNum)
            ->where('is_active', true)
            ->count();

        // Count Hitta Data records - houses
        $hittaHusSaved = HittaData::where('postnummer', $postNum)
            ->where('is_active', true)
            ->where('is_hus', true)
            ->count();

        // Count Hitta Data records - persons with phone
        $hittaPersonerPhoneSaved = HittaData::where('postnummer', $postNum)
            ->where('is_active', true)
            ->where('is_telefon', true)
            ->count();

        // Count Hitta Data records - companies with phone (houses with phone)
        $hittaForetagPhoneSaved = HittaData::where('postnummer', $postNum)
            ->where('is_active', true)
            ->where('is_hus', true)
            ->where('is_telefon', true)
            ->count();

        // Count Ratsit Data records - all persons
        $ratsitPersonerSaved = RatsitData::where('postnummer', $postNum)
            ->where('is_active', true)
            ->count();

        // Count Ratsit Data records - persons with phone
        $ratsitPersonerPhoneSaved = RatsitData::where('postnummer', $postNum)
            ->where('is_active', true)
            ->whereNotNull('telefon')
            ->count();

        // Count Ratsit Data records - houses (using is_hus, but RatsitData might not have this field)
        $ratsitPersonerHouseSaved = RatsitData::where('postnummer', $postNum)
            ->where('agandeform', 'Äganderätt')
            ->count();

        //    $ratsitPersonerHouseSaved = RatsitData::where('postnummer', $postNum)
        //    ->where('agandeform', 'Äganderätt')
        //    ->orWhere('agandeform', 'Tomträtt')
        //    ->count();

        // Count Ratsit Data records - companies (not a separate type in Ratsit, so 0)
        $ratsitForetagSaved = 0;

        // Count Merinfo Data records - persons (is_hus = false/0)
        $merinfoPersonerSaved = MerinfoData::where('postnummer', $postNumNormalized)
            ->where('is_active', true)
            ->count();

        // Count Merinfo Data records - persons with phone (is_hus = false/0 AND is_telefon = true)
        $merinfoPersonerPhoneSaved = MerinfoData::where('postnummer', $postNumNormalized)
            ->where('is_active', true)
            ->where('is_telefon', true)
            ->count();

        // Count Merinfo Data records - persons_house_saved (set to 0 - not applicable for merinfo)
        $merinfoPersonerHouseSaved = MerinfoData::where('postnummer', $postNumNormalized)
            ->where('is_active', true)
            ->where('is_hus', true)
            ->count();

        // Count Merinfo Data records - companies (is_hus = true/1)
        $merinfoForetagSaved = 0;

        // Count Merinfo Data records - companies with phone (is_hus = true/1 AND is_telefon = true)
        $merinfoForetagPhoneSaved = MerinfoData::where('postnummer', $postNumNormalized)
            ->where('is_active', true)
            ->where('is_hus', true)
            ->where('is_telefon', true)
            ->count();

        // Update the PostNum record
        $record->update([
            'hitta_personer_saved' => $hittaPersonerSaved,
            'hitta_personer_house_saved' => $hittaHusSaved,
            'hitta_personer_phone_saved' => $hittaPersonerPhoneSaved,
            'hitta_foretag_saved' => $hittaForetagPhoneSaved,
            'ratsit_personer_saved' => $ratsitPersonerSaved,
            'ratsit_personer_phone_saved' => $ratsitPersonerPhoneSaved,
            'ratsit_personer_house_saved' => $ratsitPersonerHouseSaved,
            'ratsit_foretag_saved' => $ratsitForetagSaved,
            'merinfo_personer_saved' => $merinfoPersonerSaved,
            'merinfo_personer_house_saved' => $merinfoPersonerHouseSaved,
            'merinfo_foretag_saved' => $merinfoForetagSaved,
            'merinfo_personer_phone_saved' => $merinfoPersonerPhoneSaved,
            'merinfo_foretag_phone_saved' => $merinfoForetagPhoneSaved,
        ]);

        Notification::make()
            ->success()
            ->title('DB Counts Updated')
            ->body("Successfully counted and updated database statistics for {$postNum}.")
            ->send();
    }
}
