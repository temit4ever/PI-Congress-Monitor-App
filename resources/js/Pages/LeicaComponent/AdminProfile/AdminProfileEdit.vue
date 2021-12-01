<template>
  <app-layout title="Users" :auth-user="user">
    <template #header>
      <h2>
       Current Admin
      </h2>
      <p>
        Add / Edit / Delete AstraZeneca users
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Edit Admin
        </h2>
        <div class="card__heading">
          <button  onclick="window.history.back();" class="button button--small user-edit-back-heading-space">
            Back
          </button>
        </div>
        <div  class="card__heading-button">
          <form class="form" @submit.prevent="submitUserUpdate" method="POST" enctype="multipart/form-data">
            <div class="card__heading">
              <button type="submit" class="button button--small">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
      <form class="form-loader" :class="{'is-loading': isLoading }">
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
                    <p>{{ errors.firstname }}</p>
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
                <img v-if="user_details.profile_photo_path && user_details.profile_photo_path !== 'placeholder-profile.jpg'"
                     id="preview-previous-avatars" :src="user_details.profile_photo_path"
                />
                <img id="preview-avatar" />
              </div>
              <div class="form__errors" v-if="errors.avatar">
                <p>{{errors.avatar}}</p>
              </div>
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
                  <input type="password" name="password" id="password" placeholder="Change Password" v-model="form.password">
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
import AppLayout from "../../../Layouts/AppLayout";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
  name: "AdminProfileEdit",
  components: {
    AppLayout
  },

  data() {
    return {
      isLoading: false
    }
  },

  props: {
    user_details: Object,
    roles: Array,
    user: Object,
    errors: Object,
  },


  setup(props) {
    const form = reactive({
      title: props.user_details.title,
      firstname: props.user_details.firstname,
      lastname: props.user_details.lastname,
      email: props.user_details.email,
      avatar: props.user_details.profile_photo_path ? props.user_details.profile_photo_path : null,
      role_id: props.user_details.role_id,
      password: props.user_details.password,
      confirm_password: null,
    })

    function submitUserUpdate() {
      Inertia.post(route('profiles.update', {id: props.user_details.id}), form);
    }

    return {form, submitUserUpdate}
  },
  methods: {
    selectFile(event) {
      this.form.avatar = event.target.files[0];
      // Set the preview profile image
      let avatarFile = $("input[type=file]").get(0).files[0];
      if(avatarFile) {
        //console.log(avatarFile)
        let reader = new FileReader();
        reader.onload = function () {
          $("#preview-previous-avatars").removeAttr("src")

          $("#preview-avatar").attr("src", reader.result);
        }
        reader.readAsDataURL(avatarFile);
      }
    },
  },

}
</script>

<style scoped>
.user-edit-back-heading-space {
  margin-left: 29em;
}
.upload--space {
  margin-bottom: 1em;
}

</style>

