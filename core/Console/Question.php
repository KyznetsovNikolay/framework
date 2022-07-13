<?php

declare(strict_types=1);

namespace Framework\Console;

class Question
{
    public static function choose(Input $input, Output $output, string $prompt, array $options): string
    {
        do {
            $output->write($prompt . ' [' . implode(',', $options) . ']: ');
            $choose = trim($input->read());
        } while (!\in_array($choose, $options, true));
        return $choose;
    }
}
