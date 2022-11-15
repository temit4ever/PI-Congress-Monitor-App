<template>
  <app-layout title="KEE" :auth-user="user">
    <template #header>
      <h2>
        KEE
      </h2>
      <p>
        A summary profile of each KEE. Additional details can be located on the H1 platform
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          KEEs
        </h2>

        <!--filtering based on kee specialism-->
        <div class="">
          <div class="form__input">
            <select name="filter" v-model="term" @input="filterTerm($event)">
              <option value="Filter" >
                Filter By Specialism
              </option>
              <option :value="specialism.name" v-for="specialism in specialisms" :key="specialism.id" :selected="term === specialism.name">
                {{ specialism.name }}
              </option>
            </select>
          </div>
        </div>
        <!--searching based on kee names and location-->

        <div class="">
          <div class="form__input ml-10">
            <span v-if="searchLoading" class="form__input-loader">Loading</span>
            <input type="search" placeholder="Search" v-model="search" @input="searchTerm($event)">
            <button v-if="search" @click="clearTerm" type="button" class="form__input-reset">Reset</button>
          </div>
        </div>
        <div class="card__heading-button add-kee-button" v-if="user.role_id !== 3">
          <Link :href="route('manage_kee.create')" class="button button--small">
            Add Kee
          </Link>
        </div>
      </div>
      <div class="table-border-container">
        <table class="table table--border">
          <thead>
          <th>Name</th>
          <th>Specialism</th>
          <th>Place of work</th>
          <th>Action</th>
          </thead>
          <tbody>
          <template v-if="kee_lists.data.length === 0">
            <tr>
              <td>
                <div>
                  <p>No result found</p>
                </div>
              </td>
            </tr>
          </template>
          <template v-else v-for="kee in kee_lists.data" :key="kee.id">
            <tr>
              <td>
                <span v-if="kee.title">{{ kee.title }}</span> <span v-if="kee.firstname || kee.lastname">{{ kee.firstname }} {{ kee.lastname }}</span>
              </td>
              <td>
                <div v-if="kee.specialism && kee.specialism.length > 0">
                  {{ kee.specialism }}
                </div>
              </td>
              <td>
                <div v-if="kee.place_of_work && kee.place_of_work.length > 0">
                  {{ kee.place_of_work }}
                </div>
                <div v-else>N/A</div>
              </td>
              <td class="table__buttons">
                <div class="buttons-group">
                  <Link :href="route('manage_kee.show', {id: kee.id, rid: kee.rid && kee.engagements.length > 0 ? kee.rid : ''})" class="button button--small">
                    View
                  </Link>
                  <Link :href="route().current('manage_kee.index') ? route('manage_kee.edit', {id: kee.id}) : route('kee.edit', {id: kee.id})" class="button button--small button--green">
                        <span class="button__icon">
                            <Icons icon="edit" />
                        </span>
                    Edit
                  </Link>
                  <button @click="deleteRow(kee.id)" type="button" class="button button--small button--red">
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
        </table>
      </div>
      <span v-show="kee_lists.data ">
        <pagination
          :current-page="kee_lists.current_page"
          :first-page-url="kee_lists.first_page_url"
          :from="kee_lists.from"
          :last-page="kee_lists.last_page"
          :last-page-url="kee_lists.last_page_url"
          :per-page="kee_lists.per_page"
          :to="kee_lists.to"
          :total="kee_lists.total"
          :path="kee_lists.path"
          :next-page-url="kee_lists.next_page_url"
          :prev-page-url="kee_lists.prev_page_url"
        />
      </span>
    </div>
    <DeleteModal
      :modalActive="modalActive"
      title="Delete KEE"
      content="Are you sure you want to delete this KEE?"
      :id="deleteId"
      :deleteRoute="route().current('manage_kee.index') ? 'manage_kee.delete' : 'kee.delete'"
      @hideModal="hideModal"
    />
  </app-layout>
</template>
<script>
import AppLayout from "../../../Layouts/AppLayout";
import _ from "lodash";
import Pagination from "../Pagination";
import Icons from '@/Components/Icons.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
export default {
  name: "KeeList.vue",
  components: {
    Pagination,
    AppLayout,
    Icons,
    DeleteModal,
  },
  props: {
    kee_lists: Array,
    countries: Array,
    user: Object,
    filter_term: String,
    search_term: String,

  },
  data (props) {
    return {
      term: props.filter_term ? props.filter_term : 'Filter',
      search: props.search_term ? props.search_term : null,
      modalActive: false,
      deleteId: '',
      specialisms: [
        { name: 'Medical Oncologist' },
        { name: 'Thoracic Surgery'},
        { name: 'Pulmonologist/ Medical Oncologist'},
        { name: 'Clinical Oncologist'},
        { name: 'Rad Oncologist' },
        {name: 'Pulmonologist'}
      ],
      searchLoading: false
    }
  },
  methods: {
    filterTerm: _.throttle(function (event) {

      this.term = event.target.value;
      this.$inertia.replace(this.route('manage_kee.index', {filterTerm: this.term, term: this.search}))
    }, 1500),

    searchTerm: _.throttle(function () {
      this.searchLoading = true
      this.$inertia.replace(this.route('manage_kee.index', {filterTerm: this.term, term: this.search}))
    }, 1500),

    deleteRow(link) {
      this.deleteId = link
      this.modalActive = true
    },

    hideModal () {
      this.modalActive = false
      this.deleteId = false
    },

    clearTerm () {
        this.search = ''
        this.searchTerm()
    }
  },
  watch: {
      kee_lists: function () {
          this.searchLoading = false
      }
  }
}
</script>
