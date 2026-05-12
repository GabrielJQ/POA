<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DecryptMontoCommand extends Command
{
    protected $signature = 'poa:decrypt-monto';
    protected $description = 'Descifra todos los valores de monto en registros_financieros y los deja en texto plano';

    public function handle(): int
    {
        $this->info('Iniciando descifrado de montos...');

        $total = DB::table('registros_financieros')->count();
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $errors = 0;
        DB::table('registros_financieros')
            ->orderBy('id')
            ->chunk(100, function ($records) use ($bar, &$errors) {
                foreach ($records as $record) {
                    try {
                        if (empty($record->monto)) {
                            $decrypted = '0';
                        } else {
                            $decrypted = Crypt::decryptString($record->monto);
                        }
                        DB::table('registros_financieros')
                            ->where('id', $record->id)
                            ->update(['monto' => $decrypted]);
                    } catch (\Exception $e) {
                        $this->warn("Error en registro ID {$record->id}: {$e->getMessage()}");
                        $errors++;
                    }
                    $bar->advance();
                }
            });

        $bar->finish();
        $this->newLine();
        $this->info("Descifrado completado. {$total} registros procesados, {$errors} errores.");

        return Command::SUCCESS;
    }
}
