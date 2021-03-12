<template>
    <div
        class="popup-marker"
        v-bind:style="{ top: position.y + 'px', left: position.x + 'px' }"
    >
        {{ text }}
    </div>
</template>

<script>
export default {
    name: "PopupMarker",
    data() {
        return {
            position: {
                x: null,
                y: null,
            },
            text: null,
        };
    },
    methods: {
        setPositionContent(x, y, text) {
            this.position.x = x;
            this.position.y = y;
            this.text = text;
        },
    },
    mounted() {},
};
</script>

<style>
.popup-marker {
    position: absolute;
    z-index: 9999;
    padding: 0.4em;
    background-color: white;
}
</style>
