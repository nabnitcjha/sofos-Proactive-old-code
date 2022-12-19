<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('displayFileForMobile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@displayFileForMobile');
Route::get('displayFileForMobileTest/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@displayFileForMobileTest');
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {




    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    // Route::post('me', 'App\Http\Controllers\AuthController@me');

});
Route::get('downloadFile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@downloadFile');
Route::get('displayFile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@displayFile');

Route::post('logout', 'App\Http\Controllers\AuthController@logout');
Route::post('register', 'App\Http\Controllers\CommonController@register');
Route::get('getEmail', 'App\Http\Controllers\CommonController@getEmail');
Route::get('me', 'App\Http\Controllers\AuthController@me');

Route::post('getUserList', 'App\Http\Controllers\userController@getUserList');
Route::post('login', 'App\Http\Controllers\AuthController@login');

//--------------------------------- Form Data --------------------
Route::group(['middleware' => ['role:admin|teacher|student|parent']], function () {
    
    Route::post('getDashboard', 'App\Http\Controllers\Forms\TimeTableController@getDashboard');

    Route::post('getWeekRecordForAdmin', 'App\Http\Controllers\Forms\TimeTableController@getWeekRecordForAdmin');
    Route::post('getDayRecordForAdmin', 'App\Http\Controllers\Forms\TimeTableController@getDayRecordForAdmin');
    Route::post('getSlots', 'App\Http\Controllers\Forms\TimeTableController@getSlots');
    Route::post('saveZoomLink', 'App\Http\Controllers\Forms\TimeTableController@saveZoomLink');
    
    Route::post('getSessionDetail', 'App\Http\Controllers\Forms\GradeController@getSessionDetail'); 
    
    Route::post('getClassesList', 'App\Http\Controllers\Forms\GradeController@getClassesList'); 
    Route::post('getStudentSessionDetail', 'App\Http\Controllers\Forms\GradeController@getStudentSessionDetail'); 
    Route::post('getSessionDetails', 'App\Http\Controllers\Forms\GradeController@getSessionDetails'); 
    Route::get('getParents', 'App\Http\Controllers\Forms\GuardianController@getParents');
    Route::get('getParent/{id}', 'App\Http\Controllers\Forms\GuardianController@getParent');
    Route::post('addParent', 'App\Http\Controllers\Forms\GuardianController@addParent');
    Route::post('addParentFromDetail', 'App\Http\Controllers\Forms\GuardianController@addParentFromDetail');
    
    Route::get('getClassessAccordingParent/{id}', 'App\Http\Controllers\Forms\GradeController@getClassessAccordingParent'); 

    Route::post('updateParent/{id}', 'App\Http\Controllers\Forms\GuardianController@updateParent');
    Route::post('deleteParent', 'App\Http\Controllers\Forms\GuardianController@deleteParent');
    Route::post('studentAccordingGradeSubject', 'App\Http\Controllers\Forms\SubjectController@studentAccordingGradeSubject'); 
});
Route::group(['middleware' => ['role:admin|teacher']], function () {
    Route::post('getGrades', 'App\Http\Controllers\Forms\GradeController@getGrades');
    Route::get('getGrade/{id}', 'App\Http\Controllers\Forms\GradeController@getGrade');
    Route::post('getSubjects', 'App\Http\Controllers\Forms\SubjectController@getSubjects');
    Route::post('getAllSubjects', 'App\Http\Controllers\Forms\SubjectController@getAllSubjects');
    Route::get('getSubject/{id}', 'App\Http\Controllers\Forms\SubjectController@getSubject');

    Route::get('getTeacherClassess/{id}', 'App\Http\Controllers\Forms\GradeController@getTeacherClassess'); 
    Route::post('getAllClassess', 'App\Http\Controllers\Forms\GradeController@getAllClassess'); 

    Route::post('getTodayClassess', 'App\Http\Controllers\Forms\GradeController@getTodayClassess'); 
    Route::post('getWeeklyClassess', 'App\Http\Controllers\Forms\GradeController@getWeeklyClassess'); 
    Route::post('getPreviousClassess', 'App\Http\Controllers\Forms\GradeController@getPreviousClassess'); 

    Route::post('getTeacherClass', 'App\Http\Controllers\Forms\GradeController@getTeacherClass');
    Route::get('getTeacherTimeTable/{id}', 'App\Http\Controllers\Forms\TimeTableController@getTeacherTimeTable');

    Route::post('getTeacherSlots', 'App\Http\Controllers\Forms\TimeTableController@getTeacherSlots');
    Route::post('addTimeTable', 'App\Http\Controllers\Forms\TimeTableController@addTimeTable');
    Route::post('teacherSlots', 'App\Http\Controllers\Forms\TimeTableController@teacherSlots');
    Route::post('teacherAccordingGradeSubject', 'App\Http\Controllers\Forms\SubjectController@teacherAccordingGradeSubject'); 
    Route::post('teacherAccordingSubject', 'App\Http\Controllers\Forms\SubjectController@teacherAccordingSubject'); 
    Route::post('getStudentAndParentList', 'App\Http\Controllers\userController@getStudentAndParentList');
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::post('addGrade', 'App\Http\Controllers\Forms\GradeController@addGrade');
    Route::post('updateGrade/{id}', 'App\Http\Controllers\Forms\GradeController@updateGrade');
    Route::post('deleteGrade', 'App\Http\Controllers\Forms\GradeController@deleteGrade');
    Route::get('getAllUserList', 'App\Http\Controllers\userController@getAllUserList');
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::post('addSubject', 'App\Http\Controllers\Forms\SubjectController@addSubject');
    Route::post('updateSubject/{id}', 'App\Http\Controllers\Forms\SubjectController@updateSubject');
    Route::post('deleteSubject', 'App\Http\Controllers\Forms\SubjectController@deleteSubject');
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::post('getTimeTables', 'App\Http\Controllers\Forms\TimeTableController@getTimeTables');
    Route::get('getTimeTable/{id}', 'App\Http\Controllers\Forms\TimeTableController@getTimeTable');
    Route::post('updateTimeTable/{id}', 'App\Http\Controllers\Forms\TimeTableController@updateTimeTable');

    Route::post('updateDragTimeTable', 'App\Http\Controllers\Forms\TimeTableController@updateDragTimeTable');

    Route::post('updateSingleSlot', 'App\Http\Controllers\Forms\TimeTableController@updateSingleSlot');
    
    Route::post('deleteTimeTable', 'App\Http\Controllers\Forms\TimeTableController@deleteTimeTable');
    Route::post('deleteSingleTimetable', 'App\Http\Controllers\Forms\TimeTableController@deleteSingleTimetable');
});
Route::group(['middleware' => ['role:admin|teacher|student']], function () { 
    Route::post('sessionCompleted', 'App\Http\Controllers\Forms\TimeTableController@sessionCompleted');

    Route::get('getStudentTimeTable/{id}', 'App\Http\Controllers\Forms\TimeTableController@getStudentTimeTable');

    Route::get('getParentTimeTable/{id}', 'App\Http\Controllers\Forms\TimeTableController@getParentTimeTable');
    Route::post('deleteStudentNotes', 'App\Http\Controllers\Forms\StudentController@deleteStudentNotes');
    
    Route::get('getStudentClassess/{id}', 'App\Http\Controllers\Forms\GradeController@getStudentClassess'); 
    
    Route::post('getStudents', 'App\Http\Controllers\Forms\StudentController@getStudents');
    Route::get('getStudent/{id}', 'App\Http\Controllers\Forms\StudentController@getStudent');
    Route::post('addStudent', 'App\Http\Controllers\Forms\StudentController@addStudent');
    
    Route::post('addDynamicParent', 'App\Http\Controllers\Forms\StudentController@addDynamicParent');

    
    Route::post('addStudentSubject', 'App\Http\Controllers\Forms\StudentController@addStudentSubject'); 
    Route::post('studentAccordingTeacherSubjects', 'App\Http\Controllers\Forms\StudentController@studentAccordingTeacherSubjects'); 
    Route::post('updateStudentSubject', 'App\Http\Controllers\Forms\StudentController@updateStudentSubject'); 
    Route::post('updateStudent', 'App\Http\Controllers\Forms\StudentController@updateStudent');
    Route::post('deleteStudent', 'App\Http\Controllers\Forms\StudentController@deleteStudent'); 
    Route::post('getAll-Active-Students', 'App\Http\Controllers\Forms\StudentController@allActiveStudents');
    Route::post('getSubjectAccordingGrade', 'App\Http\Controllers\Forms\TeacherController@getSubjectAccordingGrade');
});
Route::group(['middleware' => ['role:admin|teacher']], function () {
    Route::post('getTeachers', 'App\Http\Controllers\Forms\TeacherController@getTeachers'); 
    
    
    Route::get('getTeacher/{id}', 'App\Http\Controllers\Forms\TeacherController@getTeacher'); 
    //Route::get('getTeacherSubject/{id}', 'App\Http\Controllers\Forms\TeacherController@getTeacherSubject'); //get subject according to teacher
    Route::post('getTeacherSubject', 'App\Http\Controllers\Forms\TeacherController@getTeacherSubject'); //get subject according to teacher (bipin)
    Route::post('getSubjectTeacher', 'App\Http\Controllers\Forms\TeacherController@getSubjectTeacher');
    Route::get('getTeacherNote/{id}', 'App\Http\Controllers\Forms\TeacherController@getTeacherNote'); 
    Route::post('addTeacher', 'App\Http\Controllers\Forms\TeacherController@addTeacher'); 
    Route::post('addTeacherNote', 'App\Http\Controllers\Forms\TeacherController@addTeacherNote'); 
    Route::post('addTeacherGradeAndSubject', 'App\Http\Controllers\Forms\TeacherController@addTeacherGradeAndSubject'); 
    Route::post('updateTeacherSubject', 'App\Http\Controllers\Forms\TeacherController@updateTeacherSubject'); 
    Route::post('teacherAccordingSubject', 'App\Http\Controllers\Forms\TeacherController@teacherAccordingSubject');
    Route::post('updateTeacher', 'App\Http\Controllers\Forms\TeacherController@updateTeacher');
    Route::post('updateTeacherPassword', 'App\Http\Controllers\Forms\TeacherController@updateTeacherPassword'); //bipin

    Route::post('updateTeacherContact', 'App\Http\Controllers\Forms\TeacherController@updateTeacherContact');
    
    Route::post('deleteTeacher', 'App\Http\Controllers\Forms\TeacherController@deleteTeacher');
    Route::post('deleteTeacherNotes', 'App\Http\Controllers\Forms\TeacherController@deleteTeacherNotes');
    Route::post('getAll-Active-Teachers', 'App\Http\Controllers\Forms\TeacherController@allActiveTeachers'); 
    
    Route::post('getAssessments', 'App\Http\Controllers\Forms\AssessmentController@getAssessments');   
      
    
    Route::get('getAssessment/{id}', 'App\Http\Controllers\Forms\AssessmentController@getAssessment');
    Route::post('updateTeacherAssessment', 'App\Http\Controllers\Forms\AssessmentController@updateTeacherAssessment'); 
    Route::post('deleteAssessment', 'App\Http\Controllers\Forms\AssessmentController@deleteAssessment');
    Route::post('assignAssement', 'App\Http\Controllers\Forms\AssessmentController@assignAssement');   
    
    Route::post('updateTeacherProfile', 'App\Http\Controllers\userController@updateTeacherProfile');
});


