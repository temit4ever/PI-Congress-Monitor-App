<template>
  <app-layout title="Users" :auth-user="user">
    <template #header>
      <h2>
        Admin
      </h2>
      <p>
        Add / Edit / Delete AstraZeneca users
      </p>
    </template>

    <div class="card card--narrowest card--center">
      <div class="card__heading">
        <h2 class="card__title">
          Current Admin Profile
        </h2>
        <div class="card__heading-button">
          <a :href="route('profiles.edit', {id: admin_details.id})" class="button">
            Edit Users
          </a>
        </div>
      </div>
      <div v-if="admin_details" class="card__inner">
        <div class="profile-image">
          <img v-if="admin_details.profile_photo_path !== 'placeholder-profile.jpg'" :src="admin_details.profile_photo_path">
          <img v-else src="../../../../images/placeholder-profile.jpg">
        </div>
        <div class="card__content">
          <p>{{admin_details.title}} {{admin_details.firstname}} {{admin_details.lastname}}</p>
          <p>{{admin_details.email}}</p>
          <h2>{{admin_details.roles[0].name}}</h2>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "AdminProfile.vue",
  components: {
    AppLayout,
  },
  props: {
    user: Object,
    admin_details: Object
  }
}
</script>

<style scoped>

</style>
