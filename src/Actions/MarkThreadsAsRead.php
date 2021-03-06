<?php

namespace TeamTeaTime\Forum\Actions;

use Illuminate\Foundation\Auth\User;
use TeamTeaTime\Database\Eloquent\Model;
use TeamTeaTime\Forum\Models\Category;
use TeamTeaTime\Forum\Models\Thread;

class MarkThreadsAsRead extends BaseAction
{
    private User $user;
    private ?Category $category;

    public function __construct(User $user, ?Category $category)
    {
        $this->user = $user;
        $this->category = $category;
    }

    protected function transact()
    {
        $threads = Thread::recent();

        if (! is_null($this->category))
        {
            $threads = $threads->where('category_id', $this->category->id);
        }

        $threads = $threads->get()->filter(function ($thread)
        {
            // @TODO: handle authorization check outside of action?
            return $thread->userReadStatus != null
                && (! $thread->category->is_private || $this->user->can('view', $thread->category));
        });

        foreach ($threads as $thread)
        {
            $thread->markAsRead($this->user->getKey());
        }

        return $threads;
    }
}