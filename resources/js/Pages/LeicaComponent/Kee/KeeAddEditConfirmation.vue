<template>
  <app-layout title="User" :auth-user="user">
    <template #header>
      <h2>
        Kee
      </h2>
      <p>
        Add / Edit / Delete KEE
      </p>
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
  name: "KeeAddEditConfirmation.vue",
  components: {AddEditConfirmation, AppLayout},
  data() {
    return {
      path: route().current(),
      redirect: 'manage_kee.index',
      name: 'kee',
      last_text: ' added',
    }
  },
  props: {
    user: Object,
  }
}
</script>

<style scoped>

</style>
