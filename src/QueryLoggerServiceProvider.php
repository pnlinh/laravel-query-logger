<?php

namespace Pnlinh\QueryLogger;

use DateTime;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class QueryLoggerServiceProvider extends ServiceProvider
{
    public const MYSQL = 'mysql';
    public const SQLITE = 'sqlite';
    public const MONGODB = 'mongodb';

    /**
     * Bootstrap services.
     *
     * @param Request $request
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if (!config('app.debug')) {
            return;
        }

        $logger = app('log');

        $logger->info('STARTING REQUEST');
        $logger->info(sprintf('[%s] -> %s', $request->method(), $request->path()));

        $this->listenQueryLogging($logger);
    }

    /**
     * Listen connection event.
     *
     * @param LogManager $logger
     */
    protected function listenQueryLogging(LogManager $logger)
    {
        app('db')->connection()->enableQueryLog();

        app('db')->listen(function (QueryExecuted $query) use ($logger) {
            $driver = $query->connection->getDriverName();

            if (in_array($driver, [static::SQLITE, static::MYSQL])) {
                $this->writeMySqlLog($query, $logger);
            }

            if ($driver === static::MONGODB) {
                $this->writeMongoDbLog($query, $logger);
            }
        });
    }

    /**
     * Write mysql log.
     *
     * @param QueryExecuted $query
     * @param LogManager    $logger
     */
    protected function writeMySqlLog(QueryExecuted $query, LogManager $logger)
    {
        foreach ($query->bindings as &$binding) {
            if ($binding instanceof DateTime) {
                $binding = Carbon::instance($binding)->toDateTimeString();
            }
        }

        $sql = $query->sql;
        $sql = str_replace(['%', '?'], ['**', '"%s"'], $sql);
        $sql = vsprintf(str_replace('?', '"%s"', $sql), $query->bindings);
        $sql = str_replace('**', '%', $sql);

        $messages = [
            '[SQL]',
            sprintf('[%s]', strtoupper($query->connectionName)),
            sprintf('[%s ms]', str_pad($query->time, 4, 0)),
            $sql,
        ];
        $logger->info(implode(' ', $messages));
    }

    /**
     * Write mongodb log.
     *
     * @param QueryExecuted $query
     * @param LogManager    $logger
     */
    protected function writeMongoDbLog(QueryExecuted $query, LogManager $logger)
    {
        $messages = [
            '[MONGODB]',
            sprintf('[%s]', strtoupper($query->connectionName)),
            sprintf('[%s ms]', str_pad($query->time, 4, 0)),
            $query->sql,
        ];
        $logger->info(implode(' ', $messages));
    }
}
