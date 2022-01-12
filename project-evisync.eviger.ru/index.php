<?php
declare(strict_types=1);

header('Access-Control-Allow-Origin: *');

require_once "../filesEviSync/vendor/autoload.php";

use EviSync\Api\DTO\Response;
use EviSync\Api\DTO\selfThrows;
use EviSync\Api\Tools\Other;

preg_match("~/methods/(.*)~", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches);

if (count($matches) === 0) {
    echo "API for eviSync";
    die();
} else {
    header('Content-Type: application/json; charset=utf-8');
}

$method = $matches[1];
$mixedData = $_SERVER['REQUEST_METHOD'] === "GET" ? $_GET : json_decode(file_get_contents('php://input'), true);

try {

    if (!isset($method) || $method === "") throw new selfThrows(["message" => "method parameter is missing or null"]);

    if (!isset($mixedData['token']) || $mixedData['token'] === "") throw new selfThrows(["message" => "token parameter is missing or null"]);

    Other::checkToken($mixedData['token']);

    switch ($method) {

        case "getPathsToArchives":
            // todo: get paths and files by account token
            (new Response)
                ->setStatus("wait")
                ->setResponse(["message" => "method not ready"])
                ->send();

        default:
            throw new selfThrows(["message" => "unknown method", "parameters" => $mixedData]);

    }

} catch (selfThrows $e) {

    die($e->getMessage());

} catch (Throwable $exceptions) {

    Other::log("Error: " . $exceptions->getMessage() . " on line: " . $exceptions->getLine() . " in: " . $exceptions->getFile());
    (new Response)->setStatus("error")->setResponse(["message" => "internal error, try later"])->send();

}