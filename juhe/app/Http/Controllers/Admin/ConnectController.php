<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

class ConnectController extends Controller
{
    public function index()
    {
        return view('admin.connect', [
            'contact' => Contact::find(1),
        ]);
    }

    public function update(ContactRequest $request)
    {
        Contact::find(1)->update($request->only('image', 'phone', 'time', 'content'));
        return back()->with('success', '修改成功');
    }
}
