<template>
  <app-layout title="Evaluation" :auth-user="user">
    <template #header>
      <h2>
        Evaluation
      </h2>
    </template>
    <AddEditConfirmation
      :path="path"
      :name="name"
      :redirect="redirect"
      :last-text="last_text"
    />
  </app-layout>
</template>
<script>
import AppLayout from "../../../Layouts/AppLayout";
import AddEditConfirmation from "../Confirmation/AddEditConfirmation";
export default {
  name: "RankAddEditConfirmation.vue",
  components: {
    AppLayout,
    AddEditConfirmation
  },
  props: {
    user: Object,
  },
  data() {
    return {
      path: route().current(),
      redirect: 'manage_completed.index',
      name: 'Evaluation',
      last_text: ' completed',
    }
  }
}
</script>

<style scoped>

</style>
