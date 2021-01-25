<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_message')->only('create');
        $this->middleware('permission:read_message')->only(['index', 'show']);
        $this->middleware('permission:update_message')->only('edit');
    }

    public function index()
    {
        $messages = Contact::query()->orderBy('created_at', 'desc');
        if(request()->keywords != null)
        {
              $messages = $messages->search(request()->keywords, null, true);
        }
        if(request()->status != null)
        {
            $messages = $messages->where('status', request()->status);
        }
        $paginate = (isset(request()->paginate) && request()->paginate != null) ? request()->paginate : '10';
        $messages = $messages->paginate($paginate);
        return view('backend.messages.index',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $message)
    {
        $message->update(['status' => 1]);
        return view('backend.messages.view', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'the message has been deleted');
    }
}
