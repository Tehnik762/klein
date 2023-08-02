<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PersonalController extends Controller
{


    public function show()
    {
        $user = Auth::user();
        return view('profil.show', compact('user'));
    }

  
    public function edit()
    {
        
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

  
    public function update(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'oldpass' => 'nullable|string|current_password',
            'newpass' => 'nullable|string|exclude_without:oldpass|same:newpass2',
            'newpass2' => 'nullable|string|exclude_without:newpass|same:newpass',
            'phone' => 'nullable|string',
        ]);

       

        /** @var User $user */
        $user = Auth::user();
        $oldPhone = $user->phone;
        $user->update($request->only('name', 'lastname', 'phone'));
        if ($user->phone != $oldPhone) {
            $user->unverifyPhone();
        }
        
        if (isset($validated['newpass']) AND $validated['newpass'] === $validated['newpass2']) {
           
            $user->update([
                'password' => Hash::make($validated['newpass'])
            ]);

        }

        return redirect()->route('profil.personal');



    }

   
}
