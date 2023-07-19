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
            </tr>
        </thead>
        <tbody>
            <tr v-for="post in posts" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.post }}</td>
                <div>
                    <td v-for="image in post.images" :key="image.id">
                        {{ image.image_url }}
                    </td>
                </div>
            </tr>
        </tbody>
    </table>
</template>
