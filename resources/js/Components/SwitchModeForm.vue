<template>
    <form @change="onTypeChanged" class="mode-form">
        <div class="modes-label">Modes:</div>
        <div
            class="btn-group"
            role="group"
            aria-label="Basic radio toggle button group"
        >
            <input
                class="btn-check"
                type="radio"
                name="type"
                id="details"
                value="displayLocationDetails"
            />
            <label class="btn btn-outline-primary" for="details">Details</label>

            <input
                class="btn-check"
                type="radio"
                name="type"
                id="distance"
                value="calculateDistance"
            />
            <label class="btn btn-outline-primary" for="distance"
                >Distance</label
            >
        </div>
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

<style>
.mode-form {
    display: flex;
    align-items: center;
}
.modes-label {
    font-size: 1.1em;
    font-weight: 700;
    margin-right: 0.4rem;
}
</style>
