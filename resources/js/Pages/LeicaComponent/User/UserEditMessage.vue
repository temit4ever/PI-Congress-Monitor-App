<template>
  <app-layout title="Users" :auth-user="user">
    <template #header>
      <h2>Users</h2>
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
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "UserEditMessage.vue",
  components:{
    AppLayout
  },
  props: {
    user: Object,
  }
}
</script>

<style scoped>

</style>
