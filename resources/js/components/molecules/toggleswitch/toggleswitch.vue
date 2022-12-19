<template>
  <div>
    <label class="switch">
      <input
        type="checkbox"
        id="togBtn"
        @change="handleSwitch"
        :checked="checkStatus == 'true' ? true : false"
      />
      <div class="slider round">
        <!--ADDED HTML -->
        <span class="on">ENABLE</span>
        <span class="off">DISABLE</span>
        <!--END-->
      </div>
    </label>
  </div>
</template>

<script>
import formMixins from "../../../Mixins/form";
import "./style.css";
export default {
  data: function () {
    return {};
  },
  props: {
    userType: String,
    userId: String,
    checkStatus: String,
  },
  methods: {
    handleSwitch(e) {
      let obj = {
        status:'',
        userId:''
      }
      if(e.target.checked==true){
        obj={
          status:0,
          userId:this.userId
        }
        this.changeStatus(obj);
      }else{
        obj={
          status:1,
          userId:this.userId
        }
        this.changeStatus(obj);
      }
    },
    changeStatus(status) {
      this.$emit("change-stuatus",status);
    },
  },
  mounted() {},
  mixins: [formMixins],
};
</script>
