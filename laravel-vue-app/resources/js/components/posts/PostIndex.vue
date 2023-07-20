<script setup>
import { onMounted, ref } from "vue";

const posts = ref([]);

onMounted(async () => {
    getPosts();
});

const getPosts = async () => {
    try {
        const res = await axios.get("api/posts");
        console.log("res", res);
        posts.value = res.data.Posts;
    } catch (err) {
        console.log(err.response.data);
    }
};
const getImageUrl = (filename) => {
    return `/api/${filename}`;
};
const deletePost = async (id) => {
    try {
        await axios.delete(`api/posts/${id}`);
        posts.value = posts.value.filter((post) => post.id !== id);
    } catch (err) {
        console.log(err.response.data);
    }
};
</script>
<template>
    <h4>List of Posts</h4>
    <router-link to="/posts/create" class="btn btn-success"
        >Add Post</router-link
    >
    <hr />
    <table class="table table-striped-columns text-center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Post</th>
                <th>Images</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="post in posts" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.post }}</td>
                <div>
                    <td v-for="image in post.images" :key="image.id">
                        <img :src="getImageUrl(image.image_url)" width="100" />
                    </td>
                </div>
                <td>
                    <a @click="deletePost(post.id)" class="btn btn-danger"
                        >Delete</a
                    >
                </td>
            </tr>
        </tbody>
    </table>
</template>
