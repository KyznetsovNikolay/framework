<?php

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator(
    [
        new PhpFileProvider(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php'),
    ],
    'var/app.php'
);

return $aggregator->getMergedConfig();
