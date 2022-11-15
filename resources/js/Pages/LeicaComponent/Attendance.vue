<template>
  <app-layout title="Calendar" :auth-user="user">
    <template #header>
      <h2>
        Top 50 KEE Attendance
      </h2>
      <p>
        KEE Attendance
      </p>
    </template>
    <div class="card">
      <div class="card__heading card__heading--no-margin">
        <h2 class="card__title">
          KEE Attendance
        </h2>
        <div class="form__item">
          <div class="form__input ml-10">
            <input type="search" placeholder="Search congress / KEE" v-model="search" @input="searchTerm">
            <button v-if="search" @click="clearTerm" type="button" class="form__input-reset">Reset</button>
          </div>
        </div>
      </div>
      <ul class="key">
        <li class="key__item">
          <span class="key__dot key__dot--attended"></span>
          Attended
        </li>
        <li class="key__item">
          <span class="key__dot key__dot--absent"></span>
          Absent
        </li>
        <li class="key__item">
          <span class="key__dot key__dot--planned"></span>
          Planned
        </li>
        <li class="key__item">
          <span class="key__dot key__dot--unknown"></span>
          Not scheduled
        </li>
      </ul>
      <table class="table">
        <thead class="table__header-sticky">
        <tr class="table__spacer">
          <th colspan="2">
            Profile
          </th>
          <th colspan="6">
            Congress
          </th>
        </tr>
        <tr class="table__row--border">
          <th class="no-border">
            <ul class="pagination-dots">
              <li class="pagination-dots__item" :class="{'is-active': pageNumber === 0}">
                <Link href="#" class="pagination-dots__link" @click=" pageSlider('0')">
                  1
                </Link>
              </li>
              <li class="pagination-dots__item" :class="{'is-active': pageNumber === 1}">
                <Link href="#" class="pagination-dots__link" @click=" pageSlider('1')">
                  2
                </Link>
              </li>
              <li class="pagination-dots__item" :class="{'is-active': pageNumber === 2}">
                <Link href="#" class="pagination-dots__link" @click=" pageSlider('2')">
                  3
                </Link>
              </li>
            </ul>
          </th>
          <th class="table__cell--center">
            <button class="table-arrow table-arrow--prev" :class="{ 'is-disabled': pageNumber === 0 }"
                    @click=" pageSlider('prev')" :disabled="pageNumber === 0">
              Previous
            </button>
          </th>
          <th class="table__cell--center" id="table-header" v-if="paginatedData.length > 0" v-for="(congress, index) in
                        paginatedData" :key="index">
            <span :id="congress">{{ congress }}</span>
          </th>
          <th class="table__cell--center">
            <button class="table-arrow table-arrow--next" :class="{ 'is-disabled': pageNumber === 2 }"
                    @click=" pageSlider('next')"
                    :disabled="pageNumber === 2">
              Next
            </button>
          </th>
        </tr>
        </thead>
        <tr class="table__spacer table__spacer--tall">
          <td></td>
        </tr>
        <tbody class="table__body">
        <template v-if=" kees.length === 0">
          <tr>
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <tr v-else class="table__row--border" v-for="(kee_details, name, i) in kees.data" :key="i">
          <td colspan="2">

            <div class="table__cell-with-icon">
              <span class="table__icon">
                <img
                  v-if="(getKeePhoto(kees.data, name))"
                  :src="`${getKeePhoto(kees.data, name)}`" />
                <Icons v-else icon="person"/>
              </span>
              <div>
                {{ name }}
                <div>
                  <template v-if="checkAttendedKee(name)">
                    <strong class="c-purple">Attended:</strong> {{ getAttendanceLength(attendance[name]) }}
                  </template>
                  <template v-else>
                    <strong class="c-purple">Attended:</strong> 0
                  </template>
                </div>
              </div>
            </div>
          </td>
          <template v-for="(header,key) in paginatedData" :key="key">
            <td class="table__cell--center">
              <template v-if="kees.data[name][header]">
                <!--                {{kees.data[name][header][0].attendance}}-->
                <template v-if="kees.data[name][header][0].attendance === 'Yes'">
                              <span class="icon-circle icon-circle--green">
                                <Icons icon="tick-plain"/>
                            </span>
                </template>
                <template v-else-if="kees.data[name][header][0].attendance === 'No'">
                            <span class="icon-circle icon-circle--red">
                                <Icons icon="cross"/>
                            </span>
                </template>
                <template v-else-if="dateCompare(kees.data[name][header][0].calendar_date)">
                              <span class="icon-circle icon-circle--orange">
                                <Icons icon="planned"/>
                            </span>
                </template>

              </template>
              <template v-else>
                             <span class="icon-circle icon-circle--purple">
                                <Icons icon="unknown"/>
                            </span>
              </template>
            </td>
          </template>
          <td>
          </td>
        </tr>
        </tbody>
      </table>
      <pagination
        :current-page="kees.current_page"
        :first-page-url="kees.first_page_url"
        :from="kees.from"
        :last-page="kees.last_page"
        :last-page-url="kees.last_page_url"
        :per-page="kees.per_page"
        :to="kees.to"
        :total="kees.total"
        :path="kees.path"
        :next-page-url="kees.next_page_url"
        :prev-page-url="kees.prev_page_url"/>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import Icons from '@/Components/Icons.vue';
