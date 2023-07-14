<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";

const product = ref({});
const router = useRouter();
const route = useRoute();

const updateProduct = async () => {
    try {
        const id = route.params.id;

        await axios.put(`/api/products/${id}`, product.value);

        router.push({ name: "index" });
    } catch (err) {
        console.log(err);
    }
};
</script>
<template>
    <h2>Edit Product</h2>

    <form @submit.prevent="updateProduct()">
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
            <button type="submit" class="btn btn-success">Edit Product</button>
            <router-link to="/" class="btn btn-primary float-right"
                >Go Back</router-link
            >
        </div>
    </form>
</template>
