<?php

namespace Log;

interface LogInterface
{
    function log(string $message): void;
}