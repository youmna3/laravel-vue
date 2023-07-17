<script setup>
import { onMounted, ref } from "vue";

let products = ref([]);
onMounted(async () => {
    getProducts();
    // getImages();
});
const getProducts = async () => {
    const res = await axios.get("api/products");
    console.log("res", res);
    products.value = res.data.products;
};
const getImageUrl = (filename) => {
    return `/api/${filename}`;
};
// const getImages = async () => {
//     for (let product of products.value) {
//         for (let image of product.images) {
//             const filename = image.image_url;
//             const img = await axios.get(`api/${filename}`, {
//                 responseType: "blob",
//             });
//             image.imageUrl = URL.createObjectURL(img.data);
//         }
//     }
// };

const deleteProduct = async (id) => {
    try {
        // window.confirm(`Are you sure want to Delete?`);
        await axios.delete(`api/products/${id}`);
        products.value = products.value.filter((product) => product.id !== id);
    } catch (err) {
        console.log(err);
    }
};
</script>
<template>
    <h4>List Of Products:</h4>
    <router-link class="btn btn-success" to="/products/create"
        >Add New Product</router-link
    >
    <hr />
    <table class="table table-striped-columns text-center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Image</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.status }}</td>
                <!-- <div v-for="image in product.images" :key="image.id">
                     <img :src="image.image_url" alt="Product Image" /> -->
                <!-- {{ image.image_url }} -->
                <!-- </div> - -->
                {{
                    console.log(product.images)
                }}

                <td>
                    <!-- <img
                        v-for="image in product.images"
                        :key="image.id"
                        :src="getImages()"
                        alt="image"
                        width="100px"
                    /> -->
                </td>
                <div v-for="image in product.images" :key="image.id">
                    <img
                        :src="getImageUrl(image.image_url)"
                        alt="Product Image"
                        width="100"
                    />
                </div>
                <td>
                    <router-link
                        :to="{ name: 'edit', params: { id: product.id } }"
                        class="btn btn-success"
                        >EDIT</router-link
                    >
                </td>
                <td>
                    <a @click="deleteProduct(product.id)" class="btn btn-danger"
                        >Delete</a
                    >
                </td>
            </tr>
        </tbody>
    </table>
</template>
