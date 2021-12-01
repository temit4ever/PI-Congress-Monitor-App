<template>
  <app-layout title="Users" :auth-user="user" >
    <template #header>
      <h2>
       User
      </h2>
      <p>
        Add / Edit / Delete AstraZeneca users
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Users
        </h2>
        <div class="form__item">
          <div class="form__input ml-10">
            <span v-if="searchLoading" class="form__input-loader">Loading</span>
            <input type="search" placeholder="Search" v-model="search" @input="searchTerm">
            <button v-if="search" @click="clearTerm" type="button" class="form__input-reset">Reset</button>
          </div>
        </div>
        <div class="form__item" v-if="!this.hideUpload">
          <a :href="route('keeupload.create')" class="button">
            Upload Kee
          </a>
        </div>
        <!--searching based on kee names and location-->
        <div class="card__heading-button add-kee-button">
          <a :href="route('user.create')" class="button button--small">
            Add new user
          </a>
        </div>
      </div>
      <table class="table">
        <thead>
        <th>Name</th>
        <th>Role</th>
        <th>Email</th>
        <th>Action</th>
        </thead>
        <tbody>
        <template v-if="user_lists !== undefined && user_lists.data.length === 0">
          <tr>
            <td colspan="4">
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-for="user in user_lists.data" :key="user.id">
          <tr>
            <td>
             <div v-if="user.firstname.length || user.lastname.length">
               {{ user.firstname }} {{ user.lastname }}
             </div>
            </td>
          <td>
            <div v-if="user.roles.length">
              {{ user.roles[0].name }}
            </div>
          </td>
          <td>
            <div v-if="user.email.length">
              {{ user.email }}
            </div>
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a :href="route('user.show', {id: user.id})" class="button button--small">
                View
              </a>
              <a :href="route('user.edit', {id: user.id})" class="button button--small button--green">
                <span class="button__icon">
                    <Icons icon="edit" />
                </span>
                Edit
              </a>
              <button @click="deleteRow(user.id)" type="button" class="button button--small button--red">
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
          :current-page="user_lists.current_page"
          :first-page-url="user_lists.first_page_url"
          :from="user_lists.from"
          :last-page="user_lists.last_page"
          :last-page-url="user_lists.last_page_url"
          :per-page="user_lists.per_page"
          :to="user_lists.to"
          :total="user_lists.total"
          :path="user_lists.path"
          :next-page-url="user_lists.next_page_url"
          :prev-page-url="user_lists.prev_page_url" />
      </div>
      <DeleteModal
        :modalActive="modalActive"
        title="Delete User"
        content="Are you sure you want to delete this user?"
        :id="deleteId"
        deleteRoute="user.delete"
        @hideModal="hideModal"
    />
  </app-layout>
</template>
<script>
import Icons from "../../../Components/Icons";
import AppLayout from "../../../Layouts/AppLayout";
import DangerButton from "../../../Jetstream/DangerButton";
import DeleteConfirmation from "../Confirmation/DeleteConfirmation";
import Pagination from "../Pagination";
import DeleteModal from '@/Components/DeleteModal.vue';
import _ from "lodash";

export default {
  name: "UserList.vue",
  components: {
    DeleteConfirmation,
    DangerButton,
    Icons,
    AppLayout,
    Pagination,
    DeleteModal
  },
  props: {
    user_lists: Array,
    user: Object,
    errors: Object,
  },
  data() {
    return {
      hideUpload: true,
      search: null,
      message: "Are you sure you want to delete this user?",
      deletePath: 'user/delete/',
      title: 'User',
      cancelPath: 'user.index',
      modalActive: false,
      deleteId: '',
      searchLoading: false
    }
  },
  methods: {
    searchTerm: _.throttle(function () {
      this.searchLoading = true
      this.$inertia.replace(this.route('user.index', {term: this.search}, { preserveState: true }))
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
      user_lists: function () {
          this.searchLoading = false
      }
  }

}
</script>
<style scoped>
.add-kee-button {
  margin-top: -1.6em;
}

</style>
