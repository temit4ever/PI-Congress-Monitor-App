<template>
  <app-layout title="Calendar" :auth-user="user">
    <template #header>
      <h2>
        Calendar
      </h2>
      <p>
        View the scheduled engagements per month
      </p>
    </template>
    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Engagement Calendar
        </h2>
        <div class="">
          <div class="form__input">
            <select name="filter" v-model="term" @input="filterTerm($event)">
              <option value="Filter By Month">
                Filter By Month
              </option>
              <option :value="index" v-for="(month, index) in months" :key="index">
                {{month}}
              </option>
            </select>
          </div>
        </div>
        <!--searching based on kee names and location-->

        <div class="">
          <div class="form__input ml-10">
            <span v-if="searchLoading" class="form__input-loader">Loading</span>
            <input type="search" placeholder="Search" v-model="searchQuery" @input="searchTerm">
            <button v-if="search" @click="clearTerm" type="button" class="form__input-reset">Reset</button>
          </div>
        </div>
      </div>
      <template v-if="engagement_calendar.length === 0">
        <tr>
          <td colspan="4">
            <div>
              <p>No result found</p>
            </div>
          </td>
        </tr>
      </template>
      <table class="table">
        <template v-if="engagement_calendar" v-for="(engagement, index) in engagement_calendar" :key="index">
            <thead class="table__heading">
                <tr>
                    <th colspan="5">
                        {{index}}
                    </th>
                </tr>
            </thead>
            <thead>
                <th>Name</th>
                <th>Date/Time</th>
                <th>Data</th>
                <th>Location</th>
                <th>Action</th>
            </thead>
            <tbody>
            <template v-if="engagement_calendar.length === 0">
                <tr>
                <td>
                    <div>
                    <p>No result found</p>
                    </div>
                </td>
                </tr>
            </template>
            <template v-else v-for="calendar in engagement" :key="calendar.id">
                <tr>
                <td>
                    <div v-if="calendar.name">
                    {{calendar.name}}
                    </div>
                </td>
                <td>
                    <div v-if="calendar.calendar_date">
                    {{dateTime(calendar.calendar_date)}}
                    </div>
                </td>

              <td>
                <div v-if="calendar.data_set">
                  {{calendar.data_set}}
                </div>
                <div v-else>N/A</div>
              </td>
              <td>
                <div v-if="calendar.city">
                  {{calendar.city}}
                </div>
                <div v-else>N/A</div>
              </td>
              <td class="table__buttons">
                    <div class="buttons-group">
                    <Link :href="route('engagement.show', {id: calendar.id})" class="button button--small">
                        View
                    </Link>
                    <Link v-if="user.status !== 'member' && !this.dateCompare(calendar.calendar_date)" :href="route('engagement.edit', {id: calendar.id})" class="button button--small button--green">
                        <span class="button__icon"><Icons icon="edit" /></span>Edit
                    </Link>
                    <Link v-else-if="user.status !== 'member'" class="button button--small button--green isDisabled"
                        href="#">
                    <span class="button__icon">
                        <Icons icon="edit" />
                    </span>
                        Edit
                    </Link>
                    <button v-if="user.status !== 'member'" @click="deleteRow(calendar.id)" type="button" class="button button--small button--red">
                            <span class="button__icon">
                                <Icons icon="trash" />
                            </span>
                        Delete
                    </button>
                    </div>
                </td>
                </tr>
            </template>
            </tbody>
            <tr class="table__spacer">
                <td></td>
            </tr>
            <tr class="table__spacer">
                <td></td>
            </tr>
        </template>
      </table>
      <pagination
        :current-page="engagement_calendar.current_page"
        :first-page-url="engagement_calendar.first_page_url"
        :from="engagement_calendar.from"
        :last-page="engagement_calendar.last_page"
        :last-page-url="engagement_calendar.last_page_url"
        :per-page="engagement_calendar.per_page"
        :to="engagement_calendar.to"
        :total="engagement_calendar.total"
        :path="engagement_calendar.path"
        :next-page-url="engagement_calendar.next_page_url"
        :prev-page-url="engagement_calendar.prev_page_url" />
    </div>
    <DeleteModal
      :modalActive="modalActive"
      title="Delete Engagement"
      content="Are you sure you want to delete this Engagement?"
      :id="deleteId"
      :deleteRoute="'engagement.delete'"
      @hideModal="hideModal"
    />
  </app-layout>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import AppLayout from "../../Layouts/AppLayout";
import Icons from "../../Components/Icons";
import moment from "moment";
import DeleteModal from '@/Components/DeleteModal.vue';
import Pagination from "./Pagination";
import _ from "lodash";
export default {
  name: "Calendar.vue",
  components: {
    AppLayout,
    Icons,
    DeleteModal,
    Pagination,
    Link
  },
  props: {
    engagement_calendar: Array,
    user: Object,
    url: Array,
    filter: Object,
    search: Object,
  },
  data() {
    return {
      modalActive: false,
      deleteId: '',
      data_set: [
        { name: 'Early'},
        { name: 'Late'},
        { name: 'Both'},
      ],
      term: this.filter ? this.filter : 'Filter By Month',
      months: {1: 'January', 2: 'February',3: 'March',4: 'April',5: 'May',6: 'June',
        7: 'July', 8: 'August', 9: 'September', 10: 'October', 11: 'November', 12: 'December'},
      searchLoading: false,
      searchQuery: this.search
    }
  },
  methods: {
    dateCompare: function (value) {
      return moment(this.now).isAfter(value);
    },
    dateMonth: function (date){
      return moment(date).format('MMMM')
    },
    dateTime: function (date) {
      return moment(date).format('DD-MM-YYYY');
    },
    deleteRow(link) {
      this.deleteId = link
      this.modalActive = true
    },

    hideModal () {
      this.modalActive = false
      this.deleteId = false
    },
    filterTerm: _.throttle(function (event) {
      this.term = event.target.value;
      this.$inertia.replace(this.route('calendar.index', {filter: this.term, search: this.searchQuery}))
    }, 1500),

    searchTerm: _.throttle(function () {
      this.searchLoading = true
      this.$inertia.replace(this.route('calendar.index', {filter: this.term, search: this.searchQuery}))
    }, 1500),
    clearTerm() {
        this.searchQuery = ''
        this.$props.search = ''
        this.searchTerm()
    }
  },
  watch: {
      engagement_calendar: function () {
          this.searchLoading = false
      }
  }
}
</script>

<style scoped>
.isDisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
  pointer-events: none;
}
</style>
