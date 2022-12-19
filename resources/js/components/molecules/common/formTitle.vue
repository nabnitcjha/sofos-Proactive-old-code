<template>
    <div v-bind:class="['formTitle__page', titleInfo.pageType == 'chat' ? 'form__title--chat' : ' ']">
        <div  v-if="titleInfo.actionName == 'Back'" >
             <div class="form-page-tile" v-if="titleInfo.pageType !='chat'">{{ titleInfo.pageTitle }}</div>
              <div v-if="titleInfo.actionName == 'Back'" v-bind:class="['', titleInfo.pageType == 'chat' ? 'back-from-chat' : ' ']" >
                <a @click="$router.go(-1)" class="btn btn-sm btn-cstm">
                    <i :class="titleInfo.logo" aria-hidden="true" style="color:#4e4e4e;"> </i
                ></a>
            </div>
        </div>
       <div class="form-page-tile" v-if="titleInfo.pageType !='chat' && titleInfo.actionName != 'Back'">{{ titleInfo.pageTitle }}</div>
        <div class="form-action-name" v-if="titleInfo.allowAction && titleInfo.actionName != 'Back'">
           <button class="btn btn-lg btn-success col-xs-12"  @click="$root.changeRoute(titleInfo.routeUrl)"
                :style="`color:${titleInfo.btnTxtColor}; background-color:${titleInfo.btnBackColor}`"
                v-if="checkPermission(['create'])"
                >
                    <img
                        class="action-logo"
                        :src="titleInfo.logo"
                        v-if="titleInfo.logoType == 'svg'" 
                    />
                    <i
                        :class="titleInfo.logo"
                        aria-hidden="true"
                        v-if="titleInfo.logoType == 'icon'" 
                    ></i>
                    {{ titleInfo.actionName }} 
                </button>
        </div>
    </div>
</template> 

<script>
import "./molecule-common.css";
import { mapGetters } from "vuex";
export default {
    data: function() {
        return {};
    },
    props: {
        titleInfo: Object
    },
    computed: {
        ...mapGetters({
            permissions:'permissions'
        })
    },
    methods:{
        checkPermission(arr){
           let boolValue = this.permissions.some(permission => {
               return arr.includes(permission);
           });
        
           return boolValue;
        },
    },
};
</script>
