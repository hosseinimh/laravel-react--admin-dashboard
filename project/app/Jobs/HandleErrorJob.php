<?php

namespace App\Jobs;

use App\Models\Error;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleErrorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $error;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($e)
    {
        $this->error = $e;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->storeError($this->error);
    }

    private function storeError($e)
    {
        try {
            $message = 'url: ' . url()->current();
            $message .= "
";
            $message .= "
" . is_string($e) ? $e : $e->__toString();

            foreach (getallheaders() as $name => $value) {
                $message .= "
$name: $value";
            }

            Error::create(['message' => $message]);
        } catch (\Exception) {
        }
    }
}
