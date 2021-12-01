<template>
  <app-layout title="LEAD" :auth-user="user">
    <template #header>
      <h2>
        <p>
          The item you are looking for does not exist.
        </p>
      </h2>
    </template>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "ItemNotFound.vue",
  components: {AppLayout},
  props: {
    user: Object,
  }
}
</script>

<style scoped>

</style>
