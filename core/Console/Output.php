<?php

declare(strict_types=1);

namespace Framework\Console;

class Output
{
    public function write(string $message): void
    {
        echo $this->process($message);
    }

    public function writeln(string $message): void
    {
        echo $this->process($message) . PHP_EOL;
    }

    /**
     * @param string $message
     * @return string
     */
    public function process(string $message): string
    {
        $done = "\033[0m";

        return strtr($message, [
            '<comment>' => "\033[33m", '</comment>' => $done,
            '<info>' => "\033[32m", '</info>' => $done,
            '<error>' => "\033[31m", '</error>' => $done,
            '<text>' => "\033[29m", '</text>' => $done,
        ]);
    }
}
