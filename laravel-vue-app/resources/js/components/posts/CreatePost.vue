<script setup>
import { useRouter } from "vue-router";
import { ref } from "vue";
const post = ref({});
const router = useRouter();

const submitPost = async () => {
    try {
        await axios.post("/api/posts", post.value);
        // alert("New Post Created");
        // navigate back to posts page after creating a new one successfully
        router.push({ name: "post.index" });
    } catch (err) {
        console.log(err.response.data);
    }
};
</script>
<template>
    <h2>Add New Post</h2>
    <form @submit.prevent="submitPost" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Post</label>
            <textarea
                type="text"
                class="form-control"
                name="Post"
                placeholder="Add new Post"
                v-model="post.post"
            ></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">image</label>
            <input
                type="text"
                class="form-control"
                name="images[]"
                v-model="post.images"
            />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">
                Create New Product
            </button>
        </div>
        <div class="form-group">
            <router-link to="/posts" class="btn btn-primary float-right"
                >Go Back</router-link
            >
        </div>
    </form>
</template>
