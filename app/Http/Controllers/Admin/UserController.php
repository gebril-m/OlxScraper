<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('roles')->get();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules=[
            "name"=>'required|min:3',
            "email"=>'required|email|unique:users,email',
            "password"=>'required|confirmed',
            "image"=>v_image(),
        ];
        $request->validate($rules);

        $data=$request->except(['password','image','role','_token']);
        $data['password']=bcrypt($request->password);

        if ($request->hasFile('image')) {

            $data['image']=image_upload($request->image,'users');

        }
        $user=User::create($data);
        $user->syncRoles([$request->role]);

        session()->flash('success','User Created Successfully');
        return redirect(url('/users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles=Role::all();
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules=[
            "name"=>'required|min:3',
            "email"=>'required|email|unique:users,email,'.$id,
            "password"=>'confirmed',
            "image"=>v_image(),
        ];
        $request->validate($rules);

        $data=$request->except(['password','image','role','_token']);
        if (isset($request->password)) {
            $data['password']=bcrypt($request->password);
        }

        if ($request->hasFile('image')) {

            $data['image']=image_upload($request->image,'users');

        }
        $user=User::find($id);
        $user->update($data);
        $user->syncRoles([$request->role]);
        if (auth()->user()) {
            session()->flash('success','Profile Updated Successfully');
            return back();
        }
        session()->flash('success','User Updated Successfully');
        return redirect(url('/users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->delete();
        session()->flash('success','User Deleted Successfully');
        return back();
    }

    // Edit Profile
    public function edit_profile()
    {
        return view('admin.users.editProfile');
    }
}
