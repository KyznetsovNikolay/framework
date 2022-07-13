<?php

declare(strict_types=1);

namespace Framework\Console\Command;

use Framework\Console\Command;
use Framework\Console\Input;
use Framework\Console\Output;
use Framework\Console\Question;
use Framework\Service\FileManager;

class CacheClearCommand extends Command
{
    /**
     * @var array
     */
    private array $paths;

    /**
     * @var FileManager
     */
    private FileManager $fileManager;

    public function __construct(FileManager $fileManager, array $paths)
    {
        $this->paths = $paths;
        $this->fileManager = $fileManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('cache:clear')
            ->setDescription('Clear cache');
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('<comment>Clearing cache</comment>');

        $alias = $input->getArgument(1);

        if (empty($alias)) {
            $options = array_merge(['all'], array_keys($this->paths));
            $alias = Question::choose($input, $output, 'Choose path', $options);
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new \InvalidArgumentException('Unknown path alias "' . $alias . '"');
            }
            $paths = [$alias => $this->paths[$alias]];
        }

        foreach ($paths as $path) {
            if ($this->fileManager->exists($path)) {
                $output->writeln('Remove ' . $path);
                $this->fileManager->delete($path);
            } else {
                $output->writeln('Skip ' . $path);
            }
        }

        $output->writeln('<info>Done!</info>');
    }
}
