<?php

namespace App\Jobs;

use App\Mail\RegistrationCancelEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RegistrationConfirmationCancelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $dataEmail,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**Email de confirmação de cancelamento de inscrição é enviado */
        try {
            Mail::to($this->dataEmail['email'])
                ->send(new RegistrationCancelEmail($this->dataEmail));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
