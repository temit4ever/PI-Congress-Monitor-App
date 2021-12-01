<template>
  <app-layout title="KEEs" :auth-user="user">
    <template #header>
      <h2>
        Kee
      </h2>
      <p>
        Add / Edit / Delete KEEs
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          KEEs
        </h2>
        <div class="card__heading-button cancel-heading">
          <button onclick="window.history.back();" class="button button--small">
            Cancel
          </button>
        </div>
        <div class="card__heading-button">
          <form class="" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
              <button type="submit" class="button button--small">
                Save
              </button>
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
                </div>
                <div class="form__errors" v-if="errors.title">
                  <p>{{ errors.title }}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Firstname" v-model="form.firstname">
                </div>
                <div class="form__errors" v-if="errors">
                  <p>{{errors.firstname}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Lastname" v-model="form.lastname">
                </div>
                <div class="form__errors" v-if="errors.lastname">
                  <p>{{errors.lastname}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <select type="text" placeholder="Specialism" v-model="form.specialism">
                    <option :value="null" disabled>
                      Select Specialism
                    </option>
                    <option :value="specialism.name" v-for="(specialism, index ) in specialisms" :key="index">
                      {{specialism.name}}
                    </option>
                  </select>
                  <div class="form__errors" v-if="errors.specialism">
                    <p>{{ errors.specialism }}</p>
                  </div>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input">
                  <input type="email" name="email" id="email" placeholder="Email" v-model="form.email">
                </div>
                <div class="form__errors" v-if="errors.email">
                  <p>{{errors.email}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input">
                  <input type="text" placeholder="Place of Work" v-model="form.place_of_work">
                </div>
                <div class="form__errors" v-if="errors.place_of_work">
                  <p>{{errors.place_of_work}}</p>
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
            <transition name="fade-form-element form__required">
              <div class="form__item">
                <div class="form__input">
                  <select name="country_id"  id="country_id" v-model="form.country_id" v-on:change="onChange($event)">
                    <option :value="null" disabled>
                      Select Country
                    </option>
                    <option :value="country.id" v-for="country in countries" :key="country.id" value="country.id">
                      {{country.name}}
                    </option>
                  </select>
                  <div v-if="errors" class="form__errors">
                    <p>{{errors.country_id}}</p>
                  </div>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <select name="city"  id="city" v-model="form.city" disabled>
                  <option :value="null" disabled>
                    Select city
                  </option>
                  <option :value="city.name" v-for="city in cities" :key="city.id">
                    {{city.name}}
                  </option>
                </select>
                <div class="form__errors" v-if="errors.city">
                    <p>{{errors.city}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" name="h1_link" id="h1_link" placeholder="H1 Link" v-model="form.h1_link">
                </div>
                <div class="form__errors" v-if="errors.h1_link">
                  <p>{{errors.h1_link}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element form__required">
              <div class="form__item">
                <div class="form__input">
                  <select name="understanding_data" placeholder="Familiarity of data" id="fData_id" v-model="form.understanding_data">
                    <option :value="null" disabled>
                      Familiarity of Data
                    </option>
                    <option selected value="understanding_data_foundation">
                      Foundation
                    </option>
                    <option value="understanding_data_general">
                      General
                    </option>
                    <option value="understanding_data_advanced">
                      Advanced
                    </option>
                    <option value="understanding_data_expert">
                      Expert
                    </option>
                  </select>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element form__required">
              <div class="form__item">
                <div class="form__input">
                  <select name="commitment"  placeholder="Commitment" id="commitment" v-model="form.commitment">
                    <option :value="null" disabled>
                      Willingness to Partner
                    </option>
                    <option value="commitment_low">
                      Low
                    </option>
                    <option selected value="commitment_medium">
                      Medium
                    </option>
                    <option value="commitment_high">
                      High
                    </option>
                  </select>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element form__required">
              <div class="form__item">
                <div class="form__input">
                  <select name="performance" placeholder="Performance/Delivery" id="performance" v-model="form.performance_delivery">
                    <option :value="null" disabled>
                      Performance/Delivery
                    </option>
                    <option value="performance_delivery_foundation">
                      Foundation
                    </option>
                    <option value="performance_delivery_general">
                      General
                    </option>
                    <option selected value="performance_delivery_advanced">
                      Advanced
                    </option>
                    <option value="performance_delivery_expert">
                      Expert
                    </option>
                  </select>
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
  name: "KeeForm.vue",
  components: {
    AppLayout
  },
  props: {
    countries: Array,
    cities: Array,
    user: Object,
    errors: Object,

  },
  data() {
    return {
      specialisms: [
        { name: 'Medical Oncologist' },
        { name: 'Thoracic Surgery'},
        { name: 'Pulmonologist/ Medical Oncologist'},
        { name: 'Clinical Oncologist'},
        { name: 'Rad Oncologist' },
        {name: 'Pulmonologist'}
      ],
    }
  },
  setup () {
    const form = reactive({
      title: null,
      firstname: null,
      lastname: null,
      email: null,
      avatar: null,
      place_of_work: null,
      h1_link: null,
      city: null,
      country_id: null,
      specialism: null,
      understanding_data: null,
      commitment: null,
      performance_delivery: null
    })

    function submit() {
      Inertia.post(route('manage_kee.store'), form)
    }

    return { form, submit }
  },
  methods: {
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
    onChange(event) {
      const country_id = event.target.value
      $.get(route('getcity.index', {term: country_id}), function (data){
        $('#city').html(data).removeAttr("disabled")
      });
    },
  }
}
</script>

<style scoped>
.cancel-heading {
  margin-left: 29em;
}
.upload--space {
  margin-bottom: 1em;
}

</style>
