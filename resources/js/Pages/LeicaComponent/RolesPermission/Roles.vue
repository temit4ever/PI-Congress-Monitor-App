<template>
  <app-layout title="Users">
    <template #header>
      <h2>
        Roles
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>
    <div class="card card--narrow">
      <div class="card__heading">
        <h2 class="card__title">
          Roles Table
        </h2>
      </div>
      <div class="table-border-container">
        <table class="table table--border">
          <thead>
          <th>ID</th>
          <th>Name</th>
          </thead>
          <tbody>
          <template v-for="role in roles.data" :key="role.id">
            <tr>
              <td>
                {{ role.id}}
              </td>
              <td>
                {{ role.name}}
              </td>
            </tr>
          </template>
          </tbody>
        </table>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "Roles.vue",
  components: {
    AppLayout
  },
  props: {
    roles: Object,
  }
}
</script>

<style scoped>

</style>