// Image upload
Route::group(['middleware' => ['role:admin|teacher']], function () {
    Route::post('uploadTeacherImage', 'App\Http\Controllers\Forms\TeacherController@uploadTeacherImage'); 
});
Route::group(['middleware' => ['role:admin|student']], function () {
    Route::post('uploadStudentImage', 'App\Http\Controllers\Forms\StudentController@uploadStudentImage');
    Route::post('updateStudentProfile', 'App\Http\Controllers\userController@updateStudentProfile');
});

// Route::group(['middleware' => ['role:admin|student|teacher']], function () {
//     Route::get('displayFile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@displayFile');
//     Route::get('deleteFile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@deleteFile');
// });

Route::get('displayFile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@displayFile');
    Route::get('deleteFile/{id}', 'App\Http\Controllers\Forms\uploadImageOrFileController@deleteFile');



//student teacher
Route::group(['middleware' => ['role:admin|student|teacher|parent']], function () {

    Route::post('studentEnableStatus', 'App\Http\Controllers\Forms\StudentController@studentEnableStatus'); 
    Route::post('teacherEnableStatus', 'App\Http\Controllers\Forms\StudentController@teacherEnableStatus'); 
    
    Route::post('getStudentNotes', 'App\Http\Controllers\Forms\StudentController@getStudentNotes'); 
    
    Route::post('notCompletedSession', 'App\Http\Controllers\Forms\TimeTableController@notCompletedSession');
    
    Route::post('completedSession', 'App\Http\Controllers\Forms\TimeTableController@completedSession');

    Route::post('upcommingSession', 'App\Http\Controllers\Forms\TimeTableController@upcommingSession');

    Route::post('getTeacherAllNotes', 'App\Http\Controllers\Forms\TeacherController@getTeacherAllNotes'); 
    Route::post('teacherStudyResources', 'App\Http\Controllers\Forms\AssessmentController@teacherStudyResources');   
    Route::post('addTeacherAssessment', 'App\Http\Controllers\Forms\AssessmentController@addTeacherAssessment');
    Route::post('getAllTimeTables', 'App\Http\Controllers\Forms\TimeTableController@getAllTimeTables');
    Route::post('getStudentClass', 'App\Http\Controllers\Forms\GradeController@getStudentClass'); 
    Route::post('getStudentAssessment', 'App\Http\Controllers\Forms\StudentController@getStudentAssessment');
    Route::post('addStudentNote', 'App\Http\Controllers\Forms\StudentController@addStudentNote'); 
    Route::post('getAssessmentAccordingGrade', 'App\Http\Controllers\Forms\AssessmentController@getAssessmentAccordingGrade');
    Route::post('getStudentResponse', 'App\Http\Controllers\Forms\AssessmentController@getStudentResponse');
    Route::post('addAssessmentSolution', 'App\Http\Controllers\Forms\AssessmentController@addAssessmentSolution');
    Route::post('addStudentTeacher', 'App\Http\Controllers\Forms\StudentTeacherController@addStudentTeacher');
    Route::post('deleteStudentTeacher', 'App\Http\Controllers\Forms\StudentTeacherController@deleteStudentTeacher');
    Route::get('getStudentWithTeachers/{studentId}', 'App\Http\Controllers\Forms\StudentTeacherController@getStudentWithTeachers');
    Route::get('getTeacherWithStudents/{teacherId}', 'App\Http\Controllers\Forms\StudentTeacherController@getTeacherWithStudents');
    Route::get('getAllTeachersWithStudents', 'App\Http\Controllers\Forms\StudentTeacherController@getAllTeachersWithStudents');
    Route::post('getAssociatedStudents', 'App\Http\Controllers\Forms\StudentTeacherController@getAssociatedStudents');
    Route::post('getFilteredTeachers', 'App\Http\Controllers\Forms\StudentTeacherController@getFilteredTeachers');
    Route::post('getFilteredStudents', 'App\Http\Controllers\Forms\StudentTeacherController@getFilteredStudents');
    Route::post('getFilteredTimetable', 'App\Http\Controllers\Forms\StudentTeacherController@getFilteredTimetable');
    Route::post('getFilteredSubjects', 'App\Http\Controllers\Forms\StudentTeacherController@getFilteredSubjects');
    Route::get('getStudentTimetableDetails/{studentId}', 'App\Http\Controllers\Forms\StudentTeacherController@getStudentTimetableDetails');
    
    Route::get('getAllTeachers', 'App\Http\Controllers\Forms\StudentTeacherController@getAllTeachers');

    Route::post('getStudentAccordingTeacher', 'App\Http\Controllers\Forms\StudentTeacherController@getStudentAccordingTeacher');

    Route::post('getAssociatedParents', 'App\Http\Controllers\Forms\StudentTeacherController@getAssociatedParents');

    Route::get('getTeacherStudents/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getTeacherStudents');
    Route::get('getTeacherStudentsTest/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getTeacherStudentsTest');

    Route::get('getStudentTeachers/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getStudentTeachers');
    
    Route::get('getTeacherAccordingParent/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getTeacherAccordingParent');
    Route::get('getTimeTableAccordingParent/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getTimeTableAccordingParent');
    
    Route::get('getStudentParents/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getStudentParents');

    Route::get('getParentStudents/{id}', 'App\Http\Controllers\Forms\StudentTeacherController@getParentStudents');

    Route::post('getstudentForSlots', 'App\Http\Controllers\Forms\StudentTeacherController@getstudentForSlots');
    Route::post('alotClass', 'App\Http\Controllers\Forms\StudentTeacherController@alotClass');
    Route::post('deleteAlotClass', 'App\Http\Controllers\Forms\StudentTeacherController@deleteAlotClass');
    Route::post('getFilteredAssociatedStudents', 'App\Http\Controllers\Forms\StudentTeacherController@getFilteredAssociatedStudents');

    Route::get('getParentClassess/{id}', 'App\Http\Controllers\Forms\GradeController@getParentClassess'); 
    //
}); 

