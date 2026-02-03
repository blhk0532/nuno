<?php

declare(strict_types=1);

/**
 * Ringa Data Outcome Delay Configuration
 *
 * Configure how long to delay the available_at timestamp for each outcome.
 * Delays are specified in minutes.
 *
 * Outcomes without an entry will not update available_at.
 */

return [
    /**
     * Delay in minutes when outcome is "Ej Framkopplad" (Not connected)
     */
    'EjFramkopplad' => 60, // 1 hour

    /**
     * Delay in minutes when outcome is "Upptagen" (Busy)
     */
    'Upptagen' => 30, // 30 minutes

    /**
     * Delay in minutes when outcome is "Telefonsvar" (Voicemail)
     */
    'Voicemail' => 120, // 2 hours

    /**
     * Delay in minutes when outcome is "Inget Svar" (No answer)
     */
    'IngetSvar' => 45, // 45 minutes
];
