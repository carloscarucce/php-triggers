<?php

namespace PhpTriggers;

class Event
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var bool
     */
    private $stopped = false;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     * @param array $data
     *
     * @return Event
     */
    public static function create($type, array $data)
    {
        return new static($type, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Informs if the current event is stopped
     * @return bool
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Prevent next executions
     */
    public function stop()
    {
        $this->stopped = true;
    }

    /**
     * Triggers current event.
     */
    public function trigger()
    {
        EventsManager::current()->triggerEvent($this);
    }

    /**
     * Event constructor.
     *
     * @param string $type
     * @param array $data
     */
    public function __construct($type, array $data)
    {
        $this->setType($type);
        $this->setData($data);
    }
}
