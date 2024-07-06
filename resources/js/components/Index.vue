<script setup>
import {onMounted, ref} from 'vue';
import Dropzone from 'dropzone';

const dropzoneElement = ref(null);
let dropzone = null;
const title = ref('');

const store = async () => {
    try {
        const images = new FormData();
        const files = dropzone.getAcceptedFiles();
        files.forEach(file => {
            images.append('images[]', file);
        });
        await axios.post('/api/posts/store', images);
    } catch (error) {
        console.error('Error while storing post:', error);
    }
};


onMounted(() => {
    dropzone = new Dropzone(dropzoneElement.value, {
        url: "/api/posts/store",
        autoProcessQueue: false,
    });
});
</script>

<template>
    <div class="container col-3">
        <input type="text" v-model="title" class="form-control mb-3" placeholder="Title">
        <div ref="dropzoneElement" class="p-5 d-block btn btn-dark mb-3">
            Upload image
        </div>
        <input @click.prevent="store" type="submit" value="Upload" class="btn btn-primary">
    </div>
</template>
