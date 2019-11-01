<?php

namespace PhpTriggers;

class Event
{
    const RESULTS_STORE = true;
    const RESULTS_IGNORE = false;

    /**
     * @var bool
     */
    private $cancelled = false;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $results = [];

    /**
     * @var bool
     */
    private $stoppedPropagation = false;

    /**
     * @var bool
     */
    private $storeResults = false;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     * @param array  $data
     * @param bool   $storeResults
     *
     * @return Event
     */
    public static function create($type, array $data, $storeResults = self::RESULTS_IGNORE)
    {
        return new static($type, $data, $storeResults);
    }

    /**
     * Stops execution (must be respected by the event 'invoker')
     */
    public function cancel()
    {
        $this->cancelled = true;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return bool
     */
    public function getStoreResults()
    {
        return $this->storeResults;
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
    public function hasStoppedPropagation()
    {
        return $this->stoppedPropagation;
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->cancelled;
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
    public function stopPropagation()
    {
        $this->stoppedPropagation = true;
    }

    /**
     * @param mixed $result
     */
    public function storeResult($result)
    {
        if (!$this->storeResults) {
            return;
        }

        $this->results[] = $result;
    }

    /**
     * Triggers current event.
     *
     * @return array|null
     */
    public function trigger()
    {
        EventsManager::current()->triggerEvent($this);

        return $this->storeResults ? $this->getResults() : null;
    }

    /**
     * Event constructor.
     *
     * @param string $type
     * @param array  $data
     * @param bool   $storeResults
     */
    public function __construct($type, array $data, $storeResults)
    {
        $this->setType($type);
        $this->setData($data);
        $this->storeResults = $storeResults;
    }
}
