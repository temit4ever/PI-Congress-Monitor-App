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
  name: "UserAddEditConfirmation.vue",
  components: {AddEditConfirmation, AppLayout},
  props: {
    user: Object,
    updated_id: String
  },
  data(props) {
    return {
      path: route().current(),
      redirect: 'user.index',
      name: 'User',
      last_text: ' added'
    }
  }
}
</script>

<style scoped>

</style>
