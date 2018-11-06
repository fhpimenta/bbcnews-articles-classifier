<?php

namespace BBCNewsClassifier\Commands;

use BBCNewsClassifier\Stages\Classify;
use BBCNewsClassifier\Stages\Extract;
use League\Pipeline\Pipeline;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Classification extends Command
{
    protected function configure()
    {
        $this->setName('classification')
            ->setDescription('Classify articles')
            ->setHelp('This command classify articles')
            ->addArgument('url', InputArgument::REQUIRED, 'URL article to classification');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $style = new SymfonyStyle($input, $output);

        $pipeline = (new Pipeline)
                    ->pipe(new Extract)
                    ->pipe(new Classify);

        try {
            $response = $pipeline->process($url);
            $output->writeln('Category: ' . $response);
        } catch (\Exception $e) {
            $style->error($e->getMessage());
        }
    }
}