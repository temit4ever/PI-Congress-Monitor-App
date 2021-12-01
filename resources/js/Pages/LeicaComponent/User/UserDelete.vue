<template>
  <app-layout title="Users" :auth-user="user">
    <template #header>
      <h2>
        LEAD Dashboard
      </h2>
      <p>
        Add / Edit / Delete AstraZeneca users
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          User Profile
        </h2>
      </div>
    </div>
    <DeleteConfirmation />
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import DeleteConfirmation from "../Confirmation/DeleteConfirmation";
export default {
  name: "UserDelete.vue",
  components: {
    DeleteConfirmation,
    AppLayout
  },
  props: {
    user:Object,
  }
}
</script>

<style scoped>

</style>
