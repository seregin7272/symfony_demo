<?php


namespace App\Service;
use Psr\Log\LoggerInterface;

class Test
{
    private $testParamMessage;

    public function __construct(LoggerInterface $logger, string  $testParamMessage)
    {
        $this->testParamMessage = $testParamMessage;
    }

    public function getMessage()
    {
        return $this->testParamMessage;
    }
}