import Pagination from "./Pagination";
import moment from "moment";
import _ from "lodash";

export default {
  name: "Attendance.vue",
  components: {
    AppLayout,
    Icons,
    Pagination,
  },
  props: {
    user: Object,
    kees: Array,
    congresses: Array,
    search_term: String,
    attendance: Object,

  },
  data(props) {
    return {
      now: Date.now(),
      pageNumber: 0,
      perPage: 5,
      dotPerPage: 10,
      search: props.search_term ? props.search_term : null,
      searchLoading: false,
      groupedCongress: [],
      totalKee: [],
      filteredIdArray: [],
      keeNames: [],
      nonActivePrev: false,
      nonActiveNext: false,
    }
  },
  computed: {
    pageCount: function () {
      let length = this.congresses.length, size = this.perPage
      return Math.ceil(length / size)
    },
    paginatedData: function () {
      const start = this.pageNumber * this.perPage, end = start + this.perPage
      console.log(this.congresses.slice(start, end))
      return this.congresses.slice(start, end)
    },
    /* disabledPrev: function () {
       if (this.pageNumber <= this.pageCount -1) {
         this.nonActive = true;
         return true;
       }
       else {
         this.nonActive = false
       }
     }*/
  },
  methods: {
    getKeePhoto: function (details,name) {
      if (details[name]['kee_photo_path'] !== undefined && details[name]['kee_photo_path'] !== 'placeholder-profile.jpg') {
        console.log(details[name]['kee_photo_path'])
        return details[name]['kee_photo_path']
      }
    },
    getAttendanceLength: function (attendance) {
      if (attendance !== undefined) {
        return attendance.attendance.length
      }
    },
    // Set controller for top headers pagination button
    disabledPager: function (controller) {
      if (controller === 'prev') {
        if (this.pageNumber === 0) {
          this.nonActivePrev = true
          return true;
        } else {
          this.nonActivePrev = false
        }
      }
      if (controller === 'next') {
        if (this.pageNumber >= this.pageCount - 1) {
          this.nonActiveNext = this.pageNumber >= this.pageCount - 1
          return true;
        } else {
          this.nonActiveNext = false
        }
      }
    },
    checkAttendedKee: function (name) {
      if (name in this.attendance) {
        if (this.attendance !== undefined) {
          return this.attendance[name].attendance.length > 0
        }
      }
    },
    // Compare to see if engagement has past.
    dateCompare: function (value) {
      const month = moment(value).valueOf();
      if (this.now <= moment.unix(month) / 1000 || this.now >= moment.unix(month) / 1000)
        return true
    },
    pageSlider: function (controlAction) {
      if (controlAction === 'next') {
        this.pageNumber++
      } else if (controlAction === 'prev') {
        this.pageNumber--
      } else {
        this.pageNumber = controlAction
      }
    },
    clearTerm: function () {
      this.search = ''
      this.searchTerm()
    },
    searchTerm: _.throttle(function () {
      this.searchLoading = true
      this.$inertia.replace(this.route('attendance.index', {term: this.search}))
    }, 1500),

  },
  created: function () {
    //this.groupedCongress = _.groupBy(this.kees,);
    //this.dotHeader = _.chunk(this.congresses, 5)
  },
}
</script>
