<?php

namespace Mprince2k18\SaasPlanner\Commands;

use Illuminate\Console\Command;

class SaasPlannerCommand extends Command
{
    public $signature = 'saas-planner';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
