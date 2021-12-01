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
          Add a new Admin
        </h2>
        <div  class="card__heading-button">
          <form class="form" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
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
import  { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "UserForm.vue",
  components: {
    AppLayout
  },
  props: {
    roles: Array
  },
  setup () {
    const form = reactive({
      title: null,
      firstname: null,
      lastname: null,
      email: null,
      avatar: null,
      role_id: null,
      password: null,
    })

    function submit() {
      Inertia.post(route('user.store'), form)
    }

    return { form, submit }
  },
  methods: {
    selectFile(event) {
      this.form.avatar = event.target.files[0];
    }
  }
}
</script>

<style scoped>

</style>
