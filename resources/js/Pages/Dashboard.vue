<template>
  <app-layout title="Dashboard" :auth-user="AuthUser" :login-status="this.logInCheck()">
    <template #header>
      <h2>
        LEAD Dashboard
      </h2>
      <p>
        Welcome to the Lung Expert Activity Dashboard (LEAD)
      </p>
    </template>

    <div class="card">
      <div class="stats">
        <div class="stats__item">
          <div class="stats__card stats__card--purple">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                Planned
                <div class="stats__card-title-icon">
                  <icons icon="calendar" />
                </div>
              </div>
              <div class="stats__card-stat">
                <span v-if="total_per_quarter">{{total_per_quarter}}</span>
                <span v-else>00</span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  Engagements
                </div>
                with KEE in <span v-if="quarter_name">{{quarter_name}}</span>
                <span v-else>00</span>
              </div>
            </div>
          </div>
        </div>
        <div class="stats__item">
          <div class="stats__card stats__card--orange">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                Actual
                <div class="stats__card-title-icon">
                  <Icons icon="person" />
                </div>
              </div>
              <div class="stats__card-stat">
                <span v-if="attended_engagement_quarterly">{{attended_engagement_quarterly}}</span>
                <span v-else>00</span>
                <span class="stats__card-stat-small">
                  /<span v-if="quarter_engagement_percentage">{{quarter_engagement_percentage}}</span>
                <span v-else>00</span><sup>%</sup>
                </span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  Engagements
                </div>
                with KEE in <span v-if="quarter_name">{{quarter_name}}</span>
                <span v-else>00</span>
              </div>
            </div>
          </div>
        </div>
        <div class="stats__item">
          <div class="stats__card stats__card--green">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                Total Actual
                <div class="stats__card-title-icon">
                  {{ year }}
                </div>
              </div>
              <div class="stats__card-stat">
                <span v-if="yearly_attendance">{{yearly_attendance}}</span>
                <span v-else>00</span>
                <span class="stats__card-stat-small">
                  /<span v-if="yearly_engagement_percentage">{{yearly_engagement_percentage}}</span>
                <span v-else>00</span><sup>%</sup>
                </span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  Engagements
                </div>
                with KEE for the year
              </div>
            </div>
          </div>
        </div>
        <div class="stats__item">
          <div class="stats__card stats__card--blue">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                KEE Relationship
                <div class="stats__card-title-icon">
                  <Icons icon="star" />
                </div>
              </div>
              <div class="stats__card-stat">
                <span v-if="grade">{{grade}}</span>
                <span v-else>00</span>
                <span class="stats__card-stat-small">
                                    /<span v-if="yearly_grade_percentage">{{yearly_grade_percentage}}</span>
                <span v-else>00</span><sup>%</sup>
                                </span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  A - Category
                </div>
                N<sup>o</sup> of KEEs Category A
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Upcoming Engagements
        </h2>
        <div class="card__heading-button" v-if="AuthUser.status !== 'member'">
          <Link :href="route('calendar.index')" class="button">
            Calendar
          </Link>
        </div>
      </div>
      <table class="table">
        <thead>
        <th>
          Name
        </th>
        <th>
          Date/Time
        </th>
        <th>
          Data
        </th>
        <th>
          Location
        </th>
        <th>
          Action
        </th>
        </thead>
        <tbody>
        <template v-if="upcoming_engagement.data.length === 0">
          <tr>
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-else v-for="engagement in upcoming_engagement.data" :key="engagement.id">
          <tr>
            <td>
              <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icons icon="location" />
                            </span>
                <span v-if="engagement.name">
                {{engagement.name }}
              </span>
              </div>
            </td>
            <td>
            <span v-if="engagement.name">
                {{dateTime(engagement.calendar_date) }}
              </span>
            </td>
            <td>
            <span v-if="engagement.data_set">
                {{ engagement.data_set }}
              </span>
            </td>
            <td>
              <div v-if="engagement.city === null || country === null">N/A</div>
              <div v-else>{{ engagement.city }} {{ country[engagement.country_id] }}</div>
            </td>
            <td class="table__buttons">
              <div class="buttons-group">
                <Link :href="route('engagement.show', {id: engagement.id})" class="button button--small">
                  View
                </Link>
                <Link :href="route('engagement.edit', {id: engagement.id})" class="button button--small button--green" v-if="AuthUser.status !== 'member'">
                                <span class="button__icon">
                                    <Icons icon="edit" />
                                </span>
                  Edit
                </Link>
                <button @click="deleteRow(engagement.id)" type="button" class="button button--small button--red" v-if="AuthUser.status !== 'member'">
                    <span class="button__icon">
                        <Icons icon="trash" />
                    </span>
                  Delete
                </button>
              </div>
            </td>
          </tr>
          <tr class="table__spacer">
            <td colspan="5"></td>
          </tr>
        </template>
        </tbody>
      </table>
      <div v-if="upcoming_engagement.data">
        <span v-show="upcoming_engagement.data ">
        <pagination
          :current-page="upcoming_engagement.current_page"
          :first-page-url="upcoming_engagement.first_page_url"
          :from="upcoming_engagement.from"
          :last-page="upcoming_engagement.last_page"
          :last-page-url="upcoming_engagement.last_page_url"
          :per-page="upcoming_engagement.per_page"
          :to="upcoming_engagement.to"
          :total="upcoming_engagement.total"
          :path="upcoming_engagement.path"
          :next-page-url="upcoming_engagement.next_page_url"
          :prev-page-url="upcoming_engagement.prev_page_url"
        />
      </span>
      </div>
      <div v-else>
        <tr class="table__spacer">
          <td> No result found</td>
        </tr>
      </div>
      <DeleteModal
        :modalActive="modalActive"
        title="Delete Engagement"
        content="Are you sure you want to delete this engagement?"
        :id="deleteId"
        deleteRoute="engagement.delete"
        @hideModal="hideModal"
      />
    </div>
    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Recently Evaluated KEEs
        </h2>
        <div class="card__heading-button">
          <Link :href="route('classification.index')" class="button" v-if="AuthUser.status !== 'member'">
            KEE Relationship
          </Link>
        </div>
      </div>
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
          Willingness to Partner
        </th>
        <th>
          Performance
        </th>
        <th>
          Action
        </th>
        </thead>
        <tbody>
        <template v-if="details.data.length === 0">
          <tr>
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-else v-for="detail in details.data" :key="detail.id">

          <tr>
            <td>
              <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <img
                                  v-if="(detail.kee_photo_path && detail.kee_photo_path !== 'placeholder-profile.jpg')"
                                  :src="`${detail.kee_photo_path}`" />
                    <Icons v-else icon="person"/>
                            </span>
                <span v-if="detail && detail.title || detail.firstname ||detail.lastname">
                 {{detail.title}} {{detail.firstname}} {{detail.lastname}}</span>
              </div>
            </td>
            <td>
              <span v-if="detail && detail.specialism">{{detail.specialism}}</span>
            </td>
            <td>
              <span v-if="detail">{{ detail.rank }}</span>
            </td>
            <td>
              <span v-if="detail">{{ detail.understanding_data_status }}</span>
            </td>
            <td>
              <span v-if="detail">{{ detail.commitment_status }}</span>
            </td>
            <td>
              <span v-if="detail">{{ detail.performance_status }}</span>
            </td>
            <td class="table__buttons">
              <div class="buttons-group">
                <Link :href="route('kee.shows', {id: detail.id, eid: detail.eid})" class="button button--small">
                  View
                </Link>
                <Link :href="route('schedule.create', {id: detail.id})" class="button button--small button--green" v-if="AuthUser.status !== 'member'">
                  Schedule
                </Link>
              </div>
            </td>
          </tr>
        </template>
        </tbody>
      </table>
      <div v-if="details.data">
        <span v-show="details.data ">
        <pagination
          :current-page="details.current_page"
          :first-page-url="details.first_page_url"
          :from="details.from"
          :last-page="details.last_page"
          :last-page-url="details.last_page_url"
          :per-page="details.per_page"
          :to="details.to"
          :total="details.total"
          :path="details.path"
          :next-page-url="details.next_page_url"
          :prev-page-url="details.prev_page_url"
        />
      </span>
      </div>
      <div v-else>
        <tr class="table__spacer">
          <td> No result found</td>
        </tr>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Icons from '@/Components/Icons.vue';
