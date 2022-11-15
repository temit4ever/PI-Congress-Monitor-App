<template>
  <app-layout :auth-user="user">
    <template #header>
      <h2>
        Engagement
      </h2>
      <p>
        Add / Edit / Delete KEE engagements
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Engagement
        </h2>
        <div class="">
          <div class="form__input">
            <select name="filter" v-model="term" @input="filterTerm($event)">
              <option value="Filter">
                Filter By Data
              </option>
              <option :value="data.name" v-for="(data, index) in data_set" :key="index">
                {{ data.name }}
              </option>
            </select>
          </div>
        </div>
        <!--searching based on kee names and location-->

        <div class="">
          <div class="form__input ml-10">
            <span v-if="searchLoading" class="form__input-loader">Loading</span>
            <input type="search" placeholder="Search by name" v-model="search" @input="searchTerm">
            <button v-if="search" @click="clearTerm" type="button" class="form__input-reset">Reset</button>
          </div>
        </div>
        <div class="card__heading-button button--small" v-if="user.role_id !== 3">
          <Link :href="route().current('manage_engagement.index') ? route('manage_engagement.create') : route('engagement.create') " class="button">
          Add
          </Link>
        </div>
      </div>
      <table class="table">
        <thead>
        <th>Name</th>
        <th>Date/Time</th>
        <th>Data</th>
        <th>Location</th>
        <th>Action</th>
        </thead>
        <tbody>
        <template v-if="engagement_list.data.length === 0">
          <tr>
            <td colspan="5">
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-else v-for="engagement in engagement_list.data" :key="engagement.id">
          <tr>
            <td>
              <div v-if="engagement.name.length > 0 ">
                {{ engagement.name }}
              </div>
            </td>
            <td>
              <div v-if="engagement.calendar_date.length > 0 ">
                {{ dateTime(engagement.calendar_date)}}
              </div>
            </td>

            <td>
              <div v-if="engagement.data_set && engagement.data_set.length > 0">
                {{ engagement.data_set }}
              </div>
            </td>
            <td>
              <div v-if="engagement.city && engagement.city.length > 0">
                {{ engagement.city }}
              </div>
              <div v-else>N/A</div>
            </td>
            <td class="table__buttons">
              <div class="buttons-group">
                <Link :href="route().current('manage_engagement.index') ? route('manage_engagement.show', {id: engagement.id}) : route('engagement.show', {id: engagement.id})" class="button button--small">
                  View
                </Link>
                <Link v-if="user.status !== 'member' && !this.dateCompare(engagement.calendar_date)" class="button button--small button--green"
                   :href="route().current('manage_engagement.index') ? route('manage_engagement.edit', {id: engagement.id}) :
                   route('engagement.edit', {id: engagement.id})">
                                <span class="button__icon">
                                    <Icons icon="edit" />
                                </span>
                  Edit
                </Link>
                <a v-else class="button button--small button--green isDisabled"
                   href="#">
                  <span class="button__icon">
                    <Icons icon="edit" />
                  </span>
                  Edit
                </a>

                <button @click="deleteRow(engagement.id)" type="button" class="button button--small button--red" v-if="user.role_id !== 3">
                    <span class="button__icon">
                        <Icons icon="trash" />
                    </span>
                    Delete
                </button>
              </div>
            </td>
          </tr>
          <tr class="table__spacer">
              <td></td>
          </tr>
        </template>
        </tbody>
      </table>
      <pagination
          :current-page="engagement_list.current_page"
          :first-page-url="engagement_list.first_page_url"
          :from="engagement_list.from"
          :last-page="engagement_list.last_page"
          :last-page-url="engagement_list.last_page_url"
          :per-page="engagement_list.per_page"
          :to="engagement_list.to"
          :total="engagement_list.total"
          :path="engagement_list.path"
          :next-page-url="engagement_list.next_page_url"
          :prev-page-url="engagement_list.prev_page_url" />
    </div>
    <DeleteModal
        :modalActive="modalActive"
        title="Delete Engagement"
        content="Are you sure you want to delete this engagement?"
        :id="deleteId"
        :deleteRoute="route().current('manage_engagement.index') ? 'manage_engagement.delete' : 'engagement.delete'"
        @hideModal="hideModal"
    />
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import moment from "moment";
import Icons from "../../../Components/Icons";
import DeleteModal from '@/Components/DeleteModal.vue';
import Pagination from "../Pagination";
import _ from "lodash";

export default {
  name: "Engagement.vue",
  components: {AppLayout, Icons, moment, DeleteModal, Pagination},
  props: {
    engagement_list: Array,
    user: Object,
    filter_term: String,
    search_term: String,
  },
  data(props) {
      return {
        now: Date.now(),
        modalActive: false,
        deleteId: '',
        data_set: [
          { name: 'Early'},
          { name: 'Late'},
          { name: 'Both'},
        ],
        term: props.filter_term ? props.filter_term : 'Filter',
        search: props.search_term ? props.search_term : null,
        searchLoading: false
      }
  },
  methods: {
    dateCompare: function (value) {
      /*console.log(moment(this.now))
      console.log(moment(value).format('X'))
      console.log(moment(this.now).isAfter(value))*/
      return moment(this.now).isAfter(value);
    },
    dateTime: function (date) {
      //console.log(moment())
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
      this.$inertia.replace(this.route('manage_engagement.index', {filter: this.term, search: this.search}))
    }, 1500),

    searchTerm: _.throttle(function () {
      this.searchLoading = true
      this.$inertia.replace(this.route('manage_engagement.index', {filter: this.term, search: this.search}))
    }, 1500),

    clearTerm () {
        this.search = ''
        this.searchTerm()
    }
  },
  watch: {
      engagement_list: function () {
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
