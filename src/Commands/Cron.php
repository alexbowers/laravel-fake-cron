<?php

namespace AlexBowers\LaravelFakeCron\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;


class Cron extends Command
{
    protected $signature = 'cron {--interval=60}';

    protected $description = 'A fake cron job scheduler';

    protected $shouldQuit = false;
    protected $paused = false;

    public function handle()
    {
        $this->comment("Cron has been started");
        if ($this->supportsAsyncSignals()) {
            $this->listenForSignals();
        }

        
        while (true) {
            $bar = $this->output->createProgressBar($this->option('interval'));

            for ($i = 0; $i < $this->option('interval'); $i++) {
                if ($this->shouldQuit) {
                    exit(0);
                }

                $bar->advance();

                sleep(1);
            }

            $bar->finish();
            $bar->clear();
            
            if (!$this->paused) {
                Artisan::call('schedule:run');
                $this->output->write(Artisan::output());
            }

        }
    }

    /**
     * @see https://github.com/laravel/framework/blob/5.8/src/Illuminate/Queue/Worker.php#L513-L528
     */
    protected function listenForSignals()
    {
        pcntl_async_signals(true);

        pcntl_signal(SIGTERM, function () {
            $this->shouldQuit = true;
        });

        pcntl_signal(SIGUSR2, function () {
            $this->paused = true;
        });

        pcntl_signal(SIGCONT, function () {
            $this->paused = false;
        });
    }

    /**
     * @see https://github.com/laravel/framework/blob/5.8/src/Illuminate/Queue/Worker.php#L535-L538
     */
    protected function supportsAsyncSignals()
    {
        return extension_loaded('pcntl');
    }
}