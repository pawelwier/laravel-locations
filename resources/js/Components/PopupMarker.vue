<template>
    <div
        class="popup-marker"
        v-bind:style="{ top: position.y + 'px', left: position.x + 'px' }"
    >
        {{ text }}
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    setup() {
        const position = ref({ x: null, y: null });
        const text = ref("");

        const setPositionContent = (x, y, locationText) => {
            position.value.x = x;
            position.value.y = y;
            text.value = locationText;
        };

        return { position, text, setPositionContent };
    },
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
