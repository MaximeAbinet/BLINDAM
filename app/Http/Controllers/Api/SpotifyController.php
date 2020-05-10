<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Track;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpotifyController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $query = str_replace(' ', '+', $request->q);

        $url = 'https://api.deezer.com/search/track?q=' . $query;

        try {
            $json = json_decode(file_get_contents($url, false), true);
        }
        catch (Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($json);

    }

    public function addPlaylist(Request $request)
    {

        $url = 'https://api.spotify.com/v1/playlists/'. $request->q . '/tracks';

        try {
            $json = json_decode(file_get_contents($url), true);
        }
        catch (Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($json);

    }

    public function storePlaylist(Request $request)
    {


        try {

            $tracks = [];



            foreach ($request->tracks as $track) {

                if($track['preview']) {

                    $item = new Track([
                        'user_id' => Auth::user()->id,
                        'game_id' => $request->params['game_id'],
                        'provider_item_id' => $track['id'],
                        'provider' => 'deezer',
                        'artist_name' => $track['artist']['name'],
                        'track_name' => $track['title_short'],
                        'artwork_url' => $track['album']['cover_medium'],
                        'preview_url' => $track['preview'],
                    ]);


                    $item->save();

                    $tracks[] = $item;

                }

            }

            return response()->json($tracks);

        }
        catch (Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($json);

    }

}