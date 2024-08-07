<?php

namespace App\Console\Commands;

use App\Models\Pricelist;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class PricelistSelector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pricelist:select {title}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select a pricelist that is going to be the main pricelist for given products.';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'title' => 'Which pricelist title should be set?',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $title = $this->argument('title');

        $pricelist = Pricelist::where('title', $title)->first();

        if (!$pricelist) {
            return $this->error("Pricelist with the title '{$title}' does not exist.");
        }

        $this->updatePricelistConfig($pricelist->title);
    }

    function updatePricelistConfig($newTitle)
    {
        $configFilePath = config_path('pricelist.php');
        $configContent = File::get($configFilePath);

        $updatedConfigContent = preg_replace(
            "/('selected' => )'([^']*)'/",
            "$1'$newTitle'",
            $configContent
        );

        File::put($configFilePath, $updatedConfigContent);

        if (app()->configurationIsCached()) {
            Artisan::call('config:cache');
        }
    }
}
