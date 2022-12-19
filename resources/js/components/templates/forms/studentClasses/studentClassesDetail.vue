<template>
  <div class="student-wrapper">
    <vs-modal v-model="showStartModel" class="modal-ac">
      <div slot="modal-header" class="modal-header">
        <span class="hp-3-title">Meet with | Join with </span>
        <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
      </div>
      <div slot="modal-body" class="modal-body">
        <div class="form-group col-sm-12 col-lg-12">
          <div class="zoom-link">
            <input
              v-model="zoomLink"
              type="text"
              class="form-control remove-border"
              id="zoomlink"
              placeholder="add link"
              @input="saveZoomLink"
            />
            <i class="fa fa-copy" @click.stop="copyZoomLink"></i>
          </div>
        </div>
      </div>
      <div slot="modal-footer" class="modal-footer">
       
      </div>
    </vs-modal>

    <vs-modal v-model="showNoteModel" class="modal-ac">
      <div slot="modal-header" class="modal-header">
        <span class="hp-3-title">Add Your Notes </span>
        <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
      </div>
      <div slot="modal-body" class="modal-body">
        <div class="form-group">
          <textarea
            class="form-control"
            id="exampleFormControlTextarea1"
            rows="3"
            v-model="teacherNote"
          ></textarea>
        </div>
      </div>
      <div slot="modal-footer" class="modal-footer">
        <div class="custom-control custom-checkbox">
          <input
            type="checkbox"
            class="custom-control-input"
            id="customControlValidation1"
            @click="selectType($event)"
          />
          <label class="custom-control-label" for="customControlValidation1"
            >Visible to Students</label
          >
        </div>
        <button
          type="button"
          class="btn btn-primary"
          @click.stop="saveTeacherNotes"
        >
          Add Note
        </button>
      </div>
    </vs-modal>
    <vs-modal v-model="openCompleteNow" class="modal-ac">
      <div slot="modal-header" class="modal-header">
        <span class="hp-3-title">Add Your Notes </span>
        <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
      </div>
      <div slot="modal-body" class="modal-body">
        <div class="form-group">
          <textarea
            class="form-control"
            id="exampleFormControlTextarea1"
            rows="3"
            v-model="completeNowNote"
          ></textarea>
        </div>
      </div>
      <div slot="modal-footer" class="modal-footer">
        <button
          type="button"
          class="btn btn-primary"
          @click.stop="saveCompleteNowNotes"
        >
          Add Note
        </button>
      </div>
    </vs-modal>
    <div class="wrapper-content section-wrapper">
      <div class="row">
        <div class="col-sm-12">
          <div class="session-wrapper">
            <div class="mt-4">
              <div class="tab-bar-custom">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link active"
                      id="pills-home-tab"
                      data-toggle="pill"
                      href="#pills-home"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                      >Details</a
                    >
                  </li>
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link"
                      id="pills-profile-tab"
                      data-toggle="pill"
                      href="#pills-profile"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                      >Upcoming Class</a
                    >
                  </li>
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link"
                      id="pills-contact-tab"
                      data-toggle="pill"
                      href="#pills-contact"
                      role="tab"
                      aria-controls="pills-contact"
                      aria-selected="false"
                      >History</a
                    >
                  </li>
                </ul>
                <div class="tab-content proactive-card" id="pills-tabContent">
                  <div
                    class="tab-pane fade show active"
                    id="pills-home"
                    role="tabpanel"
                    aria-labelledby="pills-home-tab"
                  >
                    <div class="session-header">
                      <h5 class="title">
                        <span
                          >{{ classDetails.topic }} ({{
                            classDetails.subject.name
                          }}),</span
                        >
                        &nbsp;<span
                          class=""
                          style="font-size: 16px; font-weight: 500"
                        >
                          {{ classDetails.time_am_pm }} GMT</span
                        >
                      </h5>
                      <a
                        ><div
                          class="button btn-session pointer-hand"
                          @click.stop="startClass"
                          v-if="todayClassDetail.isToday == 'yes'"
                        >
                          Start Class
                        </div></a
                      >
                    </div>

                    <div class="std-list-session">
                      <div
                        class="std-list st-1"
                         
                      >
                        <img
                          class="img-fluid"
                          :src="
                            teacherList.teacher_image == null
                              ? adminImage
                              : $root.getMedia(teacherList.teacher_image)
                          "
                        />
                        <span
                          >{{ teacherList.first_name }}{{ " "
                          }}{{ teacherList.last_name }}</span
                        >
                      </div>

                       <div class="Session-detail mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Session Detail </span
                        >
                        <!-- <span><i class="fas fa-exclamation-circle"></i></span> -->
                      </h5>
                      <div class="session-detail-text text-left mt-3">
                        {{classDetails.event_message}}
                      </div>
                    </div>

                      <hr />
                    </div>

                    <!-- <div class="Session-uncomplete mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Session Not Yet Completed </span
                        ><span><i class="fas fa-exclamation-circle"></i></span>
                      </h5>
                      <div class="session-uncomplete-list">
                        <div
                          class="s-list mb-2"
                          v-for="(session, index) in pendingSession"
                          :key="index"
                        >
                          <p>
                            {{ getDay(session.start_date) }}{{ "   :   "
                            }}{{ session.time_am_pm }} GMT
                          </p>
                        
                        </div>
                      </div>
                    </div> -->
                    

                    <div class="assignment-table mt-4">
                      <div class="assignment-header">
                        <h5 class="title sub-title">Assignments</h5>
                        <!-- <h5
                          class="sub-title"
                          data-toggle="modal"
                          data-target="#exampleModalLong"
                        >
                          ADD <i class="fas fa-plus-circle"></i>
                        </h5> -->
                        <div
                          class="modal fade"
                          id="exampleModalLong"
                          tabindex="-1"
                          role="dialog"
                          aria-labelledby="exampleModalLongTitle"
                          aria-hidden="true"
                        >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5
                                  class="modal-title"
                                  id="exampleModalLongTitle"
                                >
                                  Upload Assignment
                                </h5>
                                <button
                                  type="button"
                                  class="close"
                                  data-dismiss="modal"
                                  aria-label="Close"
                                >
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form
                                  class="
                                    col-sm-12 col-lg-6
                                    make-center
                                    dark-background
                                  "
                                >
                                  <div
                                    class="form-group pointer-hand"
                                    @click.stop="openFileUploadDialog"
                                  >
                                    <img :src="UploadIcon" alt="" />
                                    <p>upload your file</p>
                                  </div>
                                  <div class="progress" v-if="showProgress">
                                    <div
                                      class="progress-bar"
                                      role="progressbar"
                                      style="width: 100%"
                                      aria-valuenow="25"
                                      aria-valuemin="0"
                                      aria-valuemax="100"
                                    >
                                      100%
                                    </div>
                                  </div>
                                </form>
                                <div class="space-between">
                                  <div
                                    class="form-group"
                                    style="visibility: hidden"
                                  >
                                    <label for="teacher-assignment-upload"
                                      >Example file input</label
                                    >
                                    <input
                                      type="file"
                                      class="form-control-file"
                                      id="teacher-assignment-upload"
                                      @change="handleFile"
                                    />
                                  </div>
                                  <!-- <div class="form-group col-sm-6 col-lg-6">
                                    <label for="teacher-assignment-deadline"
                                      >Add Deadline</label
                                    >
                                    <div
                                      class="
                                        form-group
                                        teacher-assignment-deadline
                                      "
                                    >
                                      <date-picker
                                        v-model="deadline"
                                        type="datetime"
                                        placeholder="Select datetime"
                                        format="YYYY-MM-DD hh:mm a"
                                        :default-value="new Date()"
                                        :disabled-date="disabledBeforeToday"
                                      ></date-picker>
                                      <button
                                        class="btn btn-orange ml-4"
                                        @click.stop="createAssessment"
                                      >
                                        Save
                                      </button>
                                    </div>
                                  </div> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <table
                        class="table table-borderless table-responsive-md mt-3"
                      >
                        <thead>
                          <tr>
                            <!-- <th scope="col">Title</th> -->
                            <th scope="col">Created Date</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Files</th>
                            <th scope="col">Submitted</th>
                            <th scope="col">Submitted Date</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody v-if="assessmentLists.length > 0">
                          <tr
                            class="custom-checkbox"
                            v-for="(assmList, index) in assessmentLists"
                            :key="index"
                          >
                            <!-- <td>{{ assmList.topic }}</td> -->
                            <td>{{ formatedDate(assmList.created_at) }}</td>
                            <td>{{ formatedDate(assmList.deadline) }}</td>
                            <td class="assignment-docs">
                              <span>
                                <i class="far fa-file-alt"></i>
                                {{
                                  assmList.assessmentFile.original_filename
                                }}</span
                              >
                            </td>
                            <td class="pointer-hand" v-if="assmList.assessmentsolution!=null" @click.stop="downloadAssessment(assmList.assessmentsolution.assessment_answer_file)">
                              {{assmList.solutionFile.original_filename}}</td>
                            <td v-else>{{' '}}</td>
                            <td v-if="assmList.submitted_date!=''">{{ formatedDate(assmList.submitted_date) }}</td>
                            <td v-else>{{' '}}</td>
                            <!-- <td class="assignment-docs">
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span><br>
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span>
                          </td> -->

                            <!-- <td class="text-jutify td-font">
                      {{ assmList.assessmentFile.original_filename }}
                    </td>
                    <td class="text-jutify td-font">{{ assmList.deadline }}</td> -->
                            <td>
                              <ul class="list-inline">
                                <a
                                  ><li class="list-inline-item">
                                    <img
                                      class="img-fluid pointer-hand"
                                      :src="Download"
                                      @click.stop="downloadAssessment(assmList.assessment_file)"
                                    /></li
                                ></a>
                                <a
                                  ><li class="list-inline-item">
                                    <img class="img-fluid pointer-hand" :src="UploadIcon"  @click.stop="openFileUploadDialog(assmList)"/></li
                                ></a>
                                <a
                                  ><li class="list-inline-item">
                                    <img class="img-fluid pointer-hand" :src="View" @click.stop="showDocument(assmList.assessment_file)"/>
                                    </li
                                ></a>
                                <!-- <a
                                  ><li class="list-inline-item">
                                    <img class="img-fluid" :src="Delete" /></li
                                ></a> -->
                              </ul>
                            </td>
                          </tr>
                        </tbody>
                        <p
                          class="table-null"
                          v-if="assessmentLists.length == 0"
                 
                        >
                          No record found
                        </p>
                        <!-- <tbody>
                        <tr>
                          <td>Trigonometry</td>
                          <td>Jan-15-2022</td>
                          <td>Jan-28-2022</td>
                          <td class="assignment-docs">
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span><br>
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span>
                          </td>

                          <td class="assignment-docs">
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span><br>
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span>
                          </td>
                          <td>
                            <ul class="list-inline">
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/download.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/edit.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/view.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/delete.svg"></li></a>
                            </ul>
                          </td>
                        </tr>

                        <tr>
                          <td>Trigonometry</td>
                          <td>Jan-15-2022</td>
                          <td>Jan-28-2022</td>
                          <td class="assignment-docs">
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span><br>
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span>
                          </td>

                          <td class="assignment-docs">
                            <span> -------  </span><br>
                            
                          </td>
                          <td>
                            <ul class="list-inline">
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/download.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/edit.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/view.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/delete.svg"></li></a>
                            </ul>
                          </td>
                        </tr>

                        <tr>
                          <td>Trigonometry</td>
                          <td>Jan-15-2022</td>
                          <td>Jan-28-2022</td>
                          <td class="assignment-docs">
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span><br>
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span>
                          </td>

                          <td class="assignment-docs">
                            <span> <i class="far fa-file-alt"></i> Pdf algebric equation</span><br>
                            
                          </td>
                          <td>
                            <ul class="list-inline">
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/download.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/edit.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/view.svg"></li></a>
                              <a ><li class="list-inline-item"><img class="img-fluid" src="/images/delete.svg"></li></a>
                            </ul>
                          </td>
                        </tr>
 
                      </tbody> -->
                      </table>
                    </div>

                    <div class="mb-10 mt-4">
                      <div class="session-header session-notes">
                        <h5 class="title sub-title text-justify">
                        <span>Notes </span
                        >
                      </h5>
                        <!-- <h6 @click.stop="openNotesModal">
                          Add Notes<i
                            class="fas fa-plus-circle orange-color"
                          ></i>
                        </h6> -->
                      </div>

                      <hr />
                      <div
                        class="notes-section"
                        v-for="(teachernote, index) in studentNotes"
                        :key="index"
                      >
                        <!-- <div class="notes-action">
                          <a @click.stop="deleteTeacherNotes(teachernote.id)">
                            <span class="pointer-hand">Delete</span></a
                          >&nbsp; &nbsp;
                          <a @click.stop="updateTeacherNotes(teachernote)">
                            <span class="pointer-hand">Edit</span></a
                          >
                        </div> -->

                        <div class="note-details text-left">
                          <p>{{ teachernote.notes }}</p>
                        </div>

                        <!-- <div class="note-by">
                          <p>Visible to students |</p>
                          <p>Martin Thomas |</p>
                          <p>Jan-28-2022</p>
                        </div> -->
                      </div>
                       <p
                            class="table-null"
                            v-if="studentNotes.length == 0"
                          >
                            No record found
                          </p>
                    </div>
                    
                    <div
                      class="
                        d-sm-flex
                        align-items-center
                        justify-content-between
                        mb-4
                      "
                      style="margin-top: 2.5rem;"
                    >
                      <h5 class="title sub-title text-justify">Study Resources</h5>
        
                    </div>
                    <hr />
                    <div
                              class="
                                form-group
                                text-justify-center
                                teacher-notes
                              "
                            >
                              <div
                                class="col-lg-3 topic-card"
                                v-for="(tsr, index) in studyResourcesList"
                                :key="index"
                              >
                                <h1 class="mb-4">{{ tsr.topic }}</h1>
                                <h5 class="mb-4">
                                  {{ tsr.assessmentFile.original_filename }}
                                </h5>
                                <button
                                  type="button"
                                  class="btn btn-orange orange-color"
                                  @click.stop="
                                    downloadStudyResources(
                                      tsr.assessmentFile.id
                                    )
                                  "
                                >
                                  Download
                                </button>
                              </div>
                              
                                <p
                            class="table-null"
                            v-if="studyResourcesList.length == 0"
                          >
                            No record found
                          </p>
                              <div class="col-lg-3 topic-card">
                                <!-- <button
                                  type="button"
                                  class="btn btn-success"
                                  @click.stop="openNoteUploadDialog"
                                >
                                  Add Notes
                                </button> -->
                              </div>
                            </div>
                            <div class="form-group" style="visibility: hidden">
                              <label for="studey_resource_upload"
                                >Example file input</label
                              >
                              <input
                                type="file"
                                class="form-control-file"
                                id="studey_resource_upload"
                                @change="handleStudyResource"
                              />
                            </div>

                    <!-- <div
        class="
          d-sm-flex
          align-items-center
          justify-content-between
          mb-4
          col-lg-12
        "
      >
        <h1 class="h3 mb-0 text-gray-800">Student's Response</h1>
      </div> -->

                    <!-- <div class="col-lg-12 detail-card">
                      <div class="card mb-4 col-lg-12">
                        <div class="ml-3 col-lg-3">
                          <h6>Assignment Solution</h6>
                        </div>
                        <div class="card-body col-lg-12 assignment-solution">
                          <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Class</th>
                                <th scope="col">Student</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody v-if="studentResponse.length > 0">
                              <tr
                                v-for="(stdRes, index) in studentResponse"
                                :key="index"
                              >
                                <th>{{ index + 1 }}</th>
                                <th>{{ classDetails.topic }}</th>
                                <th>
                                  {{ stdRes.student.first_name }}{{ " "
                                  }}{{ stdRes.student.middle_name }}{{ " "
                                  }}{{ stdRes.student.last_name }}
                                </th>
                                <th>
                                  <span
                                    @click.stop="
                                      downloadAssessment(
                                        stdRes.assessment_answer_file
                                      )
                                    "
                                    class="pointer-hand action-seprator"
                                    v-if="checkPermission(['read'])"
                                    ><i
                                      class="fas fa-download"
                                      style="color: #8bc34a"
                                    ></i
                                  ></span>
                                </th>
                              </tr>
                            </tbody>
                          </table>
                          <p
                            class="table-null"
                            v-if="studentResponse.length == 0"
                          >
                            No record found
                          </p>
                        </div>
                      </div>
                    </div> -->
                  </div>
                  <div
                    class="tab-pane fade"
                    id="pills-profile"
                    role="tabpanel"
                    aria-labelledby="pills-profile-tab"
                  >
                    <div class="session-header">
                      <h5 class="title">
                        <span
                          >{{ classDetails.topic }} ({{
                            classDetails.subject.name
                          }}),</span
                        >
                        &nbsp;<span
                          class=""
                          style="font-size: 16px; font-weight: 500"
                        >
                          {{ classDetails.time_am_pm }} GMT</span
                        >
                      </h5>
                    </div>
                     <div class="std-list-session">
                      <div
                        class="std-list st-1"
                         
                      >
                        <img
                          class="img-fluid"
                          :src="
                            teacherList.teacher_image == null
                              ? adminImage
                              : $root.getMedia(teacherList.teacher_image)
                          "
                        />
                        <span
                          >{{ teacherList.first_name }}{{ " "
                          }}{{ teacherList.last_name }}</span
                        >
                      </div>

                       <div class="Session-detail mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Session Detail </span
                        >
                        <!-- <span><i class="fas fa-exclamation-circle"></i></span> -->
                      </h5>
                      <div class="session-detail-text text-left mt-3">
                        {{classDetails.event_message}}
                      </div>
                    </div>

                      <hr />
                    </div>
                    <div class="std-list-session">
                      <div
                        class="std-list st-1"
                        v-for="(std, index) in classDetails.student"
                        :key="index"
                      >
                        <img
                          class="img-fluid"
                          :src="
                            std.student_image == null
                              ? adminImage
                              : $root.getMedia(std.student_image)
                          "
                        />
                        <span
                          >{{ std.first_name }}{{ " "
                          }}{{ std.last_name }}</span
                        >
                      </div>
                      <hr />
                    </div>

                    <div class="Session-uncomplete mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Upcoming Class </span
                        ><span><i class="fas fa-exclamation-circle"></i></span>
                      </h5>
                      <div class="session-uncomplete-list">
                        <div
                          class="s-list mb-2"
                          v-for="(session, index) in upcommingSession"
                          :key="index"
                        >
                          <p>
                            {{ getDay(session.start_date) }}{{ "   :   "
                            }}{{ session.time_am_pm }} GMT
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="pills-contact"
                    role="tabpanel"
                    aria-labelledby="pills-contact-tab"
                  >
                    <div class="session-header">
                      <h5 class="title">
                        <span
                          >{{ classDetails.topic }} ({{
                            classDetails.subject.name
                          }}),</span
                        >
                        &nbsp;<span
                          class=""
                          style="font-size: 16px; font-weight: 500"
                        >
                          {{ classDetails.time_am_pm }} GMT</span
                        >
                      </h5>
                    </div>
 <div class="std-list-session">
                      <div
                        class="std-list st-1"
                         
                      >
                        <img
                          class="img-fluid"
                          :src="
                            teacherList.teacher_image == null
                              ? adminImage
                              : $root.getMedia(teacherList.teacher_image)
                          "
                        />
                        <span
                          >{{ teacherList.first_name }}{{ " "
                          }}{{ teacherList.last_name }}</span
                        >
                      </div>

                       <div class="Session-detail mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Session Detail </span
                        >
                        <!-- <span><i class="fas fa-exclamation-circle"></i></span> -->
                      </h5>
                      <div class="session-detail-text text-left mt-3">
                        {{classDetails.event_message}}
                      </div>
                    </div>

                      <hr />
                    </div>
                    <div class="std-list-session">
                      <div
                        class="std-list st-1"
                        v-for="(std, index) in classDetails.student"
                        :key="index"
                      >
                        <img
                          class="img-fluid"
                          :src="
                            std.student_image == null
                              ? adminImage
                              : $root.getMedia(std.student_image)
                          "
                        />
                        <span
                          >{{ std.first_name }}{{ " "
                          }}{{ std.last_name }}</span
                        >
                      </div>
                      <hr />
                    </div>
                     <div class="Session-uncomplete mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Completed Session </span
                        ><span><i class="fas fa-exclamation-circle"></i></span>
                      </h5>
                      <div id="accordion">

                      <div class="card"
                      v-for="(session, index) in completedSession"
                          :key="index"
                      >
                        <div class="card-header">
                          <a class="card-link" data-toggle="collapse" :href="`#collapseOne${index}`">
                           {{ getDay(session.start_date) }}{{ "   :   "
                            }}{{ session.time_am_pm }} GMT
                          </a>
                        </div>
                        <div   :id="`collapseOne${index}`" class="collapse" data-parent="#accordion">
                          <div class="card-body">
                            {{ session.completeNowNote }}
                          </div>
                        </div>
                      </div>
                    </div>
                       
                      <!-- <div class="session-uncomplete-list">
                        <div
                          class="s-list mb-2"
                          v-for="(session, index) in completedSession"
                          :key="index"
                        >
                          <p>
                            {{ getDay(session.start_date) }}{{ "   :   "
                            }}{{ session.time_am_pm }} GMT
                          </p>
                        </div>
                      </div> -->
                    </div>
                    <!-- <div class="Session-uncomplete mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Completed Session </span
                        ><span><i class="fas fa-exclamation-circle"></i></span>
                      </h5>
                      <div class="session-uncomplete-list">
                        <div
                          class="s-list mb-2"
                          v-for="(session, index) in completedSession"
                          :key="index"
                        >
                          <p>
                            {{ getDay(session.start_date) }}{{ "   :   "
                            }}{{ session.time_am_pm }} GMT
                          </p>
                        </div>
                      </div>
                    </div> -->

                    <!-- <div class="Session-uncomplete mt-4">
                      <h5 class="title sub-title text-justify">
                        <span>Notes </span
                        ><span><i class="fas fa-exclamation-circle"></i></span>
                      </h5>
                      <div class="session-uncomplete-list">
                        <div
                          class="s-list mb-2"
                          v-for="(teachernote, index) in AllNotes"
                          :key="index"
                        >
                          <p>{{ teachernote.notes }}</p>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end of main bodywrapper -->
  </div>
