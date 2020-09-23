<?php


namespace App\Rabbit;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use phpDocumentor\Reflection\Types\This;

class Rabbit
{
    const CHANNEL_NAME = 'task_queue';
    private $connection;
    private $msg;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }


    public static function create()
    {
        return new static();
    }

    public function setChannelName()
    {
        $this->channel->queue_declare(self::CHANNEL_NAME, false, true, false, false);

        return $this;
    }

    public function sendMessage($data)
    {
        $msg = new AMQPMessage($data,  array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));

        $this->channel->basic_publish($msg, '', self::CHANNEL_NAME);

        echo ' [x] Sent ', $data, "\n";

        $this->channel->close();
        $this->connection->close();
    }

    public function receiveMessage()
    {
        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            echo ' sleep sec ', $countSleep = substr_count($msg->body, '.')  , "\n";
            sleep($countSleep);
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };
        $this->channel->basic_qos(null, 1, null); // не отправлять сообщения работнику пока он не обработает и не подтвердит предыдущее.
        $this->channel->basic_consume(self::CHANNEL_NAME, '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }

}