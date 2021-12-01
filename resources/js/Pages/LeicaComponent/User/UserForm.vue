<template>
  <app-layout title="Users" :auth-user="user">
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
          Add a new Admin
        </h2>
        <div class="card__heading">
          <button  onclick="window.history.back();" class="button button--small user-back-heading-space">
            Back
          </button>
        </div>
        <div  class="card__heading-button">
          <form class="form" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
            <div class="card__heading">
              <button type="submit" class="button button--small" @click="changeValue();" >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
      <form class="form-loader" id="form-loader-id" :class="{'is-loading': isLoading }">
        <div class="form-split">
          <div class="form-split__item">
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input">
                  <input type="text" placeholder="Title" v-model="form.title">
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Firstname" v-model="form.firstname">
                  <div class="form__errors" v-if="errors.firstname">
                      <p>{{errors.firstname}}</p>
                  </div>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Lastname" v-model="form.lastname">
                  <div class="form__errors" v-if="errors.lastname">
                      <p>{{errors.lastname}}</p>
                  </div>
                </div>
              </div>
            </transition>
            <div class="form__item">
              <label for="avatar" class="form__upload">
                <input type="file" id="avatar" name="avatar" @change="selectFile($event)">
                <p class="upload--space">Upload Photo</p>
              </label>
              <div class="profile-image">
                <img id="preview-avatar">
              </div>
              <div class="form__errors" v-if="errors.avatar">
                <p>{{errors.avatar}}</p>
              </div>
            </div>
          </div>
          <div class="form-split__item">
            <transition name="fade-form-element">
              <div class="form__item form__required">
                <select name="role" id="role" v-model="form.role_id">
                  <option :value="null" disabled>
                    Select Role
                  </option>
                  <option :value="role.id" v-for="role in roles" :key="role.id">
                    {{ role.name }}
                  </option>
                </select>
                <div class="form__errors" v-if="errors.role_id">
                  <p>{{errors.role_id}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="email" name="email" id="email" placeholder="Email" v-model="form.email">
                  <div class="form__errors" v-if="errors.email">
                      <p>{{errors.email}}</p>
                  </div>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="password" name="password" id="password" placeholder="Password" v-model="form.password">
                  <div class="form__errors" v-if="errors.password">
                      <p>{{errors.password}}</p>
                  </div>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" v-model="form.confirm_password">
                  <div class="form__errors" v-if="errors.confirm_password">
                    <p>{{errors.confirm_password}}</p>
                  </div>
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
import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init()
export default {
  name: "UserForm.vue",
  components: {
    AppLayout
  },

  data() {
      return {
        isLoading: false,
        disabled: false
      }
  },

  props: {
    roles: Array,
    user: Object,
    errors: Object,
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
      confirm_password: null,
    })

    function submit() {
      Inertia.post(route('user.store'), form)
    }

    return { form, submit }
  },
  methods: {
    changeValue() {
      this.isLoading = true;
      setTimeout(this.removeSpinner, 15000)
    },
    removeSpinner() {
      this.isLoading = false;
    },
    selectFile(event) {
      this.form.avatar = event.target.files[0];
      // Set the preview profile image
      let avatarFile = $("input[type=file]").get(0).files[0];
      if(avatarFile) {
        let reader = new FileReader();
        reader.onload = function () {
          $("#preview-avatar").attr("src", reader.result);
        }
        reader.readAsDataURL(avatarFile);
      }
    },
  }
}
</script>

<style scoped>
.user-back-heading-space {
  margin-left: 29em;
}
.upload--space {
  margin-bottom: 1em;
}

</style>
