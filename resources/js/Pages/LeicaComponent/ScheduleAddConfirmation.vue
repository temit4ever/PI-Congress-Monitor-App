<template>
  <app-layout title="Schedule" :auth-user="user">
    <template #header>
      <h2>
        Schedule
      </h2>
    </template>
    <AddEditConfirmation
      :path="path"
      :name="name"
      :redirect="redirect"
      :last-text="last_text"
      :referer="referer"
    />
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import AddEditConfirmation from "./Confirmation/AddEditConfirmation";
import {usePage} from "@inertiajs/inertia-vue3";
export default {
  name: "ScheduleAddConfirmation.vue",
  components: {
    AppLayout,
    AddEditConfirmation
  },
  props: {
    referer: String,
    user: Object,
  },
  data() {
    return {
      path: route().current() ? route().current() : 'schedule.index',
      redirect: usePage().props.value.url[1] === 'schedule' ? 'calendar.index' : 'manage_engagement.index',
      name: 'Schedule',
      last_text: ' added',
    }
  },
}
</script>

<style scoped>

</style>
