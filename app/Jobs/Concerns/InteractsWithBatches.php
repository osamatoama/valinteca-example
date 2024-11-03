<?php

namespace App\Jobs\Concerns;

use App\Enums\BatchName;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;

trait InteractsWithBatches
{
    use Batchable;

    /**
     * @param  ShouldQueue|ShouldQueue[]  $jobs
     */
    protected function addOrCreateBatch(ShouldQueue|array $jobs, BatchName $name): void
    {
        if ($this->batchId !== null) {
            $this->batch()->add(jobs: $jobs);
        } else {
            Bus::batch(
                jobs: $jobs
            )->name(
                name: $name->value,
            )->dispatch();
        }
    }
}