import EngagementForm from '@/Pages/LeicaComponent/Engagement/EngagementForm.vue';
import moment from "moment";
import DeleteModal from '@/Components/DeleteModal.vue';
import Pagination from "./LeicaComponent/Pagination";

export default {
  components: {
    AppLayout,
    Welcome,
    Icons,
    EngagementForm,
    DeleteModal,
    Pagination,
  },
  props: {
    AuthUser: Object,
    upcoming_engagement: Object,
    country: Array,
    details: Array,
    plan_engagement_quarter: String,
    attended_engagement_quarterly: String,
    total_per_quarter: String,
    grade: String,
    kees: String,
    year: String,
    total_per_year: String,
    yearly_attendance: String,
    yearly_engagement: String,
    total_rank: Object,
    yearly_engagement_percentage: Object,
    quarter_name: String,
    quarter_engagement_percentage: String,
    yearly_grade_percentage: String,
  },
  data () {
    return {
      logInStatus: false,
      modalActive: false,
    }
  },

  methods: {
    deleteRow(link) {
      this.deleteId = link
      this.modalActive = true
    },
    hideModal () {
      this.modalActive = false
      this.deleteId = false
    },
    dateTime: function (date) {
      return moment(date).format('DD-MM-YYYY');
    },
    logInCheck() {
      if (this.AuthUser) {
        return this.logInStatus = true;
      }
    },
  }
}
</script>
