<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');
        $host     = config('database.connections.pgsql.host');
        $port     = config('database.connections.pgsql.port', 5432);
        $filename = storage_path('app/backups/backup_' . now()->format('Ymd_His') . '.sql');

        $command = [
            'pg_dump',
            '-U', $username,
            '-h', $host,
            '-p', $port,
            $database,
        ];

        $process = new Process($command, null, [
            'PGPASSWORD' => $password,
        ]);

        try {
            $this->info('Starting database backup...');

            $directoryPath = storage_path('app/backups');
            if (!is_dir(storage_path('app/backups'))
                && !mkdir($directoryPath, 0755, true)
                && !is_dir($directoryPath)
            ) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $directoryPath));
            }

            $process->mustRun(function ($type, $buffer) use ($filename) {
                file_put_contents($filename, $buffer, FILE_APPEND);
            });

            $this->info('Database backup completed successfully.');
        } catch (ProcessFailedException $exception) {
            logger()->error('Database backup failed', ['exception' => $exception]);
            $this->error('Database backup failed.');
        }
    }
}
