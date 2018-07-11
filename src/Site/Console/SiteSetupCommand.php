<?php

namespace QuadStudio\Service\Site\Console;

use QuadStudio\Tools\Console\ToolsSetupCommand;

class SiteSetupCommand extends ToolsSetupCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'site:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup service site';

    /**
     * @param $path
     * @return string
     */
    public function packagePath($path): string
    {
        return __DIR__ . "/../../{$path}";
    }


}