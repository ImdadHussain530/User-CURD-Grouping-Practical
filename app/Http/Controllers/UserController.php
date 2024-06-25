<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::with('groups')->get();
        $groups = Group::get();

        // $usersingroup=User::leftJoin('groups','users.id','=','groups.id');

        return view('user.index', compact('users', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('user.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->validate([
            'name' => 'required|string|max:255|unique:users,name|regex:/(^([a-zA-z ]+)?$)/u',
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'age' => 'required|integer|min:1|max:120',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'proof' => 'required',
            'proof*' => 'mimes:jpg,png,jpeg,pdf|max:2048'
        ]);

        if (count($request->file('proof')) > 5) {
            return back()->withErrors(['error' => 'You can upload a maximum of 5 files.']);
        }



        $proofs = $request->file('proof');
        $proofarr = [];

        foreach ($proofs as $file) {
            $name = 'proof';
            $uniqueName = $name . '_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();

            $url = $file->storeAs('proof', $uniqueName, ['disk' => 'public']);
            $proofarr[] = $uniqueName;
        }

        $newuser = new User();
        $newuser->name = $user['name'];
        $newuser->phone = $user['phone'];
        $newuser->dob = $user['dob'];
        $newuser->age = $user['age'];
        $newuser->address = $user['address'];
        $newuser->country = $user['country'];
        $newuser->state = $user['state'];
        $newuser->city = $user['city'];
        $newuser->proofs = json_encode($proofarr);
        $created = $newuser->save();
        if ($created) {
            return redirect()->route('users.index')->with(['success' => 'User Added Successully.']);
        } else {
            return redirect()->back()->with(['error' => 'User Not Added.']);
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
        $user = User::find($id);
        $countries = Country::all();
        return view('user.edit', compact('user', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/(^([a-zA-z ]+)?$)/u',
                Rule::unique('users')->ignore($id),
            ],
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'age' => 'required|integer|min:1|max:120',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'proof.*' => 'nullable|mimes:jpg,png,jpeg,pdf|max:2048',
            'replace_proof.*' => 'nullable|mimes:jpg,png,jpeg,pdf|max:2048'
        ]);




        $proofs = json_decode($user->proofs, true) ?? [];

        // Delete old proofs if new proofs are uploaded
        if ($request->hasFile('proof')) {
            // Delete old proofs
            foreach ($proofs as $proof) {
                Storage::disk('public')->delete('proof/' . $proof);
            }
            // Reset the proofs array
            $proofs = [];
        }

        if ($request->hasFile('proof')) {
         
            $newProofs = $request->file('proof');
            foreach ($newProofs as $file) {
                $uniqueName = 'proof_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('proof', $uniqueName, ['disk' => 'public']);
                $proofs[] = $uniqueName;
            }
        }

        if ($request->hasFile('replace_proof')) {
            $replaceProofs = $request->file('replace_proof');
            foreach ($replaceProofs as $index => $file) {
                if (isset($proofs[$index])) {
                    // Delete the old file
                    Storage::disk('public')->delete('proof/' . $proofs[$index]);

                    // Store the new file
                    $uniqueName = 'proof_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('proof', $uniqueName, ['disk' => 'public']);

                    // Replace the old proof with the new one
                    $proofs[$index] = $uniqueName;
                }
            }
        }
        
        $user->proofs = json_encode($proofs);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->age = $request->age;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;

        $updated = $user->update();

        if ($updated) {
            return redirect()->route('users.index')->with(['success' => 'User Updated Successully.']);
        } else {
            return redirect()->back()->with(['error' => 'User not update.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::find($id);
        $user->groups()->detach();
        $deleted = $user->delete();
        
        $proofs = json_decode($user->proofs, true) ?? [];
        
            // Delete proofs
            foreach ($proofs as $proof) {
                Storage::disk('public')->delete('proof/' . $proof);
            }
            

        if ($deleted) {
            return redirect()->route('users.index')->with(['success' => 'User deleted Successully.']);
        } else {
            return redirect()->back()->with(['error' => 'User not delete.']);
        }
    }
}
