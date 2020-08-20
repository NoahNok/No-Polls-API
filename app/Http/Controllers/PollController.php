<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{

    public function get($id, Request $request){
        $poll = DB::table('polls')->where('id', $id)->first();
        $options = DB::table('poll_votes')->select('id','name')->where('poll_id', $id)->get();

        $voted = DB::table('poll_vote_ips')->where('ip', $_SERVER['HTTP_CF_CONNECTING_IP'])->where('voted_poll', $id)->exists();


        $data = array();
        $data['poll'] = $poll;
        $data['options'] = $options;
        $data['hasVoted'] = $voted;

        return response()->json($data);

    }

    public function create(Request $request){
        $name = strip_tags($request->input("name"));
        $options = $request->input("options");

        $pollId = $this->quickRandom(10);

        DB::table('polls')->insert(
            ['id' => $pollId, 'name' => $name]
        );

        foreach ($options as $option){
            $optionId = $this->quickRandom(10);
            $name = $option['name'];
            DB::table('poll_votes')->insert(
                ['id' => $optionId, 'name' => $name, 'votes' => 0, 'poll_id' => $pollId]
            );
        }

        $data = array();
        $data['pollId'] = $pollId;

        return response()->json($data);



    }

    public function results($id){
        $results = DB::table('poll_votes')->where('poll_id', $id)->get();
        return response()->json($results);

    }

    public function vote(Request $request){
        $pollId = $request->input('pollId');
        $voteId = $request->input('voteId');

        $voted = DB::table('poll_vote_ips')->where('ip', $_SERVER['HTTP_CF_CONNECTING_IP'])->where('voted_poll', $pollId)->exists();
        if ($voted){
            return response("You have already voted on this poll!", 403);
        }

        DB::table('poll_votes')->where('poll_votes.id', '=', $voteId)->increment('votes', 1);
        DB::table('poll_vote_ips')->insert([
           ['ip' => $_SERVER['HTTP_CF_CONNECTING_IP'], 'voted_poll' => $pollId]
        ]);

        return response('');

    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int  $length
     * @return string
     */
    public function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

}
