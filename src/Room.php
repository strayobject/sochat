<?php
namespace SoChat;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Room
{
    private $chat;
    private $private;


    public function __construct(SoChat\Chat $chat)
    {
        $this->chat = $chat;
    }

    public function join()
    {
    }

    public function leave()
    {
    }

    public function add()
    {
    }

    public function kick()
    {

    }

    public function ban()
    {

    }

    /**
     * Gets the value of chat.
     *
     * @return mixed
     */
    public function getChat()
    {
        return $this->chat;
    }
    
    /**
     * Sets the value of chat.
     *
     * @param mixed $chat the chat 
     *
     * @return self
     */
    public function setChat($chat)
    {
        $this->chat = $chat;

        return $this;
    }
}