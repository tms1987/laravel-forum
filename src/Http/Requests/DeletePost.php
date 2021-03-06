<?php

namespace TeamTeaTime\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use TeamTeaTime\Forum\Actions\DeletePost as Action;
use TeamTeaTime\Forum\Events\UserDeletedPost;
use TeamTeaTime\Forum\Http\Requests\Traits\HandlesDeletion;
use TeamTeaTime\Forum\Interfaces\FulfillableRequest;
use TeamTeaTime\Forum\Models\Post;

class DeletePost extends FormRequest implements FulfillableRequest
{
    use HandlesDeletion;

    public function authorize(): bool
    {
        $post = $this->route('post');
        return $post->sequence != 1 && $this->user()->can('delete', $post);
    }

    public function rules(): array
    {
        return [
            'permadelete' => ['boolean']
        ];
    }

    public function fulfill()
    {
        $post = $this->route('post');

        $action = new Action($post, $this->isPermaDeleting());
        $post = $action->execute();

        if (! is_null($post))
        {
            event(new UserDeletedPost($this->user(), $post));
        }

        return $post;
    }
}
