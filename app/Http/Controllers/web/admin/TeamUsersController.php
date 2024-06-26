<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeamUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::with('userTeam')
            ->where('is_admin', '0')->where('is_admin' ,'!=' , true)
            ->get();
        return view('admin.users.index', ['users' => $user, 'teams' => Team::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $email = User::where('email',$request->email)->orWhere('name',$request->name)->first();
            if ($email) {
                return redirect()
                ->route('team-users.index' , app()->getLocale())

                ->with('failed', 'Request Failed ! Email or Username is already in use');
            }
            if ($request->user_type == 'TeamLead') {
                $request['ba'] = '';
                $request['zone'] = '';
            }elseif (empty($request->user_type) ) {
                $request['user_type'] = '';
            }

            $team_name = Team::find($request->id_team);
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'id_team'   => $request->id_team,
                'password'  => Hash::make($request->password),
                'is_admin'  => false,
                'zone'      => $request->zone,
                'ba'        => $request->ba,
                'user_type' => $request->user_type,
                'team_name' => $team_name->team_name,
            ]);
            return redirect()
                ->route('team-users.index' , app()->getLocale())
                ->with('success', 'User Added');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()
                    ->route('team-users.index' , app()->getLocale())
                    ->with('failed', 'Request Failed');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang ,$id)
    {
        try {
            User::find($id)->delete();
            return redirect()
            ->route('team-users.index' , app()->getLocale())

                ->with('success', 'User Removed');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()
            ->route('team-users.index' , app()->getLocale())

                ->with('failed', 'Request Failed');
        }
    }
}
