<template>
    Recommend to user:
    <div v-for="user in userList" v-bind:key="user">
        <div @click="() => sendRecommend(user)" class="user-select px-1">
            {{ user.email }}
        </div>
    </div>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
    props: {
        userList: Array,
    },
    setup(props) {
        const { userList } = toRefs(props);

        const sendRecommend = (user) => {
            console.log(user);
        };

        return { userList, sendRecommend };
    },
};
</script>

<style scoped>
.user-select {
    cursor: pointer;
}
.user-select:hover {
    color: white;
    background-color: darkgrey;
}
</style>
