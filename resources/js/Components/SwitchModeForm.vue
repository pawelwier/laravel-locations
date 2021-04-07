<template>
    <form @submit.prevent="console.log('ok')" @change="onTypeChanged">
        <input
            type="radio"
            name="type"
            id="details"
            value="displayLocationDetails"
        />
        <label for="details">Details</label><br />
        <input
            type="radio"
            name="type"
            id="distance"
            value="calculateDistance"
        />
        <label for="distance">Distance</label><br />
    </form>
</template>

<script>
export default {
    props: {},
    emits: ["type-updated"],
    setup(_, context) {
        const onTypeChanged = (e) => {
            context.emit("type-updated", e);
        };

        return { onTypeChanged };
    },
};
</script>

<style></style>
