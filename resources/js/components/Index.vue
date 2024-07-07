<script setup>
import {onMounted, ref} from 'vue';
import Dropzone from 'dropzone';

const dropzoneElement = ref(null);
let dropzone = null;
const title = ref('');
const post = ref([]);

const content = ref('');

const store = async () => {
    try {
        const data = new FormData();
        data.append('title', title.value);
        const files = dropzone.getAcceptedFiles();
        files.forEach(file => {
            data.append('images[]', file);
        });
        await axios.post('/api/posts/store', data);
        await getPosts();
    } catch (error) {
        console.error('Error while storing post:', error);
    } finally {
        title.value = '';
        dropzone.removeAllFiles();
    }
};

const getPosts = async () => {
    try {
        const res = await axios.get('/api/posts');
        post.value = res.data.data;
    } catch (error) {
        console.error('Error while get Posts:', error);
    }
};

const handleImageAdded = async (file, Editor, cursorLocation, resetUploader) => {
    try {
        const formData = new FormData();
        formData.append("image", file);

        const result = await axios.post('/api/posts/images/store', formData);
        const url = result.data.url;
        Editor.insertEmbed(cursorLocation, "image", url);
        resetUploader();
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    getPosts();
    dropzone = new Dropzone(dropzoneElement.value, {
        url: "/api/posts/store",
        autoProcessQueue: false,
        addRemoveLinks: true,
    });
});
</script>

<template>
    <div class="container col-4">
        <input type="text" v-model="title" class="form-control mb-3" placeholder="Title">
        <div ref="dropzoneElement" class="p-5 d-block btn btn-dark mb-3">
            Upload image
        </div>
        <div class="mb-3">
            <vue-editor
                useCustomImageHandler
                @image-added="handleImageAdded"
                v-model="content">
            </vue-editor>
        </div>
        <input @click.prevent="store" type="submit" value="Upload" class="btn btn-primary">
    </div>
    <div class="col-3 mt-5">
        <div v-if="post">
            <h4>{{ post.title }}</h4>
            <div v-for="image in post.images" :key="image" class="mt-3">
                <img :src="image.preview_url" alt="img" class="mb-3"/>
                <img :src="image.url" alt="img">
            </div>
        </div>
    </div>
</template>
