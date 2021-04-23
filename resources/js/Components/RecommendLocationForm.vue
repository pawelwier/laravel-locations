<template>
    Recommend to user:
    <div v-for="user in userList" v-bind:key="user">
        <div
            @click="() => selectUser(user.id)"
            class="user-select px-1"
            :class="{ 'selected-user': selectedUserId == user.id }"
        >
            {{ user.email }}
        </div>
    </div>
    <input class="form-control my-3" type="text" v-model="messageText" />
    <button class="btn btn-primary" @click="sendRecommend">Send</button>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref, toRefs, computed } from "vue";

export default {
    props: {
        userList: Array,
        locationId: Number,
    },
    setup(props) {
        const { userList, locationId } = toRefs(props);
        const userInfo = computed(() => usePage().props.value.user_info);

        const selectedUserId = ref(null);
        const messageText = ref("");

        const sendRecommend = () => {
            const req = {
                target_user: selectedUserId.value,
                user_id: userInfo.value.id,
                location_id: locationId.value,
                message: messageText.value,
            };
            console.log(req);
            Inertia.post("/recommendations", req);
        };

        const selectUser = (id) => {
            selectedUserId.value = id;
        };

        return {
            messageText,
            userList,
            sendRecommend,
            selectUser,
            selectedUserId,
            userInfo,
        };
    },
};
</script>

<style scoped>
.user-select {
    cursor: pointer;
}

.selected-user {
    background-color: dodgerblue;
    color: white;
}

.user-select:hover {
    color: white;
    background-color: darkgrey;
}
</style>
