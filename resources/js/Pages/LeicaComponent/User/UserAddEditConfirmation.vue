<template>
  <app-layout title="User">
    <template #header>
      <h2>
        User
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>
    <AddEditConfirmation
      :path="path"
      :name="name"
      :redirect="redirect"
    />
    </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import AddEditConfirmation from "../Confirmation/AddEditConfirmation";
export default {
  name: "UserAddEditConfirmation.vue",
  components: {AddEditConfirmation, AppLayout},
  data() {
    return {
      path: route().current(),
      redirect: 'user.index',
      name: 'user'
    }
  }
}
</script>

<style scoped>

</style>
