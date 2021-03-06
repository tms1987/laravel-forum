<?php

namespace TeamTeaTime\Forum\Http\Controllers\Web\Bulk;

use Illuminate\Http\RedirectResponse;
use TeamTeaTime\Forum\Http\Controllers\Web\BaseController;
use TeamTeaTime\Forum\Http\Requests\Bulk\DeleteThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\MoveThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\LockThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\PinThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\UnlockThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\UnpinThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\RenameThreads;
use TeamTeaTime\Forum\Http\Requests\Bulk\RestoreThreads;

class ThreadController extends BaseController
{
    public function move(MoveThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function lock(LockThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function unlock(UnlockThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function pin(PinThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function unpin(UnpinThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function destroy(DeleteThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.deleted');
    }

    public function restore(RestoreThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if (is_null($result)) return $this->invalidSelectionResponse();

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }
}
