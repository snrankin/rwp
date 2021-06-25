<?php

namespace RWP\Vendor\Illuminate\Contracts\Bus;

interface QueueingDispatcher extends Dispatcher
{
    /**
     * Attempt to find the batch with the given ID.
     *
     * @param  string  $batchId
     * @return Batch|null
     */
    public function findBatch(string $batchId);
    /**
     * Create a new batch of queueable jobs.
     *
     * @param  Collection|array  $jobs
     * @return PendingBatch
     */
    public function batch($jobs);
    /**
     * Dispatch a command to its appropriate handler behind a queue.
     *
     * @param  mixed  $command
     * @return mixed
     */
    public function dispatchToQueue($command);
}
