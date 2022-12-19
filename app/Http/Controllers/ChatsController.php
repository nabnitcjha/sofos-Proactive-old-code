<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Guardian;
use App\Events\ChatEvent;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\Parent_students;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{


     /**
      * * @OA\Get(
 *     path="/api/messages",
 *     tags={"Chat"},
     *   summary="Get messages",
     *   operationId="messages",
     *security={{ "apiAuth": {} }},

     *
 *     @OA\Response(
     *      response=201,
     *       description="Success",
     *
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
 * )
**/
     /**
     * @OA\Post(
     ** path="/api/messages",
     *   tags={"Chat"},
     *   summary="send messages",
     *   operationId="messages",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="message",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *  @OA\Parameter(
     *      name="friendId",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

       /**
     * @OA\Post(
     ** path="/api/getPrivateMessage",
     *   tags={"Chat"},
     *   summary="Get Private message",
     *   operationId="getPrivateMessage",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="friendId",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/


       /**
     * @OA\Post(
     ** path="/api/getRealTimePrivateMessage",
     *   tags={"Chat"},
     *   summary="Get Real Time Private Message",
     *   operationId="getRealTimePrivateMessage",
     *security={{ "apiAuth": {} }},
     
     *  @OA\Parameter(
     *      name="friendId",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * Chat api
     *
     * @return \Illuminate\Http\Response
     */
    //



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'success';
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        
        $user = User::find(auth()->user()->id);
        // $user = Auth::user();
        // $user = user::find($request->myId);
        if ($request->mode==='teacher-student') {
            $parentIds = Parent_students::where('student_id',$request->friendId)->groupBy('parent_id')->pluck('parent_id');
            $parents = Guardian::whereIn('id',$parentIds)->get();
            foreach ($parents as $key => $value) {
                $message = new Message();
                $message->user_id = $user->id;
                $message->message = $request->message;
                $message->friend_id = $value->user_id;
                $message->my_id = $user->id;
                $message->save();
            }
        }
        $message = new Message();
        $message->user_id = $user->id;
        $message->message = $request->message;
        $message->friend_id = $request->friendId;
        $message->my_id = $user->id;
        $message->save();

        // broadcast(new MessageSent($user, $message))->toOthers();
        event(new ChatEvent($request->friendId, $user->id));

        $parentId = Parent_students::where('student_id', $request->friendId)->first();
        if ($parentId) {
            # code...
            // $parent = DB::table('parent_students')
            //     ->join('students', 'parent_students.student_id', '=', 'students.id')
            //     ->join('messages', 'parent_students.student_id', '=', 'messages.friend_id')
            //     ->join('parents', 'parent_students.parent_id', '=', 'parents.id')
            //     ->orderBy('messages.id', 'desc')
            //     ->where('parent_students.student_id', $request->friendId)
            //     ->select('parents.*', 'messages.message')
            //     ->get()->take(1);

            // $parent = Guardian::find($parentId->parent_id);
            // $parent->message = $request->message;
            // $parent->save();
            // dispatch(new \App\Jobs\SendEmailTest($parent));
        }

        // $parent = Guardian::find(3);
        // dispatch(new \App\Jobs\SendEmailTest($parent));
        return ['status' => 'Message Sent!'];
    }

    public function getPrivateMessage(Request $request)
    {
        // $myId =  Auth::user();
        // $myId = user::find($request->myId);
        $myId = User::find(auth()->user()->id);
        $currentUserID = $myId->id;
        $friendId = $request->friendId;
        $privateMessage = Message::where([
            ['my_id', '=', $myId->id],
            ['friend_id', '=', $friendId],
        ])->orWhere([
            ['my_id', '=', $friendId],
            ['friend_id', '=', $myId->id],
        ])->with('user')->get();
        return response()->json(compact('privateMessage', 'currentUserID'));
    }

    public function getRealTimePrivateMessage(Request $request)
    {
        $myId =  $request->my_ID;
        $currentUserID = $myId;
        $friendId = $request->friendId;
        $privateMessage = Message::where([
            ['my_id', '=', $myId],
            ['friend_id', '=', $friendId],
        ])->orWhere([
            ['my_id', '=', $friendId],
            ['friend_id', '=', $myId],
        ])->with('user')->get();
        return response()->json(compact('privateMessage', 'currentUserID'));
    }
}
