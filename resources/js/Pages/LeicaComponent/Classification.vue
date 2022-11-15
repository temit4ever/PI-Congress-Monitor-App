<template>
  <app-layout title="Classification" :countries="countries" :auth-user="user" @filterUpdate="onFilterUpdate">
    <template #header>
      <h2>
        KEEs Relationship
      </h2>
      <p>
        A list of the top tier KEEs and ranking based on familiarity of data
      </p>
    </template>
    <div>
      <div class="card card--break-out">
        <div class="card__heading">
          <h2 class="card__title">
            KEEs
          </h2>
          <div class="card__heading-button">
            <div class="form__input ml-10">
              <span v-if="searchLoading" class="form__input-loader">Loading</span>
              <input type="search" placeholder="Search" v-model="keeform.kee_search_term" @input="searchKee($event.target.value)">
              <button v-if="keeform.kee_search_term" @click="clearTerm" type="button" class="form__input-reset">Reset</button>
            </div>
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
          <template v-if="kee_rank.data.length === 0">
            <tr>
              <td colspan="7">
                <div>
                  <p>No result found</p>
                </div>
              </td>
            </tr>
          </template>
          <template v-for="rank in kee_rank.data" :key="rank.id">
            <tr>
              <td>
                <div class="table__cell-with-icon">
                  <span class="table__icon">
                    <img
                        v-if="(rank.kee_photo_path && rank.kee_photo_path !== 'placeholder-profile.jpg')"
                        :src="`${rank.kee_photo_path}`" />
                    <Icons v-else icon="person"/>
                  </span>
                  <span v-if="rank && (rank.title || rank.firstname || rank.lastname)">
                            {{ rank.title }} {{ rank.firstname }} {{ rank.lastname }}
                          </span>
                </div>
              </td>
              <td>
                <span v-if="rank.specialism">{{ rank.specialism }}</span>
              </td>
              <td>
                <span v-if="rank.rank">{{ rank.rank }}</span>
              </td>
              <td>
                <span v-if="rank.understanding_data_status">{{ rank.understanding_data_status }}</span>
              </td>
              <td>
                <span v-if="rank.rank">{{ rank.commitment_status }}</span>
              </td>
              <td>
                <span v-if="rank.performance_status">{{ rank.performance_status }}</span>
              </td>
              <td class="table__buttons">
                <div class="buttons-group">
                  <Link :href="route('kee.shows', {id: rank.id ? rank.id : '', eid: rank.eid ? rank.eid : ''})" class="button button--small">
                    View
                  </Link>
                  <Link  v-if="user.status !== 'member'" :href="route('schedule.create', {id: rank.id ? rank.id : '' })"
                     class="button button--small button--green">
                    Schedule
                  </Link>
                </div>
              </td>
            </tr>
          </template>
          </tbody>
        </table>
        <span v-show="kee_rank.data ">
        <pagination
          :current-page="kee_rank.current_page"
          :first-page-url="kee_rank.first_page_url"
          :from="kee_rank.from"
          :last-page="kee_rank.last_page"
          :last-page-url="kee_rank.last_page_url"
          :per-page="kee_rank.per_page"
          :to="kee_rank.to"
          :total="kee_rank.total"
          :path="kee_rank.path"
          :next-page-url="kee_rank.next_page_url"
          :prev-page-url="kee_rank.prev_page_url"
        />
      </span>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import Icons from '@/Components/Icons.vue';
import Pagination from "./Pagination";
import {computed, reactive} from 'vue';
import {Inertia} from "@inertiajs/inertia";


export default {
  name: "Classification.vue",
  components: {
    AppLayout,
    Icons,
    Pagination,
  },
  data() {
      return {
          searchLoading: false
      }
  },
  props: {
    user: Object,
    kee_rank: Object,
    countries: Array,

    filter_rank: String,
    filter_performance: String,
    filter_commitment: String,
    filter_specialism: String,
    filter_country: String,
    kee_search_term: String,
  },
  setup (props) {

    const keeform = reactive({
      rank: props.filter_rank ? props.filter_rank : null,
      commitmentTerm: props.filter_commitment ? props.filter_commitment : null,
      performanceTerm: props.filter_performance ? props.filter_performance : null,
      specialismTerm: props.filter_specialism ? props.filter_specialism : null,
      countryTerm: props.filter_country ? props.filter_country : null,
      kee_search_term: props.kee_search_term ? props.kee_search_term : null,
    })

    function submit() {
      console.log("submit");
      Inertia.get(this.route('classification.index'), keeform, { preserveState: true })
    }

    return { keeform, submit }
  },


  methods: {

    onFilterUpdate(value){
      if ( value ) {
        this.keeform.rank = value.rank ? value.rank : null;
        this.keeform.commitmentTerm = value.commitmentTerm ? value.commitmentTerm : null;
        this.keeform.performanceTerm = value.performanceTerm ? value.performanceTerm : null;
        this.keeform.specialismTerm = value.specialismTerm ? value.specialismTerm : null;
        this.keeform.countryTerm = value.countryTerm ? value.countryTerm : null;
      }
      this.submit();
    },

    created() {
      //parse the url parameters
      let qp = new URLSearchParams(window.location.search);
      if ( qp.get('kee_search_term') ) {
        this.keeform.kee_search_term = qp.get('kee_search_term');
      }
    },

    searchKee(value){
      this.searchLoading = true
      this.keeform.kee_search_term = value;
      this.onFilterUpdate();
    },

    clearTerm() {
        this.keeform.kee_search_term = ''
        this.searchKee(this.keeform.kee_search_term)
    }
  },
  watch: {
      kee_rank: function() {
          this.searchLoading = false
      }
  }

}
</script>