</template>

<script>
import { Student } from "../../../../Assets/dashboard/index";
import vPagination from "vue-plain-pagination";
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
import "./studentClasses.css";
import { Upload } from "../../../molecules/admin/dashboard/Icons/index";
import deleteModal from "../../../molecules/modals/delete.vue";
import { Delete, Download, Edit, View ,UploadIcon} from "./img";
import moment from "moment";

export default {
  data() {
    return {
      UploadIcon:UploadIcon,
      Delete: Delete,
      Download: Download,
      Edit: Edit,
      View: View,
      adminImage: Student,
      loading: false,
      zoomLink: "",
      classes: [],
      isNewClicked: true,
      isPreviousClicked: false,
      selectedAccessType: "private",
      accessTypes: [
        {
          name: "private",
        },
        {
          name: "public",
        },
      ],
      bootstrapPaginationClasses: {
        ul: "custom-pagination",
        li: "page-item",
        liActive: "active",
        liDisable: "disabled",
        button: "page-link",
      },
      paginationAnchorTexts: {
        first: "First",
        prev: "Previous",
        next: "Next",
        last: "Last",
      },
      openCompleteNow: false,
      paginationCurrent: "",
      paginationTotal: "",
      showProgress: false,
      allowStudent: false,
      Upload: Upload,
      allowAddNotes: false,
      completeNowNote: "",
      showNoteModel: false,
      classDetails: [],
      currentAssessmentId: "",
      deadline: [],
      teacher_id: "",
      class_id: "",
      subject_id: "",
      teacherNote: "",
      studentNotes: [],
      AllNotes: [],
      isEditClick: false,
      currentSessionId: "",
      currentNoteId: "",
      userType: "",
      showStartModel: false,
      assessment_file: "",
      assessmentLists: [],
      studyResourcesList: [],
      studentResponse: [],
      pendingSession: [],
      upcommingSession: [],
      completedSession: [],
      study_resource_file: "",
      isViewAllClicked: false,
      teacherStudyResources: [],
      current_timetable_id: 0,
      current_teacher_id: 0,
      teacherList:{},
      todayClassDetail: "",
    };
  },
  components: {
    "delete-modal": deleteModal,
    vPagination,
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
    }),
  },
  methods: {
      selectAssessment(assmList) {
    this.currentAssessmentId = assmList.id;
    },
    openNotesModal() {
      this.showNoteModel = true;
    },
    notCompletedSession() {
      this.showStartModel = false;
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      axios.post("/api/notCompletedSession", formData).then((response) => {
        this.pendingSession = response.data.result;
      });
    },
    UpcommingSessions() {
      this.showStartModel = false;
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      axios.post("/api/upcommingSession", formData).then((response) => {
        this.upcommingSession = response.data.result;
      });
    },
    CompletedSessions() {
      this.showStartModel = false;
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      axios.post("/api/completedSession", formData).then((response) => {
        this.completedSession = response.data.result;
      });
    },
     emptyLink() {
      this.$toast.open({
        message: "Link is not added",
        type: "warning",
        duration: 5000,
        dismissible: true,
      });
    },
    startClass() {
      if (this.zoomLink!=null) {
        window.open(this.zoomLink)
      }else{
        this.emptyLink();
      }
    },
    saveCompleteNowNotes() {
      this.completeNow(this.currentSessionId);
    },
    openCompleteNowModal(session) {
      this.currentSessionId = session.id;
      this.openCompleteNow = true;
    },
    completeNow(id) {
      this.showStartModel = false;
      this.openCompleteNow = false;
      let formData = {};
      formData["completed"] = 2;
      formData["timetable_id"] = id;
      formData["completeNowNote"] = this.completeNowNote;
      axios.post("/api/sessionCompleted", formData).then((response) => {
        this.CompletedSessions();
        this.notCompletedSession();
      });
    },
    modalClose() {
      this.openCompleteNow = false;
      this.showStartModel = false;
      this.showNoteModel = false;
      let formData = {};
      formData["completed"] = 1;
      formData["timetable_id"] = this.$route.params.allot_class_id;
      axios.post("/api/sessionCompleted", formData).then((response) => {
        this.notCompletedSession();
      });
    },
    zoomSaveSuccessfully() {
      this.$toast.open({
        message: "link save successfully",
        type: "success",
        duration: 5000,
        dismissible: true,
      });
    },
    saveZoomLink(e) {
      let formData = {};
      formData["zoomLink"] = e.target.value;
      formData["timetable_id"] = this.$route.params.allot_class_id;
      axios.post("/api/saveZoomLink", formData).then((response) => {
        this.zoomSaveSuccessfully();
      });
    },
    copyZoomLink() {
      /* Get the text field */
      var copyText = document.getElementById("zoomlink");

      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /* For mobile devices */

      /* Copy the text inside the text field */
      navigator.clipboard.writeText(copyText.value);

      /* Alert the copied text */
      // alert( copyText.value);
    },
    selectSession(event, cls) {
      this.cbclick(event);
      if (event.target.checked) {
        this.loading = true;
        this.current_timetable_id = cls.id;
        this.current_teacher_id = cls.teacher_id;

        this.getStudentNotes();
        this.getAssessmentLists();
        this.getStudyResourcesList();
        this.getStudentResponse();
        this.getTeacherStudyResources();
      }
    },
    nextPage() {
      this.getClassesList(this.paginationCurrent);
    },
    menuClick(type) {
      if (type == "new" && this.isNewClicked == true) {
        return;
      }
      if (this.clickedTab == type) {
        return;
      }
      this.paginationCurrent = 1;
      this.assessmentLists = [];
      if (type == "new") {
        this.isPreviousClicked = false;
        this.isNewClicked = true;
      } else {
        this.isNewClicked = false;
        this.isPreviousClicked = true;
      }
      this.classRemove();
      this.clickedTab = type;
      console.log("before get assessment");
      this.getClassesList(this.paginationCurrent);
    },
    classRemove() {
      let achors = document.querySelectorAll(".active");
      achors.forEach(function (a) {
        a.classList.remove("active");
      });
    },

    getClassesList(currentPage) {
      
      this.classes = [];
      this.todayClassDetail = "";
      let formData = {};
       if (this.user.roleNames[0]=='parent') {
         formData["parent_id"] = this.user.parent.id;
      }else{
         formData["student_id"] = this.user.student.id;
      }
      if (this.isNewClicked) {
        formData["mode"] = "new";
        formData["timetable_id"] = this.$route.params.allot_class_id;
        axios.post("/api/getStudentClass", formData).then((response) => {
          
          this.zoomLink = response.data.result[0].zoomLink;
          this.classDetails = response.data.result[0];
          this.teacherList = response.data.result[0].teacher;

          this.classes = response.data.result[0];
          
          response.data.result.map((val) => {
            if (val.isToday == "yes") {
              this.todayClassDetail = val;
            }
          }); 

          this.notCompletedSession();
          this.UpcommingSessions();
          this.getTeacherAllNotes();
          this.CompletedSessions();
          this.getStudentNotes();
          this.getAssessmentLists();
          this.getStudyResourcesList();
          // this.getStudentResponse();
          // this.getTeacherStudyResources();
        });
      } else {
        formData["mode"] = "previous";
        formData["timetable_id"] = this.$route.params.allot_class_id;
        axios
          .post("/api/getClassesList" + "?page=" + currentPage, formData)
          .then((response) => {
            this.classDetails = response.data.result.data[0];
            this.teacherList = response.data.result.data[0].student;

            this.classes = response.data.result.data;
            this.paginationCurrent = response.data.result.current_page;
            this.paginationTotal = response.data.result.last_page;

            this.current_timetable_id = this.classes[0].id;
            this.current_teacher_id = this.classes[0].teacher_id;
            this.getStudentNotes();
            this.getAssessmentLists();
            this.getStudyResourcesList();
            this.getStudentResponse();
            this.getTeacherStudyResources();
          });
      }
    },
    cbclick(e) {
      var cb = e.srcElement || e.target;
      let cbxs = document.querySelectorAll(".custom-control-input");
      cbxs.forEach(function (a) {
        if (a.type && a.type == "checkbox" && a.id !== cb.id) {
          a.checked = false;
        }
      });
    },
    selectType(event) {
      this.allowStudent = event.target.checked;
      // this.selectedAccessType = type.name;
      // this.cbclick(event);
    },
    downloadStudyResources(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },
    showDocument(id){
       this.assessmentID = id;
      // location.href =
      //   window.location.origin + "/api/displayFile/" + this.assessmentID;
        window.open(window.location.origin + "/api/displayFile/" + this.assessmentID)
    },
    downloadAssessment(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },
    getStudentResponse() {
      let formData = {};
      if (this.isPreviousClicked) {
        formData["timetable_id"] = this.$route.params.allot_class_id;
        formData["teacher_id"] = this.classDetails.teacher.id;
      } else {
        formData["timetable_id"] = this.$route.params.allot_class_id;
        formData["teacher_id"] = this.classDetails.teacher.id;
      }

      axios.post("/api/getStudentResponse", formData).then((response) => {
        this.studentResponse = response.data.result;
      });
    },
    getStudyResourcesList() {
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      formData["teacher_id"] = this.classDetails.teacher.id;

      formData["mode"] = "student-study-resources";
      axios
        .post("/api/getAssessmentAccordingGrade", formData)
        .then((response) => {
          this.studyResourcesList = response.data.result;
        });
    },
    getAssessmentLists() {
      
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      formData["teacher_id"] = this.classDetails.teacher.id;
      formData["student_id"] = this.user.student.id;
      formData["mode"] = "student";
      axios
        .post("/api/getAssessmentAccordingGrade", formData) 
        .then((response) => {
          
          this.assessmentLists = response.data.result;
        });
    },
    updateTeacherNotes(data) {
      this.teacherNote = data.notes;
      this.currentNoteId = data.id;
      this.isEditClick = true;
      this.allowAddNotes = true;
    },
    deleteTeacherNotes(id) {
      this.currentNoteId = id;
      this.userType = "Teacher Note";
      // this.showStartModel = true;
    },
    openFileUploadDialog(assmList) {
      this.selectAssessment(assmList);
      $("#teacher-assignment-upload").click();
    },
    openNoteUploadDialog() {
      $("#studey_resource_upload").click();
    },
    handleFile(e) {
      e.preventDefault();
      this.assessment_file =
        document.querySelector("input[type=file]").files[0];
      this.showProgress = true;
      this.createAssessment();
    },
    handleStudyResource(e) {
      e.preventDefault();
      this.study_resource_file = e.target.files[0];
      this.addStudyResources();
    },
    addStudyResources() {
      var form = new FormData();
      form.append("assessment_type_id", 1);
      if (this.isPreviousClicked) {
        form.append("timetable_id", this.current_timetable_id);
      } else {
        form.append("timetable_id", this.current_timetable_id);
      }

      form.append("assessment_file", this.study_resource_file);
      form.append("teacher_id", this.current_teacher_id);
      axios.post("/api/addTeacherAssessment", form).then((response) => {
        this.getTeacherStudyResources();
      });
    },
    getTeacherStudyResources() {
      let formData = {};
      if (this.isPreviousClicked) {
        formData["timetable_id"] = this.$route.params.allot_class_id;
        formData["teacher_id"] = this.classDetails.teacher.id;
      } else {
        formData["timetable_id"] = this.$route.params.allot_class_id;
        formData["teacher_id"] = this.classDetails.teacher.id;
      }
      axios.post("/api/teacherStudyResources", formData).then((response) => {
        this.loading = false;
        this.teacherStudyResources = response.data.result;
      });
    },
    clickAddNotes() {
      this.allowAddNotes = !this.allowAddNotes;
    },
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
    sessionNotSelect() {
      this.$toast.open({
        message: "Please Select Session",
        type: "error",
        duration: 5000,
        dismissible: true,
      });
    },
    saveTeacherNotes(e) {
      e.preventDefault();

      let formData = {};
      formData["notes"] = this.teacherNote;
      formData["timetable_id"] = this.$route.params.allot_class_id;
      formData["teacher_id"] = this.classDetails.teacher.id;
      if (this.allowStudent == true) {
        this.selectedAccessType = "public";
      } else {
        this.selectedAccessType = "private";
      }
      formData["access_type"] = this.selectedAccessType;

      this.allowAddNotes = false;
      this.showNoteModel = false;

      if (this.isEditClick) {
        formData["id"] = this.currentNoteId;
        formData["mode"] = "edit";
        axios.post("/api/addTeacherNote", formData).then((response) => {
          this.getTeacherAllNotes();
          this.teacherNote = "";
        });
      } else {
        formData["mode"] = "no-edit";
        axios.post("/api/addTeacherNote", formData).then((response) => {
          this.getTeacherAllNotes();
          this.teacherNote = "";
        });
      }
      this.isEditClick = false;
      this.allowAddNotes = false;
      this.getStudentNotes();
    },
    getStudentNotes() {
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      formData["teacher_id"] = this.classDetails.teacher.id;

      axios.post("/api/getStudentNotes", formData).then((response) => {
        
        this.studentNotes = response.data.result;
        this.closeModal();
      });
    },
    getTeacherAllNotes() {
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      formData["teacher_id"] = this.classDetails.teacher.id;
      formData["mode"] = 'student';
      axios.post("/api/getTeacherAllNotes", formData).then((response) => {
        this.AllNotes = response.data.result;
        this.closeModal();
      });
    },
    closeModal() {
      this.showStartModel = false;
    },
    confirmDelete() {
      let formData = {};
      formData["id"] = this.currentNoteId;
      axios.post("/api/deleteTeacherNotes", formData).then((response) => {
        this.showStartModel = false;
        this.getStudentNotes();
      });
    },
    getTeacherClass() {
      let formData = {};
      formData["timetable_id"] = this.$route.params.allot_class_id;
      axios.post("/api/getTeacherClass", formData).then((response) => {
        this.paginationCurrent = response.data.result.current_page;
        this.paginationTotal = response.data.result.last_page;
        this.current_timetable_id = response.data.result.data[0].id;
        this.current_teacher_id = response.data.result.data[0].teacher_id;

        this.classDetails = response.data.result.data[0];
        this.teacherList = response.data.result.data[0].students.student;
        this.getClassesList(this.paginationCurrent);
      });
    },
    async createAssessment() {
  
    var form = new FormData();
      form.append("assessment_id", this.currentAssessmentId);
      form.append("timetable_id", this.$route.params.allot_class_id);
      form.append("student_id", this.user.student.id);
      form.append("assessment_answer_file", this.assessment_file);

      axios.post("/api/addAssessmentSolution", form).then((response) => {
      
        this.getAssessmentLists();
      });

      $("#exampleModalLong").modal("hide");
      this.showProgress = false;
    },
  },
  mounted() {
    this.getClassesList(1);
    // this.getTeacherClass();
  },
  mixins: [formMixins],
};
</script>
