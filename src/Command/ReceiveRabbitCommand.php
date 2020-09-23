<?php

namespace App\Command;

use App\Rabbit\Rabbit;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ReceiveRabbitCommand extends Command
{
    protected static $defaultName = 'rabbit:recive';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        Rabbit::create()
            ->setChannelName()
            ->receiveMessage();


        return 0;
    }
}
