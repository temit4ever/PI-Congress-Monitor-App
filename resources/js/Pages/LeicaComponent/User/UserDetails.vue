<template>
  <app-layout title="Users">
    <template #header>
      <h2>
      User
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card card--narrowest card--center">
      <div class="card__heading">
        <h2 class="card__title">
          User Profile
        </h2>
        <div class="card__heading-button">
          <a :href="route('user.edit', {id: user.id})" class="button">
            Edit User
          </a>
        </div>
      </div>
      <div class="card__inner">
        <img class="profile-image" :src="`${user.profile_photo_path}`">
        <div class="card__content">
          <p>{{user.title}} {{user.firstname}} {{user.lastname}}</p>
          <p>{{user.email}}</p>
          <h2>{{user.roles[0].name}}</h2>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "UserDetails.vue",
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
