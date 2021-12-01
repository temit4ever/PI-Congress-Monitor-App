<template>
  <app-layout title="User" :auth-user="user">
    <template #header>
      <h2>
        User
      </h2>
      <p>
        Add / Edit / Delete AstraZeneca users
      </p>
    </template>
    <AddEditConfirmation
      :path="path"
      :name="name"
      :redirect="redirect"
      :last-text="last_text"
      :user="user"
    />
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import AddEditConfirmation from "../Confirmation/AddEditConfirmation";

export default {
  name: "AdminProfileEditConfirmation.vue",
  components: {AddEditConfirmation, AppLayout},
  props: {
    user: Object
  },
  data() {
    return {
      path: route().current(),
      redirect: 'user.index',
      name: 'Admin Profile',
      last_text: ' edited'
    }
  }

}
</script>

<style scoped>

</style>
