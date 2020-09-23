<?php

namespace App\Command;

use App\Rabbit\Rabbit;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendRabbitCommand extends Command
{
    protected static $defaultName = 'rabbit:send';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ->addArgument('data', InputArgument::REQUIRED, 'The article\'s slug');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $input->getArgument('data');

        Rabbit::create()
            ->setChannelName()
            ->sendMessage($data);


        return 0;
    }
}
