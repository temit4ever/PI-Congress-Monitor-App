<template>
  <app-layout title="Engagement" :auth-user="user">
    <template #header>
      <h2>
       Engagement
      </h2>
    </template>
    <engagement-form
        :countries="countries"
        :cities="cities"
        :engagement="engagement"
        :edit-Path="editPath"
        :kees="kees"
        :errors="errors"
        />
  </app-layout>
</template>

<script>
import EngagementForm from "./EngagementForm";
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "EngagementHeader.vue",
  components: {EngagementForm, AppLayout},
  props: {
    countries: Array,
    cities: Array,
    engagement: Array,
    editPath: Boolean,
    kees: Array,
    user: Object,
    errors: Object,
  },
  data() {
    return {
      path: false

    }
  }
}
</script>

<style scoped>

</style>
