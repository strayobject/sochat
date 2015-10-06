<?php
namespace SoChat;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;
    private $dbUsers;
    /**
     * @todo remove coupling to Flintstone
     */
    public function __construct($dbUsers)
    {
        $this->clients = new \SplObjectStorage;
        $this->setDbUsers($dbUsers);
    }

    public function onOpen(ConnectionInterface $conn)
    {

        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        /**
         * Not happy with this.
         * @todo find a better way
         */
        $search = strpos($msg, 'has joined');

        if (strpos($msg, 'COM') === 0 && $search !== false) {
            $username = trim(substr($msg, 4, ($search-5)));

            $this->getDbUsers()->set(
                (string) $from->resourceId,
                [
                    'id' => $from->resourceId,
                    'username' => $username
                ]
            );
        }

        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d (%s) sends message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $username,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it.
        $this->clients->detach($conn);
        $this->getDbUsers()->delete((string) $conn->resourceId);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    /**
     * Gets the value of dbUsers.
     *
     * @return mixed
     */
    public function getDbUsers()
    {
        return $this->dbUsers;
    }

    /**
     * Sets the value of dbUsers.
     *
     * @param mixed $dbUsers the db users
     *
     * @return self
     */
    public function setDbUsers($dbUsers)
    {
        $this->dbUsers = $dbUsers;

        return $this;
    }
}