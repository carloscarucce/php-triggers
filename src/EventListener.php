<?php

namespace PhpTriggers;

abstract class EventListener
{
    /**
     * @var array
     */
    private $eventTypes = [];

    /**
     * Action to be executed when the event is triggered.
     *
     * @param Event $event
     * @param mixed ...$data
     *
     * @return mixed
     */
    abstract public function listen(Event $event, ...$data);

    /**
     * This listener will respond to every event.
     */
    final public function listensEverything()
    {
        $this->eventTypes = '*';
    }

    /**
     * Determines what types of events this will listen to.
     *
     * @param string|string[] $type
     */
    public function listensTo($type)
    {
        $this->eventTypes = (array) $type;
    }

    /**
     * Informs if the current listener can listen to $event.
     *
     * @param Event $event
     *
     * @return bool
     */
    final public function willListenTo(Event $event)
    {
        if ($this->eventTypes === '*') {
            return true;
        }

        return in_array($event->getType(), $this->eventTypes);
    }

    /**
     * Adds listener to the current listener.
     */
    public function register()
    {
        EventsManager::current()->addListener($this);
    }
}
