<template>
    <div class="imageUpload__page">
          <figcaption style="margin-top: -0.5em;">
                            <figure v-if="userImage">
                                <img
                                    class="img-fluid"
                                    :src="$root.getMedia(userImage.id)"
                                    alt=""
                                    @click="openImageBrowser"
                                />
                            </figure>
                            <figure
                                class="no-image"
                                v-else
                                @click="openImageBrowser"
                            >
                                <i class="fa fa-camera"></i>
                            </figure>
                            <label
                                for="cover-upload"
                                class="custom-file-upload"
                                id="image-upload-from-label"
                            >
                                <i class="fa fa-pen"></i>
                            </label>
                            <input
                                ref="imgfile"
                                type="file"
                                @change="handleFile"
                                name="user_image"
                                accept="image/*"
                                id="cover-upload"
                                style="visibility:hidden"
                            />
                        </figcaption>
    </div>
</template>

<script>
import "./atom-common.css";
export default {
    data: function() {
        return {

        };
    },
    props:{
        userImage:{
            type:Boolean,
            default:()=>{}
        }
    },
    methods:{
         openImageBrowser() {
            $("#image-upload-from-label").click();
        },
         handleFile() {
            this.$emit("handle-file", this.$refs.imgfile.files[0]);
        },
    }
};
</script>
