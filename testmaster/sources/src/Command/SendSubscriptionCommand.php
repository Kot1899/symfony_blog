<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendSubscriptionCommand extends Command
{
    protected static $defaultName = 'send-subscription';
    protected static $defaultDescription = 'Это команда для тестовой рассылки сообщений';

    protected function configure(): void
    {
        $this
            ->addArgument('a', InputArgument::OPTIONAL, 'Argument description, B')
            ->addArgument('b', InputArgument::OPTIONAL, 'Argument description, C')
            ->addArgument('c', InputArgument::IS_ARRAY, 'Argument description, A')
            ->addOption('with-tg', null, InputOption::VALUE_NONE, 'Option description')
            ->addOption('with-vb', null, InputOption::VALUE_NONE, 'Option description')
            ->addOption('with-fb', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $b = $input->getArgument('b');
        $c = $input->getArgument('c');
        $a = $input->getArgument('a');

        //$exclude = $input->getOption('exclude-gmail');

        $output->writeln('<info>Hello write ln!</info>');
        $io->success('Hello success');
        $io->error('Hello error');

        $table = new Table($output);
        $table
            ->setHeaders(['ISBN', 'Title', 'Author', 'Alex!'])
            ->setRows([
                ['99921-58-10-7', 'Divine Comedy', 'Dante Alighieri'],
                ['9971-5-0210-0', 'A Tale of Two Cities', 'Charles Dickens'],
                ['960-425-059-0', 'The Lord of the Rings', 'J. R. R. Tolkien'],
                ['80-902734-1-6', 'And Then There Were None', 'Agatha Christie'],
            ])
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
