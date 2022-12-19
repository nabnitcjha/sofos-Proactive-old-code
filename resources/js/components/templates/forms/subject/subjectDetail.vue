<template>
    <div class="row card-common-design detail-page">
      <delete-modal
        @confirm-delete="confirmDelete"
        @close-modal="closeModal"
        :showDeleteModel="showDeleteModel"
        :userType="userType"
      ></delete-modal>
      <div class="col-12 make-right">
      <button
                type="button"
                class="btn btn-orange ml-2"
                @click="goBack"
              >
                Back
              </button>
          
        </div>
      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-12">
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">General Information</h6>
            <div>
              <span
                @click.stop="$root.changeRoute('/edit-subject/' + $route.params.id)"
                class="pointer-hand"
                ><i class="far fa-edit" style="color: #8bc34a"></i></span
              >&nbsp;
            </div>
          </div>
          <div class="card-body col-lg-12">
            <form class="detail-form">
              <div class="form-group col-sm-6 col-lg-4">
                <label for="teacherFullName">Subject Name</label>
                <span
                  style="border: none; padding-left: 0; font-size: 14px"
                  class="form-control"
                  id="teacherFullName"
                  >{{ subject.name }}</span
                >
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- associated subjects -->
  
      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-12">
          <div class="card-header py-3 align-items-center card-header-mobo">
            <h6 class="m-0 font-weight-bold text-left col-lg-3">
              Associated Teacher
            </h6>
          </div>
          <div class="card-body col-lg-12">
            <div class="form-group col-sm-6 col-lg-4">
              <!-- <label for="meetWith">Teachers</label> -->
              <div class="student-list" v-if="teachers.length>0">
                <span
                  class="form-control custom-border remove-border"
                  v-for="(tec, index) in teachers"
                  :key="index"
                >
                  {{ tec.first_name }}{{ " " }}{{ tec.last_name }}
                  {{ index + 1 == teachers.length ? "" : " , " }}
                </span>
              </div>
              <div class="col-12" v-else>
                <p
              class="table-null"
            >
              No record found
            </p>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      <div class="col-sm-6 col-lg-12 text-justify">
          <button
            type="button"
            class="btn btn-danger pointer-hand"
            @click.stop="deleteData($route.params.id, subject.name)"
          >
            Delete
          </button>
        </div>
    </div>
  </template>
  
  <script>
  import vPagination from "vue-plain-pagination";
  import formMixins from "../../../../Mixins/form";
  import deleteModal from "../../../molecules/modals/delete.vue";
  export default {
    data: function () {
      return {
        teachers:[],
        subject:"",
        deleteId: "",
        showDeleteModel: false,
        userType: "",
      };
    },
  
    components: {
      vPagination,
      "delete-modal":deleteModal
    },
    methods: {
      closeModal() {
        this.showDeleteModel = false;
      },
      async confirmDelete() {
         await this.deleteRecord("subject", this.deleteId);
        this.closeModal();
          this.$router.go(-1);
      },
      deleteData(id, userType) {
        this.deleteId = id;
        this.userType = userType;
        this.showDeleteModel = true;
      },
      getTeacherSubject() {
        
        let formData = {};
        formData["subject_id"] = this.$route.params.id;
        axios.post("/api/getSubjectTeacher", formData).then((response) => {
            
          this.teachers = response.data.teachers;
          this.subject = response.data.subject;
        });
      },
    },
    mounted() {
      
      this.getTeacherSubject();
    },
    mixins: [formMixins],

  };
  </script>
  <style>
  .basil {
    background-color: #fff !important;
  }
  
  .basil--text {
    color: #8bc34a !important;
    font-size: 29px !important;
  }
  .teacher__form--name {
    color: #ff9800 !important;
    font-size: 29px !important;
    text-transform: capitalize;
  }
  </style>
  