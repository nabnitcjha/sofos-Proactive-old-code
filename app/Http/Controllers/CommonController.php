<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    //
      /**
      * * @OA\Get(
 *     path="/api/getEmail",
 *     tags={"Auth"},
     *   summary="Get Email",
     *   operationId="getEmail",
     * security={{ "apiAuth": {} }},
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
 *
 *
 *
     * @OA\Post(
     ** path="/api/register",
     *   tags={"Auth"},
     *   summary="register",
     *   operationId="register",
     *security={{ "apiAuth": {} }},
     
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     * @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     * Common api
     *
     * @return \Illuminate\Http\Response
     */
    //
    public function register(Request $request)
    {
            $user = new User();
            $user->password = bcrypt($request->password);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return response()->json(compact('user'));
    }

    public function getEmail(){
        return auth()->user();
    }
}
