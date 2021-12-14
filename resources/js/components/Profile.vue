<template>
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <div v-if="image == null" class="profile-user-img img-circle d-flex align-items-center justify-content-center" style="height: 100px;">
                    <i class="fas fa-user" style="font-size: 60px; color: #ccc;"></i>
                </div><!-- profile-user-img -->
                <img v-if="image != null" class="profile-user-img img-fluid img-circle" :src="image" alt="User profile picture">
            </div><!-- text-center -->

            <h3 class="profile-username text-center">{{ name }}</h3>

            <p class="text-muted text-center">{{ type }}</p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item" v-for="d, key in data" :key="key">
                    <b>{{ d.title }}</b> <span class="float-right text-primary">{{ d.value }}</span>
                </li><!-- list-group-item -->
            </ul><!-- list-group -->
        </div> <!-- card-body -->
    </div><!-- card -->
</template>

<script>
    export default {
        props: ['data', 'type', 'name', 'image']
    }
</script>