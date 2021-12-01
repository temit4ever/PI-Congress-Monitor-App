<template>
  <app-layout title="KEEs">
    <template #header>
      <h2>
        Kee
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Add KEE
        </h2>
        <div class="card__heading-button cancel-heading">
          <a :href="route('kee.index')" class="button">
            Cancel
          </a>
        </div>
        <div class="card__heading-button">
          <a :href="route('kee.create')" class="button">
            Add Kee
          </a>
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
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Specialism" v-model="form.specialism">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.specialism">{{$attrs.errors.specialism}}</p>
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
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="email" name="email" id="email" placeholder="Email" v-model="form.email">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.email">{{$attrs.errors.email}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input">
                  <input type="text" placeholder="Place of Work" v-model="form.office_name">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.office_name">{{$attrs.errors.office_name}}</p>

                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input">
                  <select name="country_id"  id="country_id" v-model="form.country_id" v-on:change="onChange($event)">
                    <option :value="null" disabled>
                      Select Country
                    </option>
                    <option :value="country.id" v-for="country in countries" :key="country.id">
                      {{country.name}}
                    </option>
                  </select>
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.country">{{$attrs.errors.country}}</p>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <select name="city"  id="city" v-model="form.city" required>
                  <option :value="null" disabled>
                    Select city
                  </option>
                  <option :value="city.name" v-for="city in cities" :key="city.id" >
                    {{city.name}}
                  </option>
                </select>
                <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.city">{{$attrs.errors.city}}</p>

              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" name="h1_link" id="password" placeholder="H1 Link" v-model="form.h1_link">
                  <p class="" style="margin-top: 1em; color: red" v-if="$attrs.errors.password">{{$attrs.errors.h1_link}}</p>
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
    roles: Array
  },
  setup () {
    const form = reactive({
      title: null,
      firstname: null,
      lastname: null,
      email: null,
      avatar: null,
      office_name: null,
      h1_link: null,
      country: null,
      city: null,
      specialism: null,
    })

    function submit() {
      Inertia.post(route('kee.store'), form)
    }

    return { form, submit }
  },
  methods: {
    selectFile(event) {
      this.form.avatar = event.target.files[0];
    },
    onChange(event) {
      const country_id = event.target.value
      $.get(route('getcity.index', {term: country_id}), function (data){
        $('#city').html(data)
      });
    },
  }
}
</script>

<style scoped>
.cancel-heading{
  margin-left: 29em;
}

</style>
