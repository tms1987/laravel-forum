<?php

namespace TeamTeaTime\Forum\Http\Requests\Bulk;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use TeamTeaTime\Forum\Actions\Bulk\LockThreads as Action;
use TeamTeaTime\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use TeamTeaTime\Forum\Interfaces\FulfillableRequest;
use TeamTeaTime\Forum\Models\Thread;
use TeamTeaTime\Forum\Models\Category;
use TeamTeaTime\Forum\Events\UserBulkLockedThreads;

class LockThreads extends FormRequest implements FulfillableRequest
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
        $categories = $this->categories();
        foreach ($categories as $category)
        {
            if (! $this->user()->can('lockThreads', $category)) return false;
        }

        return true;
    }

    public function fulfill()
    {
        $action = new Action($this->validated()['threads'], $this->user()->can('viewTrashedThreads'));
        $threads = $action->execute();

        if (! is_null($threads))
        {
            event(new UserBulkLockedThreads($this->user(), $threads));
        }

        return $threads;
    }

    protected function categories(): Collection
    {
        $query = Thread::whereIn('id', $this->validated()['threads']);

        if ($this->user()->can('viewTrashedThreads'))
        {
            $query = $query->withTrashed();
        }

        $categoryIds = $query->select('category_id')->distinct()->pluck('category_id');

        return Category::whereIn('id', $categoryIds)->get();
    }
}
