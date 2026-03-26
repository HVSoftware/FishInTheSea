<?php

namespace Log;

class ConsoleLogger implements LogInterface
{
    function log(string $message): void
    {
        echo $message . PHP_EOL;
    }
}