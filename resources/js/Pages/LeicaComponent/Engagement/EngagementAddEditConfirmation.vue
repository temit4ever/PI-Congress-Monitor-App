<template>
  <app-layout title="Engagement" :auth-user="user">
    <template #header>
      <h2>
       Engagement
      </h2>
      <p>
        Add / Edit / Delete KEE engagements
      </p>
    </template>
    <AddEditConfirmation
      :path="path"
      :name="name"
      :redirect="redirect"
      :last-text="last_text"
    />
  </app-layout>
  <DeleteConfirmation />
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import AddEditConfirmation from "../Confirmation/AddEditConfirmation";
import DeleteConfirmation from "../Confirmation/DeleteConfirmation";
export default {
  name: "EngagementAddEditConfirmation.vue",
  components: {
    AppLayout,
    AddEditConfirmation,
    DeleteConfirmation,
  },
  props: {
    user: Object,
  },
  data() {
    return {
      path: 'manage_engagement.store',
      redirect: this.path === 'manage_engagement.index' ? 'manage_engagement.index' : 'manage_engagement.index',
      name: 'Engagement',
      last_text: ' added',
    }
  }
}
</script>

<style scoped>

</style>
