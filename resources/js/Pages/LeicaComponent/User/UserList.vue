<template>
  <app-layout title="Users">
    <template #header>
      <h2>
        LEAD Dashboard
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Users
        </h2>
        <div class="card__heading-button">
          <a :href="route('user.create')" class="button">
            Add User
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
            <td>
              <div>
                <p>No result found</p>
              </div>
            </td>
          </tr>
        </template>
        <template v-for="user in user_lists.data" :key="user.id">
          <tr>
            <td>
             <div v-if="user.firstname.length > 0 || user.lastname.length > 0">
               {{ user.firstname }} {{ user.lastname }}
             </div>
            </td>
          <td>
            <div v-if="user.roles.length > 0">
              {{ user.roles[0].name }}
            </div>
          </td>
          <td>
            <div v-if="user.email.length > 0">
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
                                    <Icon icon="edit" />
                                </span>
                Edit
              </a>

                <delete-confirmation
                  :message="message"
                  :item-id="user.id"
                  :delete-path="deletePath"
                  :title="title"
                  :cancel-path="cancelPath"
                />
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
import Icons from "../../../Components/Icons";
import AppLayout from "../../../Layouts/AppLayout";
import DangerButton from "../../../Jetstream/DangerButton";
import DeleteConfirmation from "../Confirmation/DeleteConfirmation";

export default {
  name: "UserList.vue",
  props: {
    user_lists: Array,

  },
  components: {
    DeleteConfirmation,
    DangerButton,
    Icons,
    AppLayout
  },
  data() {
    return {
      message: "Are you sure you want to delete this user?",
      deletePath: 'user/delete/',
      title: 'User',
      cancelPath: 'user.index'

    }
  },
  methods: {
  }
}
</script>

