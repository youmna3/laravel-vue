<script setup>
import { useRouter } from "vue-router";
const router = useRouter();
</script>
<template>
    <h2>Add New Post</h2>
    <form enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Post</label>
            <textarea
                type="text"
                class="form-control"
                name="Post"
                placeholder="Add new Post"
            ></textarea>
        </div>
        <router-link to="/posts" class="btn btn-primary float-right"
            >Go Back</router-link
        >
    </form>
</template>
