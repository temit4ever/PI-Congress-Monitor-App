<template>
  <app-layout title="Kee Engagement Histroy" :auth-user="user">
    <template #header>
      <h2>
        Kees
      </h2>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          <p>
            KEE Engagement History
          </p>
        </h2>
        <h2 class="card__title">
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <button onclick="window.history.back();" class="button button--small">
              Back
            </button>
            <Link :href="route().current('manage_ehistory.index', {id: kee_id}) ? route('manage_kee.show', {id: kee_id, eid: engagement.id}) :  route('kee.shows', {id: kee_id, eid: engagement.id})" class="button button--small">
             Profile
            </Link>
            <Link :href="route().current('manage_ehistory.index', {id: kee_id}) ? route('manage_history.index', {id: kee_id, eid: engagement.id}) : route('history.index', {id: kee_id, eid: engagement.id})" class="button button--small">
              History
            </Link>
            <Link v-if="user.status !== 'member'" :href="route('schedule.create', {id: kee_id})" class="button button--small button--green">
              Schedule
            </Link>
          </div>
        </div>
      </div>
      <div>Completed</div>
      <table class="table">
        <thead>
        <th>Name</th>
        <th>Data/Time</th>
        <th>Data</th>
        <th>Location</th>
        <th>Action</th>
        </thead>
        <tbody>
        <template v-if="past_engagement.data.length === 0">
          <tr>
            <td colspan="5">
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-for="engagement in past_engagement.data" :key="engagement.id">
          <tr>
            <td>
              <div v-if="engagement.name.length > 0 ">
              {{ engagement.name }}
              </div>
            </td>
            <td>
              <div>
               {{ dateTime(engagement.calendar_date)}}
              </div>
            </td>

            <td>
              <div>
                {{ engagement.data_set }}
              </div>
            </td>
            <td>
              <div v-if="engagement.city">
               {{ engagement.city }}
              </div>
              <div v-else>N/A</div>
            </td>
            <td class="table__buttons">
              <div class="buttons-group">
                <Link :href="route().current('manage_ehistory.index') ? route('manage_engagement.show', {id: engagement.id}) : route('engagement.show', {id: engagement.id})" class="button button--small">
                  View
                </Link>
              </div>
            </td>
          </tr>
          <tr class="table__spacer">
            <td></td>
          </tr>
        </template>
        </tbody>
      </table>
      <div class="card__heading">
        <h2 class="card__title">
        </h2>
      </div>
      Upcoming
      <table class="table">
        <thead>
        <th>Name</th>
        <th>Data/Time</th>
        <th>Data</th>
        <th>Location</th>
        <th>Action</th>
        </thead>
        <tbody>
        <template v-if="upcoming_engagement.data.length === 0" >
          <tr>
            <td colspan="5">
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-for="engagement in upcoming_engagement.data" :key="engagement.id">
          <tr>
            <td>
              <div v-if="engagement.name.length > 0 ">
                {{ engagement.name }}
              </div>
            </td>
            <td>
              <div>
                {{ dateTime(engagement.calendar_date)}}
              </div>
            </td>

            <td>
              <div>
                {{ engagement.data_set }}
              </div>
            </td>
            <td>
              <div v-if="engagement.city">
                {{ engagement.city }}
              </div>
              <div v-else>N/A</div>

            </td>
            <td class="table__buttons">
              <div class="buttons-group">
                <Link :href="route().current('manage_ehistory.index') ? route('manage_engagement.show', {id: engagement.id}) : route('engagement.show', {id: engagement.id})" class="button button--small">
                View
                </Link>
              </div>
            </td>
          </tr>
          <tr class="table__spacer">
            <td></td>
          </tr>
        </template>
        </tbody>
      </table>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import moment from "moment";
import Icons from "../../../Components/Icons";

export default {
  name: "EngagementHistory.vue",
  components: {
    AppLayout,
    moment,
    Icons
  },
  props: {
    user: Object,
    past_engagement: Object,
    upcoming_engagement: Object,
    kee_id: String,
    engagement: Object
  },
  methods: {
    dateTime: function (date) {
      return moment(date).format('DD-MM-YYYY');
    },
  },
}
</script>

<style scoped>

</style>
