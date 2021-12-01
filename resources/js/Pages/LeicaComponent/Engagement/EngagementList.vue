<template>
  <app-layout>
    <template #header>
      <h2>
        LEAD Dashboard
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Users
        </h2>
        <div class="card__heading-button">
          <a :href="route('user.create')" class="button">
            Add User
          </a>
        </div>
      </div>
      <table class="table">
        <thead>
        <th>Name</th>
        <th>Date/Time</th>
        <th>Data</th>
        <th>Location</th>
        </thead>
        <tbody>
        <template v-if="engagement_lists.data.length === 0">
          <tr>
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-for="engagement in engagement_list.data" :key="user.id">
          <div v-if="engagement.name.length > 0" >
            <tr>
              <td>
                {{ engagement.name }}
              </td>
              <td>
                <div v-if="engagement.calendar_date.length > 0">
                  {{ dateTime(engagement.calendar_date) }}
                </div>
              </td>
              <td>
                <div v-if="engagement.data_set.length > 0">
                  {{ engagement.data_set }}
                </div>
              </td>
              <td>
                <div v-if="engagement.city.length > 0">
                  {{ engagement.data_set }}
                </div>
              </td>
              <td class="table__buttons">
                <div class="buttons-group">
                  <a :href="route('engagement.show', {id: engagement.id})" class="button button--small">
                    View
                  </a>
                  <a :href="route('engagement.edit', {id: engagement.id})" class="button button--small button--green">
                                <span class="button__icon">
                                    <Icon icon="edit" />
                                </span>
                    Edit
                  </a>
                  <a href="#" class="button button--small button--red">
                                <span class="button__icon">
                                    <Icon icon="trash" />
                                </span>
                    Delete
                  </a>
                </div>
              </td>
            </tr>
          </div>
        </template>
        </tbody>
      </table>
    </div>
  </app-layout>

</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import moment from "moment";
export default {
  name: "Engagement.vue",
  components: {AppLayout},
  props: {
    engagement: Array
  },
  methods: {
    dateTime: function (date) {
      console.log(moment("calendar", date))
      return moment("calendar", date);
    },
  },
}
</script>

<style scoped>

</style>
