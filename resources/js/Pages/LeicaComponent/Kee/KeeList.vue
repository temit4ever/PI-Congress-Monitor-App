<template>
  <app-layout title="Users">
    <template #header>
      <h2>
        KEE
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          KEEs
        </h2>

        <!--filtering based on kee specialism-->
        <div class="form__item">
          <div class="form__input form__required">
            <select name="filter" v-model="term" @change="filterTerm($event)">
              <option value="" selected disabled>
                Filter
              </option>
              <option :value="country.id" v-for="country in countries" :key="country.id">
                {{ country.name }}
              </option>
            </select>
          </div>
        </div>
        <!--searching based on kee names and location-->

        <div class="form__item">
          <div class="form__input ml-10">
            <input type="search" placeholder="Search" v-model="search" @keyup="searchTerm">
          </div>
        </div>
        <div class="card__heading-button">
          <a :href="route('kee.create')" class="button">
            Add Kee
          </a>
        </div>
      </div>
      <table class="table">
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
              <div v-if="kee.title.length > 0 || kee.firstname.length > 0 || user.lastname.length > 0">
                {{ kee.title }} {{ kee.firstname }} {{ kee.lastname }}
              </div>
            </td>
            <td>
              <div v-if="kee.specialism.length > 0">
                {{ kee.specialism }}
              </div>
            </td>
            <td>
              <div v-if="kee.office_name.length > 0">
                {{ kee.office_name }}
              </div>
            </td>
            <td class="table__buttons">
              <div class="buttons-group">
                <a :href="route('kee.show', {id: kee.id})" class="button button--small">
                  View
                </a>
                <a :href="route('kee.edit', {id: kee.id})" class="button button--small button--green">
                                <span class="button__icon">
                                    <Icon icon="edit" />
                                </span>
                  Edit
                </a>
                <a :href="route('kee.delete', {id: kee.id})" class="button button--small button--red">
                                <span class="button__icon">
                                    <Icon icon="trash" />
                                </span>
                  Delete
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
import _ from "lodash";
export default {
  name: "KeeList.vue",
  components: {
    AppLayout,
  },
  props: {
    kee_lists: Array,
    countries: Array,

  },
  data () {
  },
  methods: {
    filterTerm: _.throttle(function (event) {
      const term = event.target.value;
      this.$inertia.replace(this.route('kee.index', {term: this.term}))
    }, 1500),

    searchTerm: _.throttle(function () {
      this.$inertia.replace(this.route('kee.index', {term: this.search}))
    }, 1500),

  }
}
</script>

<style scoped>

</style>
