<template>
  <app-layout title="LEAD" :auth-user="user">
    <template #header>
      <h2>
        <p>
          You do not have access to view this page.
        </p>
      </h2>
    </template>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "ErrorPage.vue",
  components: {
    AppLayout,
  },
  props: {
    user: Object,
  },
}
</script>

<style scoped>

</style>
