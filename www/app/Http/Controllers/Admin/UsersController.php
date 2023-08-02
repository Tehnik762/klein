<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UsersController extends Controller
{
    public $statuses, $roles;
    public function __construct()
    {

        $this->statuses = [
            User::STATUS_ACTIVE => __('admin.active'),
            User::STATUS_WAIT => __('admin.wait'),
        ];
        $this->roles = User::rolesList();
    }


    public function index(Request $request)
    {

        $roles = $this->roles;
        $statuses = $this->statuses;

        $query = User::orderBy('id','desc');

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', "%".$value."%");
        } 

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', "%".$value."%");
        } 

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        } 

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        } 

        $users = $query->paginate(20);
        $users_active = TRUE;
       return view('admin.users',compact('users', 'statuses', 'roles', 'users_active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {

        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );
        

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $users_active = TRUE;

        return view('admin.users.show', compact('user', 'users_active'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $statuses = $this->statuses;
        $roles = $this->roles;
        $users_active = TRUE;
        return view('admin.users.edit', compact('user', 'statuses', 'roles', 'users_active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->toArray());

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', __('admin.userDelete'));
    }

    public function activate($id) {
        $user = User::where('id', $id)->first();
        // TODO redirect back!!!
        if (empty($user)) {
            return redirect()->route('users.show', $user->id)->with('error', __('auth.VerifyError'));
        } 
        
        $user->makeVerified();

        return redirect()->route('users.show', $user->id)->with('success', __('auth.AdminVerify'));

    }
}
