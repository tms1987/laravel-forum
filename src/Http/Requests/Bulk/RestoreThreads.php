<?php

namespace TeamTeaTime\Forum\Http\Requests\Bulk;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use TeamTeaTime\Forum\Actions\Bulk\RestoreThreads as Action;
use TeamTeaTime\Forum\Events\UserBulkRestoredThreads;
use TeamTeaTime\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use TeamTeaTime\Forum\Interfaces\FulfillableRequest;
use TeamTeaTime\Forum\Models\Thread;
use TeamTeaTime\Forum\Support\Stats;

class RestoreThreads extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation;

    public function rules(): array
    {
        return [
            'threads' => ['required', 'array']
        ];
    }

    public function authorizeValidated(): bool
    {
        if (! $this->user()->can('viewTrashedThreads')) return false;

        $threads = Thread::whereIn('id', $this->validated()['threads'])->get();
        foreach ($threads as $thread)
        {
            if (! $this->user()->can('restore', $thread)) return false;
        }

        return true;
    }

    public function fulfill()
    {
        $action = new Action($this->validated()['threads']);
        $threads = $action->execute();

        if (! is_null($threads))
        {
            event(new UserBulkRestoredThreads($this->user(), $threads));
        }

        return $threads;
    }
}
