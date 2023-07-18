<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

const product = ref({});
const router = useRouter();
const route = useRoute();

const rules = {
    product: {
        name: { required },
        description: { required },
        price: { required },
    },
};
const $v = useVuelidate(rules, { product });
const onFileChange = (event) => {
    const file = event.target.files[0];
    console.log(file);
    product.value.images = [...event.target.files];
};
const updateProduct = async () => {
    $v.value.$touch();
    if ($v.value.$invalid) return;
    try {
        const formData = new FormData();
        formData.append("name", product.value.name);
        formData.append("description", product.value.description);
        formData.append("price", product.value.price);
        if (product.value.images) {
            for (let i = 0; i < product.value.images.length; i++) {
                formData.append(`image[${i}]`, product.value.images[i]);
            }
        }
        const id = route.params.id;

        await axios.put(`/api/products/${id}`, formData, {
            headers: {
                "content-type": "multipart/form-data",
            },
        });

        router.push({ name: "index" });
    } catch (err) {
        console.log(err.response.data);
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
        <div class="alert alert-danger" v-if="$v.product.name.$error">
            Name is required
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
        <div class="alert alert-danger" v-if="$v.product.description.$error">
            description is required
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
        <div class="alert alert-danger" v-if="$v.product.price.$error">
            Price is required
        </div>
        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input
                name="image[]"
                type="file"
                v-on:change="onFileChange"
                multiple
            /><br />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Edit Product</button>
            <router-link to="/" class="btn btn-primary float-right"
                >Go Back</router-link
            >
        </div>
    </form>
</template>
