<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

const product = ref({});
const router = useRouter();

const rules = {
    product: {
        name: { required },
        description: { required },
        price: { required },
        images: { required },
    },
};

const $v = useVuelidate(rules, { product }, {});
const onFileChange = (event) => {
    product.value.images = [...event.target.files];
};
const submit = async () => {
    $v.value.$touch();
    if ($v.value.$invalid) return;

    try {
        await axios.post("/api/products", product.value, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
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
                name="image"
                type="file"
                class="form-control"
                v-on:change="onFileChange"
                multiple
            />
        </div>
        <div class="alert alert-danger" v-if="$v.product.images.$error">
            Image is required
        </div>

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
