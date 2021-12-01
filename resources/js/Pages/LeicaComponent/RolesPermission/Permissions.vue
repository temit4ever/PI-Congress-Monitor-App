<template>
  <app-layout title="Users">
    <template #header>
      <h2>
        Permissions
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>
    <div class="card card--narrow">
      <div class="card__heading">
        <h2 class="card__title">
          Permission Table
        </h2>
      </div>
      <div class="table-border-container">
        <table class="table table--border">
          <thead>
          <th>ID</th>
          <th>Name</th>
          </thead>
          <tbody>
          <template v-for="permission in permissions.data" :key="permission.id">
            <tr>
              <td>
                {{ permission.id}}
              </td>
              <td>
                {{ permission.name}}
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
  name: "Permissions.vue",
  components: {
    AppLayout,
  },
  props: {
    permissions: Object
  }

}
</script>

<style scoped>

</style>
