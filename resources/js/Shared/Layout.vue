<template>
  <main>
    <header
      class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar-main"
    >
      <inertia-link class="navbar-brand" href="/">Locations</inertia-link>
    </header>
    <article>
      <slot />
    </article>
  </main>
</template>
<style>
.navbar-main {
  position: sticky;
  top: 0;
  z-index: 1;
  display: flex;
  justify-content: space-between;
}
</style>