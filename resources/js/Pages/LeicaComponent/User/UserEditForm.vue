<template>
  <app-layout title="Users">
    <template #header>
      <h2>
        User
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Edit Admin
        </h2>
        <div  class="card__heading-button">
          <form class="form" @submit.prevent="submitUpdate" method="POST" action="{{route('user.update')}}" enctype="multipart/form-data">
            <div class="card__heading">
              <button type="submit" class="button">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
      <form>
        <div class="form-split">
          <div class="form-split__item">
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Title" v-model="form.title">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.title">{{ $attrs.errors.title }}</p>
                </div>
              </div>
            </transition>

            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Firstname" v-model="form.firstname">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.firstname">{{$attrs.errors.firstname}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Lastname" v-model="form.lastname">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.lastname">{{$attrs.errors.lastname}}</p>
                </div>
              </div>
            </transition>
            <div class="form__item">
              <label for="avatar" class="form__upload">
                <input type="file" id="avatar" name="avatar" @change="selectFile($event)">
                Upload Photo
              </label>
            </div>
          </div>
          <div class="form-split__item">
            <transition name="fade-form-element">
              <div class="form__item form__required">
                <select name="role" id="role" v-model="form.role_id" required>
                  <option :value="null" disabled>
                    Select Role
                  </option>
                  <option :value="role.id" v-for="role in roles" :key="role.id">
                    {{ role.name }}
                  </option>
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.role_id">{{$attrs.errors.role_id}}</p>

                </select>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="email" name="email" id="email" placeholder="Email" v-model="form.email">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.email">{{$attrs.errors.email}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="password" name="password" id="password" placeholder="Password" v-model="form.password">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.password">{{$attrs.errors.password}}</p>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
  name: "UserEditForm.vue",
  components: {
    AppLayout
  },
  props: {
    user_details: Object,
    roles: Array,
  },


  setup(props) {
    const form = reactive({
      title: props.user_details.title,
      firstname: props.user_details.firstname,
      lastname: props.user_details.lastname,
      email: props.user_details.email,
      avatar: null,
      role_id: props.user_details.role_id,
      password: props.user_details.password,
    })

    function submitUpdate() {
      Inertia.post(route('user.update', {id: props.user_details.id}), form);
    }

    return {form, submitUpdate}
  },
  methods: {
    selectFile(event) {
  this.form.avatar = event.target.files[0];
},
    /*submitUpdate() {
      const data = new FormData();
      data.append('title', this.form.title);
      data.append('firstname', this.form.firstname);
      data.append('lastname', this.form.lastname);
      data.append('email', this.form.email);
      data.append('avatar', this.form.avatar);
      data.append('role_id', this.form.role_id);
      data.append('password', this.form.password);
      this.$inertia.put(route('user.update',{ user: this.user_details.id }), data)
    }*/

  },

}
</script>

<style scoped>

</style>
