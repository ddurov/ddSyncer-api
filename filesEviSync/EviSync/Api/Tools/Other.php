<?php

declare(strict_types=1);

namespace EviSync\Api\Tools;

use Evisync\Api\DTO\selfThrows;
use Evisync\Database;
use Krugozor\Database\MySqlException;
use RuntimeException;

class Other
{

    /**
     * @param string $token
     * @return void
     * @throws selfThrows|MySqlException
     */
    public static function checkToken(string $token): void
    {

        if (!Database::getInstance()->query("SELECT * FROM evisync.evisync_tokens WHERE token = '?s'", $token)->getNumRows()) throw new selfThrows(["message" => "token not found"]);

    }

    /**
     * @param mixed $message
     */
    public static function log($message): void
    {
        if (!file_exists('/var/log/eviSyncAPI/') && !mkdir('/var/log/eviSyncAPI/', 0777, true) && !is_dir('/var/log/eviSyncAPI/')) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', '/var/log/eviSyncAPI/'));
        }
        $time = date('D M j G:i:s');
        file_put_contents("/var/log/eviSyncAPI/error.log", "[$time]: $message\n", FILE_APPEND);
    }

    /**
     * @throws selfThrows
     */
    public static function postUsageMethod(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") throw new selfThrows(["message" => "this method usage only POST requests"]);
    }
}