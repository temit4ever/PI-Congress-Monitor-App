<template>
  <app-layout title="Engagement" :auth-user="user">
    <template #header>
      <h2>
        Evaluate
      </h2>
    </template>
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          Engagement Details
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <a :href="route('manage_completed.index')" class="button">
              Back
            </a>
<!--            <a :href="route('engagement.edit', {id: engagement.id})" class="button button&#45;&#45;green" v-if="user.role_id !== 3">
              Edit
            </a>-->
          </div>
        </div>
      </div>
      <div class="engagement-details">
        <div class="engagement-details__first">
          <div class="engagement-details__small m-bot">
            {{current_engagement.platform}}
          </div>
          <div class="c-purple title-medium m-bot">
            Engagement Name: {{ current_engagement.name}}

          </div>
          <div class="c-purple">
            Date: {{dateTime(current_engagement.calendar_date)}}
          </div>
          <div class="c-purple">
            Start: <span v-if="startTimeformat">{{startTimeformat.hh}}:{{startTimeformat.mm}}{{startTimeformat.a}}</span>
            <span v-else>N/A</span>
          </div>
          <div class="c-purple m-bot--2">
            End: <span v-if="endTimeformat">{{endTimeformat.hh}}:{{endTimeformat.mm}} {{endTimeformat.a}}</span>
            <span v-else>N/A</span>
          </div>
          <div>
            Engagement Type: {{ current_engagement.type }}
          </div>
          <div class="m-bot--2">
            Congress: <span v-if="current_engagement.congress">{{current_engagement.congress}}</span>
            <span v-else>N/A</span>
          </div>
          <div>
            Data Sets:
            <div class="engagement-details__small">
              {{ current_engagement.data_set }}
            </div>
          </div>
        </div>
        <div class="engagement-details__second">
          <table class="engagement-details__table">
            <tr>
              <td class="engagement-details__table-title">
                House or Office Number:
              </td>
              <td>
                <span v-if="current_engagement.house_number">{{current_engagement.house_number}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Street Address 1:
              </td>
              <td>
                <span v-if="current_engagement.address_1">{{current_engagement.address_1}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Street Address 2:
              </td>
              <td>
                <span v-if="current_engagement.address_2">{{current_engagement.address_2}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                County/State:
              </td>
              <td>
                <span v-if="current_engagement.county_state">{{current_engagement.county_state}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                City:
              </td>
              <td>
                <span v-if="current_engagement.city">{{current_engagement.city}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Postcode:
              </td>
              <td>
                <span v-if="current_engagement.post_code">{{current_engagement.post_code}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Country:
              </td>
              <td>
                <span v-if="current_engagement.country_name">{{current_engagement.country_name}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
          </table>
          <span v-if="current_engagement.digital_link">
          <a :href="`${current_engagement.digital_link}`" class="engagement-details__meeting-link" target="_blank">
          <img class="meeting-icon" src="../../../../images/icon-meeting.svg">Digital Meeting
        </a>
        </span>
        </div>
      </div>
      <hr>
      <table class="table">
        <thead>
        <th>
          Name
        </th>
        <th>
          Specialism
        </th>
        <th>
          Category
        </th>
        <th>
          Data
        </th>
        <th>
          Commitment
        </th>
        <th>
          Performance
        </th>
        <th>
          Action
        </th>
        </thead>
        <tbody>
        <template v-if="engagement === null">
          <tr>
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-else v-for="(keeRank, index) in engagement" :key="index">
          <tr>
            <td>
              <div class="table__cell-with-icon" >
                            <span v-if="keeRank.kee_photo_path === null || keeRank.kee_photo_path === 'placeholder-profile.jpg'" class="table__icon">
                    <Icons icon="person"/>
                </span>
                <span v-else class="table__icon">
                  <img
                    :src="`${keeRank.kee_photo_path}`" />
                </span>
                <span v-if="keeRank && (keeRank.title || keeRank.firstname || keeRank.lastname)">{{ keeRank.title }} {{ keeRank.firstname }} {{ keeRank.lastname }}</span>
              </div>
            </td>
            <td>
              <span v-if="keeRank">{{keeRank.specialism}}</span>
            </td>
            <td>
              <span v-if="keeRank.rank">{{keeRank.rank}}</span>
            </td>
            <td>
              <span v-if="keeRank.understanding_data_status">{{keeRank.understanding_data_status}}</span>
            </td>
            <td>
              <span v-if="keeRank.commitment_status">{{keeRank.commitment_status}}</span>
            </td>
            <td>
              <span v-if="keeRank.performance_status">{{keeRank.performance_status}}</span>
            </td>
            <td class="table__buttons">
              <div v-if="( keeRank.attendance === 'Yes' && keeRank.engagement_id === current_engagement.id)">Completed</div>
              <div v-else-if="keeRank.attendance === 'No'">Absent</div>
              <div v-else class="buttons-group">
                <a :href="route('manage_rank.create', {id: keeRank.kee_id, eid: current_engagement.id})" class="button button--small">
                  Evaluate
                </a>
              </div>
            </td>
          </tr>
        </template>
        </tbody>
      </table>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import Icons from "../../../Components/Icons";
import moment from "moment";
export default {
  name: "RankDetails.vue",
  components: {
    AppLayout,
    Icons,

  },
  props: {
    engagement: Object,
    user: Object,
    current_engagement: Object
  },
  data(props) {
    return {
      startTimeformat: JSON.parse(props.current_engagement.start_time),
      endTimeformat: JSON.parse(props.current_engagement.end_time)
    }
  },
  methods: {
    dateTime: function (date) {

      return moment(date).format('dddd Do MMMM, YYYY');
    },
    timeFormat: function (date) {
      return moment(date).format('HH:mm:ss');
    },
  },
}
</script>

<style scoped>

</style>
