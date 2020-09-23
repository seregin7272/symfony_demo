<?php

namespace App\Command;

use App\Repository\ArticleRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';
    private $articleRepository;

    public function __construct(string $name = null, ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Returns some article stats!')
            ->addArgument('slug', InputArgument::OPTIONAL, 'The article\'s slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');
        $article = $this->articleRepository->findOneBy(['slug' => $slug]);

        if(!$article){
            $io->error('Статья не найдена');
            return 0;
        }


        $data = [
            'slug' => $slug,
            'hearts' =>  $article->getHeartCount(),
        ];

        switch ($input->getOption('format')) {
            case 'table':
                $rows = [];
                foreach ($data as $key => $val) {
                    $rows[] = [$key, $val];
                }
                $io->table(['Key', 'Value'], $rows);
                break;
            case 'text':
                $io->listing($data);
                break;
            case 'json':
                $io->write(json_encode($data));
                break;
            default:
                throw new \Exception('What kind of crazy format is that!?');
        }

        // $io->success('aticle OK');

        return 0;
    }
}
