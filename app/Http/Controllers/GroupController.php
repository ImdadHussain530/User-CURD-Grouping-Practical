<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:250',
                'regex:/(^([a-zA-z ]+)?$)/u',
                Rule::unique('groups', 'name')
            ],
            
        ]);

        $selectedUser=$request->input('userselect',[]);
       $group=new Group();
         $group->name=$data['name'];
         $group->save();
        
        if (isset($group->id)) {
            $group->users()->attach($selectedUser);
            return redirect()->route('users.index')->with(['success' => 'Group Added Successully.']);
        } else {
            return redirect()->back()->with(['error' => 'Group Not Created.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group=Group::with('users')->find($id);
        $users=User::all();
        return view('group.edit',compact('group','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $selectedUsers=$request->input('userselect',[]);
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:250',
                'regex:/(^([a-zA-z ]+)?$)/u',
                Rule::unique('groups', 'name')->ignore($id)
            ],
            
        ]);
        $group=Group::find($id);
        // dd($data['name']);
        $group->name=$data['name'];

        $group->users()->sync($selectedUsers);
        $group->update();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group=Group::find($id);
        $group->users()->detach();
        $group->delete();
        return redirect()->route('users.index');
    }
}
