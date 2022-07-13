<?php

declare(strict_types=1);

namespace Framework\Console\Command;

use Framework\Service\FileManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
            ->setDescription('Clear cache')
            ->addArgument('alias', InputArgument::OPTIONAL, 'The alias of available paths.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Clearing cache</comment>');

        $alias = $input->getArgument('alias');

        if (empty($alias)) {
            $helper = $this->getHelper('question');
            $options = array_merge(['all'], array_keys($this->paths));
            $question = new ChoiceQuestion('Choose path', $options, 0);
            $alias = $helper->ask($input, $output, $question);
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

        return 0;
    }
}
