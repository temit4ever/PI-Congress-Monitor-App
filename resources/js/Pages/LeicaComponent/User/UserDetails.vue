<template>
  <app-layout title="Users" :auth-user="user">
    <template #header>
      <h2>
      User
      </h2>
      <p>
        Add / Edit / Delete AstraZeneca users
      </p>
    </template>

    <div class="card card--narrowest card--center">
      <div class="card__heading">
        <h2 class="card__title">
          User Profile
        </h2>
        <div class="card__heading-button">
          <span v-if="user_details">
          <a :href="route('user.edit', {id: user_details.id})" class="button button--small">
            Edit User
          </a>
          </span>
        </div>
      </div>
      <div v-if="user_details" class="card__inner">
        <div class="profile-image">
          <img v-if="user_details.profile_photo_path !== 'placeholder-profile.jpg'" :src="user_details.profile_photo_path">
          <img v-else src="../../../../images/placeholder-profile.jpg">
        </div>
        <div class="card__content">
          <p>{{user_details.title}} {{user_details.firstname}} {{user_details.lastname}}</p>
          <p>{{user_details.email}}</p>
          <h2>{{user_details.roles[0].name}}</h2>
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
    user_details: Object,
  },
}
</script>

<style scoped>

</style>
