<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmationMail;

class RegistrationConfirmationJob implements ShouldQueue
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
      
        /**Email de confirmação de inscrição é enviado */
        try {
            Mail::to($this->dataEmail['email']) 
            ->send(new RegistrationConfirmationMail($this->dataEmail));    
        } catch (\Exception $e) {  
            dd($e->getMessage());     
            echo $e->getMessage();
        }
    }
}
