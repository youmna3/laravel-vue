<template>
    <h2>Add New Product</h2>
    <form>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                class="form-control"
                name="name"
                placeholder="Product's Name"
            />
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea
                name="description"
                class="form-control"
                rows="3"
            ></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input name="price" type="number" class="form-control" />
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
<script></script>
