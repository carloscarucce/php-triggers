<?php

namespace PhpTriggers;

class EventsManager
{
    /**
     * @var EventsManager[]
     */
    private static $managers = [];

    /**
     * @var string
     */
    private static $lastIndex = null;

    /**
     * @var EventListener[]
     */
    private $listeners = [];

    /**
     * Retrieves the last called manager.
     *
     * @return EventsManager
     */
    public static function current()
    {
        return self::get(self::$lastIndex);
    }

    /**
     * Retrieve an EventsManager instance.
     *
     * @param string|null $managerIndex
     * @return EventsManager
     */
    public static function get($managerIndex = null)
    {
        if ($managerIndex === null) {
            $managerIndex = 'default';
        }

        if (!isset(self::$managers[$managerIndex])) {
            self::$managers[$managerIndex] = new static();
        }

        self::$lastIndex = $managerIndex;
        return self::$managers[$managerIndex];
    }

    /**
     * Adds a new listener to the queue.
     *
     * @param EventListener $listener
     */
    public function addListener(EventListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * Invoke event listeners queue.
     *
     * @param Event $event
     */
    public function triggerEvent(Event $event)
    {
        foreach ($this->listeners as $listener) {
            if (!$listener->willListenTo($event)) {
                continue;
            }

            $listener->listen($event, ...array_values($event->getData()));

            if ($event->isStopped()) {
                break;
            }
        }
    }
}
