<?php

namespace QuadStudio\Service\Site\Console;

use Illuminate\Console\Command;

class SiteRunCommand extends Command
{

    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'site:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run service site';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    public function handle()
    {
        $files = glob(database_path('migrations/*'));
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
        }
        foreach (config('site.run', []) as $run) {
            $this->call($run[0], $run[1]);

            //$this->callSilent($run);
//            $this->call($run, [
//                '--force' => true
//            ]);
        }

    }

}