<template>
  <app-layout title="LEAD">
    <template #header>
      <h2>
        <p>
          The user you are looking for does not exist.
        </p>
      </h2>
    </template>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "UserNotFound.vue",
  components: {AppLayout},
}
</script>

<style scoped>

</style>