Route::post('forgot-password', 'App\Http\Controllers\Forms\StudentTeacherController@forgotPassword');
Route::post('reset-password', 'App\Http\Controllers\Forms\StudentTeacherController@resetPassword');
//Role-Permission
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('getRoles', 'App\Http\Controllers\userController@getRoles');
    Route::get('getPermissions', 'App\Http\Controllers\userController@getPermissions');
    Route::post('savePermissions', 'App\Http\Controllers\userController@savePermissions');
    Route::get('getRoleHasPermissions', 'App\Http\Controllers\userController@getRoleHasPermissions');
    
});


//trillo
Route::group(['middleware' => ['role:admin|student|teacher']], function () {
    Route::post('sendMessage', 'App\Http\Controllers\Forms\UsersPhoneNumberController@sendMessage');
});
Route::get('receiveMessage', 'App\Http\Controllers\Forms\UsersPhoneNumberController@receiveMessage');
Route::post('activateAccount', 'App\Http\Controllers\UserController@activateAccount');



Route::group(['middleware' => ['role:admin|student|teacher|parent']], function () {
    Route::post('updateAdminProfile', 'App\Http\Controllers\userController@updateAdminProfile');
    
    Route::post('getTeacherNotes', 'App\Http\Controllers\Forms\TeacherController@getTeacherNotes'); 
    Route::post('uploadImage', 'App\Http\Controllers\Forms\StudentController@uploadImage');
    Route::get('Chats', 'App\Http\Controllers\ChatsController@index');
    Route::get('messages', 'App\Http\Controllers\ChatsController@fetchMessages');
    Route::post('messages', 'App\Http\Controllers\ChatsController@sendMessage'); 
    Route::post('getPrivateMessage', 'App\Http\Controllers\ChatsController@getPrivateMessage');
    Route::post('getRealTimePrivateMessage', 'App\Http\Controllers\ChatsController@getRealTimePrivateMessage');
    Route::post('updateStudentPassword', 'App\Http\Controllers\Forms\StudentController@updateStudentPassword'); //bipin
});

