<script setup>
import {onMounted, ref, nextTick} from 'vue';
import Dropzone from 'dropzone';

const dropzoneElement = ref(null);

let dropzoneInstance = null;

onMounted(async () => {
    await nextTick();
    dropzoneInstance = new Dropzone(dropzoneElement.value, {
        url: "someUrl",
    });
});
</script>

<template>
    <div class="container col-3">
        <h2>Index Vue</h2>
        <div ref="dropzoneElement" class="p-5 d-block btn btn-dark">
            Upload file
        </div>
    </div>
</template>

<style scoped>
</style>
