<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const product = ref({});
const router = useRouter();
const submit = async () => {
    try {
        await axios.post("/api/products", product.value);
        // console.log("res", res);
        router.push({ name: "index" });
    } catch (err) {
        console.log(err);
    }
};
</script>
<template>
    <h2>Add New Product</h2>
    <form @submit.prevent="submit">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                class="form-control"
                name="name"
                placeholder="Product's Name"
                v-model="product.name"
            />
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea
                name="description"
                class="form-control"
                rows="3"
                v-model="product.description"
            ></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input
                name="price"
                type="number"
                class="form-control"
                v-model="product.price"
            />
        </div>
        <!-- <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input name="image" type="file" /><br />
        </div> -->
        <div class="form-group">
            <button type="submit" class="btn btn-success">
                Create New Product
            </button>
            <router-link to="/" class="btn btn-primary float-right"
                >Go Back</router-link
            >
        </div>
    </form>
</template>
