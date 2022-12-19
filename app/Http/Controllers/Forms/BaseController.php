<?php

namespace App\Http\Controllers\Forms;

use Carbon\Carbon;
use App\Models\UploadFiles;
use Illuminate\Http\Request;
use App\Models\UploadFileGroups;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

    /**
     * @SWG\Get(
     *   path="/api/testing/{mytest}",
     *   summary="Get Testing",
     *   operationId="testing",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="mytest",
     *          in="path",
     *          required=true,
     *          type="string"
     *      ),
     * )
     *
     */

/**
 * @OA\Info(title="ProActive API - Laravel 8", version="0.1")
 */

class BaseController extends Controller
{
    //

    public $model_name;
    public $Model;

    public function __construct()
    {
        if (!class_exists($this->model_name)) {
            throw new \Exception('An unexpected error occurred. Please contact customer support. E1002');
        }
        $this->Model = new $this->model_name;
        $this->Query = $this->Model::select("*");
    }



    /**
     * Return Error
     */
    public function getError($message, $result = null)
    {
        return array(
            "status"  => "ng",
            "message" => $message,
            "result"  => $result
        );
    }

    public function getModel()
    {
        return $this->Model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        if ($request->allowPagination!=null) {
            if(str_contains($request->allowPagination, 'false')){
                $obj = $this->Query->get();
            }
        }
        else{
            $obj = $this->Query->paginate(5); 
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $obj
        );
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

        $params = $request->input();
        $Model = $this->getModel();

        if ($request->full_name) {
            $user = new User();
            $user->name = $request->full_name;
            $user->email = $request->email;
            $user->password = 'password';
            $user->save();
            $Model->user_id = $user->id;
        }


        foreach ($params as $key => $value) {
            $Model->$key = $value;
        }

        if (!$Model->save()) {
            return $this->getError("Faild store");
        }
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $Model
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Model = $this->getModel();
        $Obj = $Model::where('id',$id)->get();
        if (!$Obj) {
            return $this->getError("Can not find {$id}");
        }
        foreach ($Obj as $key => $value) {
            # code...
            if ($value->user_image) {
                $value->teacherImage = $this->getFile($value->user_image);
            }else{
                $value->teacherImage = null;
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $Obj
        );
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

        $params = $request->input();

        $Model = $this->getModel();
        $Model = $Model::find($id);
        if (!$Model) {
            return $this->getError("Can not find {$id}");
        }
        foreach ($params as $key => $value) {
            if ($key == 'password') {
                $user = User::find($Model->user_id);
                $user->password = bcrypt($value);
                $user->save();
            } else {
                $Model->$key = $value;
            }
        }
        if (!$Model->save()) {
            return $this->getError("Faild update {$id}");
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $Model
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Model = $this->getModel();
        $Obj = $Model::find($id);
        if (!$Obj) {
            return $this->getError("Can not find {$id}");
        }
        if (!$Obj->delete()) {
            return $this->getError("Faild delete {$id}");
        }
        $user = User::where('email', $Obj->email);
        $user->delete();
        return array(
            "status"  => "ok",
            "message" => "delete successfully",
            "result"  => $Obj
        );
    }

    function manageUploads($file, $savepath, $gid = "")
    {
        if ($gid == "" || $gid == null || $gid == 0) {
            $maxGroupid = UploadFileGroups::max('file_group_id');
            $file_group_id = $maxGroupid + 1;
        } else {
            $file_group_id = $gid;
        }
        $savepathgid = $savepath . '/' . $file_group_id;
        $original_filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        //        $size = $file->getClientSize();
        $name = rand(1111111, 9999999) . '.' . $extension;
        Storage::putFileAs($savepathgid, $file, $name);
        $uploadData['filename'] = $name;
        $uploadData['original_filename'] = $original_filename;
        $uploadData['filebasepath'] = $savepath;
        $uploadData['filepath'] = $savepathgid;
        $uploadData['upload_type'] = $extension;
        $uploadData['upload_size'] = '0';
        if ($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif" || $extension == "JPG" || $extension == "JPEG" || $extension == "PNG" || $extension == "GIF") {
            $uploadData['meme_type'] = "image";
        } else if ($extension == "mp4" || $extension == "webm") {
            $uploadData['meme_type'] = "video";
        } else {
            $uploadData['meme_type'] = "doc";
        }
        $upload = UploadFiles::create($uploadData);
        if ($upload) {
            if ($gid == "" || $gid == null) {
                $maxGroupid = UploadFileGroups::max('file_group_id');
                $gid = $maxGroupid + 1;
                $uploadgroupData['file_group_id'] = $gid;
                $uploadgroupData['file_id'] = $upload->id;
                $uploadgroups = UploadFileGroups::create($uploadgroupData);
            } else {
                $uploadgroupData['file_group_id'] = $file_group_id;
                $uploadgroupData['file_id'] = $upload->id;
                $uploadgroups = UploadFileGroups::create($uploadgroupData);
            }
        }
        if ($uploadgroups) {
            return $uploadgroups->file_id;
        }
    }
    function displayFile($file_id)
    {
        $upload = UploadFiles::where('id', $file_id)->first();
        if (!$upload) {
            return response("Null Media File", 403);
        }

        $filePath = $upload->filepath . "/" . $upload->filename;

        if (!Storage::exists($filePath)) {
            if ($upload->meme_type == 'doc') {
                return abort(404);
            } else {
                return response('File Not Found', 403);
            }
        }

        if ($upload->upload_type == "jpg") {
            $type = 'image/jpeg';
        } else if ($upload->upload_type == "gif") {
            $type = 'image/gif';
        } else if ($upload->upload_type == "png") {
            $type = 'image/png';
        } else if ($upload->upload_type == "PNG") {
            $type = 'image/png';
        } else if ($upload->upload_type == "pdf") {
            $type = 'application/pdf';
        } else if ($upload->upload_type == "doc") {
            $type = 'application/msword';
        } else if ($upload->upload_type == "docx") {
            $type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        } else if ($upload->upload_type == "ppt") {
            $type = "application/vnd.ms-powerpoint";
        } else if ($upload->upload_type == "pptx") {
            $type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
        } else if ($upload->upload_type == "mp4") {
            $type = "video/mp4";
        } else if ($upload->upload_type == "webm") {
            $type = "video/webm";
        } else {
            $type = 'image/jpeg';
        }

        header('Content-Type:' . $type);
        return readfile(Storage::path($filePath));
    }

    function displayFileForMobile($file_id)
    {
        $upload = UploadFiles::where('id', $file_id)->first();
        if (!$upload) {
            return response("Null Media File", 403);
        }

        $filePath = $upload->filepath . "/" . $upload->filename;

        if (!Storage::exists($filePath)) {
            if ($upload->meme_type == 'doc') {
                return abort(404);
            } else {
                return response('File Not Found', 403);
            }
        }

        if ($upload->upload_type == "jpg") {
            $type = 'image/jpeg';
        } else if ($upload->upload_type == "gif") {
            $type = 'image/gif';
        } else if ($upload->upload_type == "png") {
            $type = 'image/png';
        } else if ($upload->upload_type == "PNG") {
            $type = 'image/png';
        } else if ($upload->upload_type == "pdf") {
            $type = 'application/pdf';
        } else if ($upload->upload_type == "doc") {
            $type = 'application/msword';
        } else if ($upload->upload_type == "docx") {
            $type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        } else if ($upload->upload_type == "ppt") {
            $type = "application/vnd.ms-powerpoint";
        } else if ($upload->upload_type == "pptx") {
            $type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
        } else if ($upload->upload_type == "mp4") {
            $type = "video/mp4";
        } else if ($upload->upload_type == "webm") {
            $type = "video/webm";
        } else {
            $type = 'image/jpeg';
        }

        header('Content-Type:' . $type);
        // $fl =  readfile(Storage::path($filePath));
        return storage_path("app/{$filePath}");
    }

    function downloadFile($file_id)
    {
        $upload = UploadFiles::where('id', $file_id)->first();
        if (!$upload) {
            return response("Null Media File", 403);
        }

        $filePath = $upload->filepath . "/" . $upload->filename;

        if (!Storage::exists($filePath)) {
            if ($upload->meme_type == 'doc') {
                return abort(404);
            } else {
                return response('File Not Found', 403);
            }
        }

        if ($upload->upload_type == "jpg") {
            $type = 'image/jpeg';
        } else if ($upload->upload_type == "gif") {
            $type = 'image/gif';
        } else if ($upload->upload_type == "png") {
            $type = 'image/png';
        } else if ($upload->upload_type == "PNG") {
            $type = 'image/png';
        } else if ($upload->upload_type == "pdf") {
            $type = 'application/pdf';
        } else if ($upload->upload_type == "doc") {
            $type = 'application/msword';
        } else if ($upload->upload_type == "docx") {
            $type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        } else if ($upload->upload_type == "ppt") {
            $type = "application/vnd.ms-powerpoint";
        } else if ($upload->upload_type == "pptx") {
            $type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
        } else if ($upload->upload_type == "mp4") {
            $type = "video/mp4";
        } else if ($upload->upload_type == "webm") {
            $type = "video/webm";
        } else {
            $type = 'image/jpeg';
        }

        header('Content-Type:' . $type);
        return response()->download(storage_path("app/{$filePath}"));
    }
    function getFileAccess($file_id)
    {
        $upload = UploadFiles::find($file_id);
        $hash_id = md5($file_id);
        $current_time = Carbon::now()->toDateTimeString();
        $upload->hash_id = $hash_id;
        $upload->created_at = $current_time;
        if ($upload->save()) {
            return $upload->hash_id;
        }
    }
    function getFile($groupId)
    {
        return UploadFileGroups::where('upload_file_groups.file_id', $groupId)
            ->leftJoin('upload_file', 'upload_file.id', 'upload_file_groups.file_id')
            ->select('upload_file.*')
            ->orderBy('id', 'desc')
            ->first();
    }

    function getImageFile($groupId)
    {
        return $data = UploadFileGroups::where('upload_file_groups.file_group_id', $groupId)
            ->join('upload_file', 'upload_file.id', 'upload_file_groups.file_id')
            ->select('upload_file.*')
            ->where('upload_file.meme_type', 'image')
            ->orderBy('upload_file.id', 'desc')
            ->first();
    }

    function getAllFiles($groupId)
    {
        return $data = UploadFileGroups::where('upload_file_groups.file_group_id', $groupId)
            ->join('upload_file', 'upload_file.id', 'upload_file_groups.file_id')
            ->select('upload_file.*')
            ->orderBy('upload_file.id', 'desc')
            ->get();
    }

    public function deleteFile($id)
    {
        $file = UploadFiles::where('id', $id)->first();
        if ($file) {
            $filelocation = $file->filepath;
            $filename = $file->filename;
            $filePath = $filelocation . '/' . $filename;
            $filepathfull = Storage::path($filePath);
            if (Storage::exists($filePath)) {
                unlink($filepathfull);
                UploadFileGroups::where('file_id', $id)->delete();
                UploadFiles::where('id', $id)->delete();
                return 'Deleted Successfully';
            }
        } else {
            return 'File Doesnot Exists';
        }
    }
}
