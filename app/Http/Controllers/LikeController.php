<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Likes;
class LikeController extends Controller
{
    //
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function setLike(Request $request){

        $validateData = $request->validate([
           'user_id'=>'required',
           'penemu_id'=>'required',
        ]);

        $like = Likes::where('user_id',$request->user_id)->where('penemu_id',$request->penemu_id)->first();

        if(!$like){
            Likes::create([
                'user_id'=>$request->user_id,
                'penemu_id'=>$request->penemu_id,
            ]);
            return response()->json(['message'=>'ok'],201);
        }else{
            $like->delete();
            return response()->json(['message'=>'ok'],201);
        }

    }
}