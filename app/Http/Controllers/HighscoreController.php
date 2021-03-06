<?php

namespace App\Http\Controllers;

use App\Models\Highscore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HighscoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $mapId)
    {
        //get top ten

        $scores =
            DB::table('highscores')
                ->join('users', 'highscores.user_id', '=', 'users.id')
                ->select('highscores.*', 'users.name')
                ->where('highscores.map_id', $mapId)
                ->orderBy('highscores.score', 'DESC')
                ->take(10)
                ->get();


        return response(['highscores' => $scores], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Highscore::create([
            'user_id' => $request->user()->id,
            'score' => $request->get('score'),
            'map_id' => $request->get('map'),
        ]);
        return response(["message"=> "success"], 201 );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Highscore  $highscore
     * @return \Illuminate\Http\Response
     */
    public function show(Highscore $highscore)
    {
        //
    }


    /**
     * Respond with the specified highscores.
     *
     * @param Request $request
     * @param int $mapId
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, int $mapId)
    {
        $userId = $request->user()->id;
        $highscores = DB::table('highscores')
            ->select("score", "created_at")
            ->where('user_id', $userId)
            ->where('map_id', $mapId)
            ->orderBy('score', 'DESC')
            ->get();
        return response($highscores, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Highscore  $highscore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Highscore $highscore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Highscore  $highscore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Highscore $highscore)
    {
        //
    }
}
