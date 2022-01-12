<?php

declare(strict_types=1);

namespace EviSync\Contracts;

interface Singleton
{
    /**
     * @return static
     */
    public static function getInstance();
}