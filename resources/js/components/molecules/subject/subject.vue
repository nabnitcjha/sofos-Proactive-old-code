<template>
  <div class="row add-subject card-common-design">
    <div class="col-lg-12 detail-card">
      <div class="card mb-4 subject-info col-lg-12">
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
          <h6 class="m-0 text-primary">Add Subject</h6>
          
          <button
                type="button"
                class="btn btn-orange ml-2"
                @click="goBack"
              >
                Back
              </button>
        </div>
        <div class="card-body col-lg-12">
          <form>
            <div class="form-group col-sm-6 col-lg-3">
              <label for="subjectName">Subject Name</label>
              <input
                v-model="subject.name"
                type="text"
                class="form-control"
                id="subjectName"
                placeholder="First Name"
              />
            </div>
            <div class="form-group col-3 btn-vertical-align">
              <button
                type="button"
                class="btn btn-success"
                @click="updateSubject"
                v-if="titleInfo.pageType == 'edit'"
              >
                Update
              </button>
              <button
                type="button"
                class="btn btn-success"
                @click="addNewSubject"
                v-else
              >
                Save
              </button>
              <button
                type="button"
                class="btn btn-danger ml-2"
                @click="cancelSubjectRecord"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import {
  ArrowLeft
} from "../../../Assets/formIcons/index";
import formMixins from "../../../Mixins/form";
import formTitle from "../common/formTitle";
import "../style.css";
export default {
  data() {
    return {
      ArrowLeft:ArrowLeft,
      subject: {
        name: "",
      },
    };
  },
  props: {
    titleInfo: Object,
  },
  components: {
    "form-title": formTitle,
  },
  methods: {
    cancelSubjectRecord(){
      this.subject.name ="";
    },
    updateSubject() {
      if(this.subject.name==""){
        this.textValidation('Subject is empty');
        return;
      }
      let y = this.$route.params.id;
      this.updateRecord("subject", this.subject, this.$route.params.id,"/subject");
    },
    addNewSubject() {
      if(this.subject.name==""){
        this.textValidation('Subject is empty');
        return;
      }
      this.addRecord("subject", this.subject, "/subject");
    },
    async getData() {
      let frmData = [];
      frmData = await this.getSpecificRecord("subject", this.$route.params.id);
      this.subject.name = frmData[0].name;
    },
  },
  mounted() {
    this.getData();
  },
  mixins: [formMixins],
};
</script>
<style>
.subject .v-application--wrap {
  min-height: unset !important;
}
</style>