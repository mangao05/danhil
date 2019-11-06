<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserRole;
use App\UserDetails;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('user_details.position')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->userRole;
        $this->validate($request,[
            'lastname' => 'required',
            'firstname' => 'required',
            'address' => 'required',
            'position_id' => 'required'
        ]);

        $request['password'] = Hash::make("danhil2019");
        $user = User::create($request->only(['lastname','firstname','email','password']));
        $user->user_details()->create([
            'address' => $request->address,
            'position_id' => $request->position_id
        ]);

        foreach($request->userRole as $role){
            $user->user_role()->create([
                'role_id' => $role
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('user_details','user_role')->find($id);
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
        User::find($id)->update($request->all());
        UserDetails::where('user_id',$id)->update([
            "address" => $request->address,
            "position_id" => $request->position_id
        ]);
        UserRole::where('user_id',$id)->delete();
        foreach($request->userRole as $role){
            UserRole::create([
                'user_id' => $id,
                'role_id' => $role
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function user_details(Request $request){
        return $request->all();
    }
}
