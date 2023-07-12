<script setup>
import { onMounted, ref } from "vue";
let products = ref([]);
onMounted(async () => {
    getProducts();
});
const getProducts = async () => {
    const res = await axios.get("/api/products");
    console.log("res", res);
};
</script>
<template>
    <h4>List Of Products:</h4>
</template>
