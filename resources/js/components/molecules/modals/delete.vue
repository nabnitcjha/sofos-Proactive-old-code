<template>
    <div class="deletemodal__page">
        <vs-modal v-model="showDeleteModel" class="modal-ac">
            <div slot="modal-header" class="modal-header">
                <span class="hp-3-title">Delete 
                    <!-- &nbsp;<span class="delete__modal--user-name">{{userType}}</span> -->
                </span>
                <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
            </div>
            <div slot="modal-body" class="modal-body">
                Are you sure You want to delete &nbsp;<span class="delete__modal--user-name">{{userType}}</span> ?
            </div>
            <div slot="modal-footer" class="modal-footer">
                <v-btn class="cancel_btn" @click="modalClose">
                    Cancel
                </v-btn>
                <v-btn
                    color="red"
                    class="btn btn-danger delete_btn"
                    @click="deleteData"
                >
                    Delete
                </v-btn>
            </div>
        </vs-modal>
    </div>
</template>
<script>
import "./style.css";
export default {
    props: {
        showDeleteModel: Boolean,
        userType: String,
    },
    methods:{
        deleteData(){
             this.$emit('confirm-delete');
        },
        modalClose(){
             this.$emit('close-modal');
        }
    }
};
</script>
