<?php

namespace App\Observers;

use App\Jobs\{
    RegistrationConfirmationCancelJob,
    RegistrationConfirmationJob
};
use App\Models\Registration;
use Carbon\Carbon;

class RegistrationObserver
{
    /**
     * Handle the Registration "created" event.
     */

    public function created(Registration $registration): void
    {
        /** Job executado para disparar o email de confirmação de inscrição. */
        $dataEmail = $this->buildEmailData($registration);
        RegistrationConfirmationJob::dispatch($dataEmail);
    }

    /**
     * Handle the Registration "deleted" event.
     */

    public function deleted(Registration $registration): void
    {
        /** Job executado para disparar o email de cancelamento de inscrição. */
        $dataEmail = $this->buildEmailData($registration);
        RegistrationConfirmationCancelJob::dispatch($dataEmail);
    }

    private function buildEmailData(Registration $registration): array
    {
        $registration->event->start_date = formatDateTimeBr($registration->event->start_date);
        $registration->event->end_date = formatDateTimeBr($registration->event->end_date);
        $registration->event->categoria = $registration->event->category->name;

        return [
            'participant_name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'cpf' => auth()->user()->cpf,
            'data_birth' => formatDateBr(auth()->user()->data_birth),
            'address' => auth()->user()->address,
            ...$registration->event->toArray()
        ];
    }
}
