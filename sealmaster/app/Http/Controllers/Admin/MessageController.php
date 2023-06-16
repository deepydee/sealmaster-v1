<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function show(Callback $callback): View
    {
        return view('messages.show', compact('callback'));
    }

    public function destroy(Callback $callback): RedirectResponse
    {
        $callback->delete();

        return redirect()->route('admin.messages.index')
            ->with('message', 'Сообщение успешно удалено');
    }
}
