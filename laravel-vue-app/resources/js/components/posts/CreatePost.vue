<script setup>
import { useRouter } from "vue-router";
import { ref } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

const post = ref({});
const router = useRouter();
// validation Rules
const rules = {
    post: {
        post: { required },
        images: { required },
    },
};

const $v = useVuelidate(rules, { post });

const uploadImage = (event) => {
    const file = event.target.files[0];
    console.log(file);
    post.value.images = [...event.target.files];
};
const submitPost = async () => {
    // check the rules before submitting
    $v.value.$touch();
    if ($v.value.$invalid) return;

    try {
        const formData = new FormData();
        formData.append("post", post.value.post);
        if (post.value.images) {
            for (let i = 0; i < post.value.images.length; i++) {
                formData.append(`images[${i}]`, post.value.images[i]);
            }
        }

        await axios.post("/api/posts", formData);
        alert("New Post Created");
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
        <div class="alert alert-danger" v-if="$v.post.post.$error">
            Text is Required
        </div>
        <div class="mb-3">
            <label class="form-label">image</label>
            <input
                type="file"
                class="form-control"
                name="images[]"
                v-on:change="uploadImage"
                multiple
            />
        </div>
        <div class="alert alert-danger" v-if="$v.post.images.$error">
            Image is Required
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
