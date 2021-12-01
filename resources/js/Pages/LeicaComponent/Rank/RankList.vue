Ranklist
<template>
  <app-layout :auth-user="user">
    <template #header>
      <h2>
        Evaluate
      </h2>
      <p>
        Evaluate / Delete KEE engagements
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Completed Engagement
        </h2>
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
        <template v-if="completed_list.data.length === 0">
          <tr>
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-else v-for="engagement in completed_list.data" :key="engagement.id">
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
                <a :href="route('manage_rank.show', {id: engagement.id})" class="button button--small button--green">
                                <span class="button__icon">
                                    <Icons icon="edit" />
                                </span>
                  Evaluate
                </a>
                <button @click="deleteRow(engagement.id)" type="button" class="button button--small button--red">
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
        :current-page="completed_list.current_page"
        :first-page-url="completed_list.first_page_url"
        :from="completed_list.from"
        :last-page="completed_list.last_page"
        :last-page-url="completed_list.last_page_url"
        :per-page="completed_list.per_page"
        :to="completed_list.to"
        :total="completed_list.total"
        :path="completed_list.path"
        :next-page-url="completed_list.next_page_url"
        :prev-page-url="completed_list.prev_page_url" />
    </div>
    <DeleteModal
      :modalActive="modalActive"
      title="Delete Engagement"
      content="Are you sure you want to delete this engagement?"
      :id="deleteId"
      deleteRoute="manage_engagement.delete"
      @hideModal="hideModal"
    />
  </app-layout>
</template>

<script>
import Icons from "../../../Components/Icons";
import AppLayout from "../../../Layouts/AppLayout";
import moment from "moment";
import DeleteModal from '@/Components/DeleteModal.vue';
import Pagination from "../Pagination";
export default {
  name: "RankList.vue",
  components: {
    AppLayout,
    Icons,
    DeleteModal,
    Pagination
  },
  props: {
    completed_list: Array,
    user: Object,
  },
  data() {
    return {
      modalActive: false,
      deleteId: ''
    }
  },
  methods: {
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
    }
  },
}
</script>

<style scoped>

</style>

