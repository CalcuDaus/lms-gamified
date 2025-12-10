<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoTranslationService;

class SyncTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize translation keys from English to Indonesian using Google Translate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting translation synchronization...');

        $enPath = lang_path('en/messages.php');
        $idPath = lang_path('id/messages.php');

        if (!file_exists($enPath)) {
            $this->error('English language file not found at: ' . $enPath);
            return;
        }

        // Load translation arrays
        $enMessages = require $enPath;
        $idMessages = file_exists($idPath) ? require $idPath : [];

        // Find missing keys
        $missingKeys = array_diff_key($enMessages, $idMessages);

        if (empty($missingKeys)) {
            $this->info('All translations are in sync! No new keys found.');
            return;
        }

        $this->info('Found ' . count($missingKeys) . ' missing keys. Translating...');

        $translator = new AutoTranslationService();

        $newTranslations = [];
        $bar = $this->output->createProgressBar(count($missingKeys));
        $bar->start();

        foreach ($missingKeys as $key => $text) {
            try {
                // Translate using our service
                $translated = $translator->translate($text, 'id', 'en');
                $newTranslations[$key] = $translated;
            } catch (\Exception $e) {
                $this->warn("\nFailed to translate '{$key}': " . $e->getMessage());
                $newTranslations[$key] = $text; // Fallback to English
            }
            $bar->advance();
            // Sleep slightly to avoid rate limiting
            usleep(200000); // 0.2s
        }

        $bar->finish();
        $this->newLine();

        // Write to file (Preserving comments/structure by appending)
        $this->appendToIdFile($idPath, $newTranslations);

        $this->info('Successfully added ' . count($newTranslations) . ' translations to ' . $idPath);
    }

    private function appendToIdFile($filePath, $newTranslations)
    {
        if (!file_exists($filePath)) {
            // If file doesn't exist, create it from scratch properly
            $content = "<?php\n\nreturn [\n";
            foreach ($newTranslations as $key => $value) {
                $content .= "    '{$key}' => '" . addslashes($value) . "',\n";
            }
            $content .= "];\n";
            file_put_contents($filePath, $content);
            return;
        }

        // If file exists, try to append before the last "];"
        $content = file_get_contents($filePath);
        
        // Prepare new content block
        $newContent = "\n    // Automatically Generated\n";
        foreach ($newTranslations as $key => $value) {
            $value = str_replace("'", "\'", $value); // Escape single quotes
            $newContent .= "    '{$key}' => '{$value}',\n";
        }

        // Find the last occurrence of "];"
        $pos = strrpos($content, '];');
        
        if ($pos !== false) {
            // Insert before the closing bracket
            $finalContent = substr_replace($content, $newContent . "];", $pos, 2);
            file_put_contents($filePath, $finalContent);
        } else {
            // Fallback if file structure is weird
            $this->warn('Could not find closing tag ]; in file. Appending to end (might break syntax).');
            file_put_contents($filePath, $newContent, FILE_APPEND);
        }
    }
}
