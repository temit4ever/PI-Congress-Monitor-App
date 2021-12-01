<template>
  <app-layout title="Schedule" :auth-user="user">
    <template #header>
      <h2>
        Schedule
      </h2>
      <p>
        Please complete the required fields for your next KEE engagement.
      </p>
    </template>
  <div class="card">
    <div class="card__heading">
      <h2 class="card__title">
       <span v-if="editPath">
         Edit Engagement
       </span>
        <span v-else>Add Engagement</span>
      </h2>
      <div class="card__heading-button">
        <div class="button-group">
          <button onclick="window.history.back();" class="button button--small">
            Cancel
          </button>
        </div>
      </div>
    </div>
    <form class="form" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
      <div class="form__item form__inline">
        <div class="form__inline-item">
          <label for="person">
            <input type="radio" id="person" name="platform" v-model="form.platform" @change="engagementType = 'person'" value="In Person">
            In Person
          </label>
        </div>
        <div class="form__inline-item">
          <label for="digital">
            <input type="radio" id="digital" name="platform" v-model="form.platform" @change="engagementType = 'digital'" value="Digital">
            Digital
          </label>
        </div>
        <div v-if="errors && errors.platform" class="form__errors">
          <p>{{errors.platform}}</p>
        </div>
      </div>
      <div class="form-split">
        <div class="form-split__item">
          <div class="form__item">
            <transition name="fade-form-element">
              <div class="form__item">
                <div class="form__input form__required">
                  <input type="text" placeholder="Engagement Name" v-model="form.name">
                </div>
                <div v-if="errors && errors.name" class="form__errors">
                  <p>{{errors.name}}</p>
                </div>
              </div>
            </transition>
          </div>
          <transition name="fade-form-element">
            <div class="form__item" v-if="engagementType === 'person'">
              <div class="form__input">
                <input type="text" placeholder="House or Office Number" v-model="form.house_number">
              </div>
            </div>
          </transition>
          <transition name="fade-form-element">
            <div class="form__item" v-if="engagementType === 'person'">
              <div class="form__input">
                <input type="text" placeholder="Street Address 1" v-model="form.address_1">
              </div>
            </div>
          </transition>
          <transition name="fade-form-element">
            <div class="form__item" v-if="engagementType === 'person'">
              <div class="form__input">
                <input type="text" placeholder="Street Address 2" v-model="form.address_2">
              </div>
            </div>
          </transition>
          <div class="form__item">
            <div class="form__input form__required">
              <select name="type"  id="type" v-model="form.type" >
                <option :value="null" disabled> Select Engagement Type</option>
                <option :value="type.type" v-for="(type, index) in congressType" :key="index">
                  {{type.type}}
                </option>
              </select>
              <div v-if="errors && errors.type" class="form__errors">
                <p>{{errors.type}}</p>
              </div>
            </div>
          </div>
          <div class="form__item">
            <div class="form__input">
              <textarea placeholder="Description" name="description" id="description" v-model="form.description"></textarea>
            </div>
          </div>
          <div class="form-split">
            <div class="form-split__item">
              <div class="form__item">
                <div class="form__input">
                  <vue-timepicker id="start_time" format="hh:mm a" :minute-interval="15" name="start_time" v-model="form.start_time" :class="{'is-closed': startDropdownStatus === 'closed'}" @open="startDropdownStatus = 'opened'" @close="startDropdownStatus = 'closed'" placeholder="Time Start...">
                  </vue-timepicker>
                  <div v-if="errors && errors.start_time" class="form__errors">
                    <p>{{errors.start_time}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-split__item">
              <div class="form__item">
                <div class="form__input">
                  <vue-timepicker id="end_time" format="hh:mm a" :minute-interval="15" name="end_time" v-model="form.end_time" :class="{'is-closed': endDropdownStatus === 'closed'}" @open="endDropdownStatus = 'opened'" @close="endDropdownStatus = 'closed'" placeholder="Time End...">
                  </vue-timepicker>
                  <div v-if="errors && errors.end_time" class="form__errors">
                    <p>{{errors.end_time}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form__item">
            <h2 class="form__item-heading">
              KEEs
            </h2>
            <div class="search-dropdown">
              <input type="search" placeholder="Search KEE" v-model="search">
              <div v-if="errors && errors.kee_id" class="form__errors">
                <p>{{errors.kee_id}}</p>
              </div>
              <div class="search-dropdown__results">
                <ul>
                  <li v-for="item in filterKee" :key="item.id">
                    <button :value="item.id" type="button" class="search-dropdown__item" @click="addToSelect($event)">
                      {{ item.title }} {{ item.firstname }} {{ item.lastname }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <ul class="form__search-results">
              <li v-for="kee in form.kee_id" :key="kee.id">
                <button type="button" :value="kee.id" class="search-result__item" @click="removeFromSelect($event)">
                  {{ kee.name }}
                </button>
              </li>
            </ul>
          </div>
        </div>
        <div class="form-split__item">
          <transition name="fade-form-element">
            <div class="form__item" v-if="engagementType === 'person'">
              <div class="form__input">
                <input type="text" placeholder="County/State" id="county_state" name="county_state" v-model="form.county_state">
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
                  <option :value="country.id" v-for="country in countries" :key="country.id" value="country.id">
                    {{country.name}}
                  </option>
                </select>
              </div>
            </div>
          </transition>
          <transition name="fade-form-element">
            <div class="form__item">
              <select name="city"  id="city" v-model="form.city" disabled>
                <option :value="null" disabled>
                  Select City
                </option>
                <option :value="city.name" v-for="city in cities" :key="city.id" >
                  {{city.name}}
                </option>
              </select>
            </div>
          </transition>
          <transition name="fade-form-element">
            <div class="form__item" v-if="engagementType === 'person'">
              <div class="form__input">
                <input type="text" name="postcode" id="postcode" placeholder="Postcode" v-model="form.post_code">
              </div>
            </div>
          </transition>
          <transition name="fade-form-element">
            <div class="form__item" v-if="engagementType === 'digital'">
              <div class="form__input">
                <input type="text" id="digital_link" placeholder="Digital Link" v-model="form.digital_link">
                <div v-if="errors && errors.digital_link" class="form__errors">
                  <p>
                    {{ errors.digital_link }}
                  </p>
                </div>
              </div>
            </div>
          </transition>
          <div class="form__item">
            <div class="form__input">
              <select name="type"  id="congress" v-model="form.congress" >
                <option :value="null" disabled> Select Congress</option>
                <option :value="name.name" v-for="(name, index) in congressName" :key="index">
                  {{name.name}}
                </option>
              </select>
              <div v-if="errors && errors.congress" class="form__errors">
                <p>
                  {{ errors.congress }}
                </p>
              </div>
            </div>
          </div>
          <div class="form__item">
            <div class="form__input form__required">
              <datepicker v-model="form.calendar_date" :inputFormat="'dd-MM-yyyy'" :weekStartsOn="0"  placeholder="Select date"/>
              <div v-if="errors && errors.calendar_date" class="form__errors">
                <p>{{errors.calendar_date}}</p>
              </div>
            </div>
          </div>
          <div class="form__item form__item--padding">
            <h2 class="form__item-heading form__required form__required--label">
              Select Relevant Data Sets:
            </h2>
            <div class="form__inline">
              <div class="form__inline-item">
                <label for="early">
                  <input type="radio" id="early" name="early" value="Early" v-model="form.data_set">
                  Early
                </label>
              </div>
              <div class="form__inline-item">
                <label for="late">
                  <input type="radio" id="late" name="late" value="Late" v-model="form.data_set">
                  Late
                </label>
              </div>
              <div class="form__inline-item">
                <label for="both">
                  <input type="radio" id="both" name="both" value="Both" v-model="form.data_set">
                  Both
                </label>
              </div>
            </div>
            <div v-if="errors && errors.data_set" class="form__errors">
              <p>{{errors.data_set}}</p>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" class="button">
        Save
      </button>
    </form>
  </div>
    </app-layout>
</template>

<script>
import Multiselect from 'vue-multiselect'
import VueTimepicker from 'vue3-timepicker'
import Datepicker from 'vue3-datepicker'
import {Inertia} from "@inertiajs/inertia";
import AppLayout from "../../Layouts/AppLayout";
import _ from "lodash";
import {reactive} from "vue";

export default {
  name: "EngagementForm.vue",
  components: {
    Multiselect,
    VueTimepicker,
    Datepicker,
    AppLayout
  },
  props: {
    countries: Array,
    cities: Array,
    engagement: Array,
    editPath: Boolean,
    kees: Array,
    errors: Object,
    kee: Object,
    user: Object,
  },
  data () {
    return {
      engagementType: 'person',
      picked: new Date(),
      startDropdownStatus: 'closed',
      endDropdownStatus: 'closed',
      search: '',
      congressName: [
        { name: 'AATSa 21'},
        { name: 'ASCO 21'} ,
        { name: 'ELCC 21'},
        { name: 'ESMO 21'},
        { name: 'ESMO Asia 21'},
        { name: 'ESTS 21'},
        { name: 'WCLC 21'},
        { name: 'AATS 22'},
        { name: 'ASCO 22'} ,
        { name: 'ELCC 22'},
        { name: 'ESMO 22'},
        { name: 'ESMO Asia 22'},
        { name: 'ESTS 22'},
        { name: 'WCLC 22'},
      ],
      congressType: [
        {type: 'Virtual AB'},
        {type: 'AZ Expert Consultation'},
        {type: 'Advisory Board'},
        {type: 'Asian Speaker Panel'},
        {type: 'Congress Symposium'},
        {type: 'Global Speaker Panel'},
        {type: 'Pan Asia Advisory Board'},
        {type: 'LAURA Round Table'},
        {type: 'MDT Best Practice'},
        {type: 'Peer to Peer Ed'},
      ]
    }
  },
  setup (props) {
    const form = reactive({
      platform: (props.editPath && props.engagement.platform) ? props.engagement.platform : 'In Person',
      kee_id: (props.editPath && props.engagement.kee_id) ? JSON.parse(props.engagement.kee_id) : [],
      name: (props.editPath && props.engagement.name) ? props.engagement.name : null,
      type: (props.editPath && props.engagement.type) ? props.engagement.type: null,
      house_number: (props.editPath && props.engagement.house_number) ? props.engagement.house_number : null,
      country_id: (props.editPath && props.engagement.country_id) ? props.engagement.country_id : null,
      city: (props.editPath && props.engagement.city) ? props.engagement.city : null,
      address_1: (props.editPath && props.engagement.address_1) ? props.engagement. address_1 : null,
      address_2: (props.editPath && props.engagement.address_2) ? props.engagement.address_2 : null,
      post_code: (props.editPath && props.engagement.post_code) ? props.engagement.post_code : null,
      county_state: (props.editPath && props.engagement.county_state) ? props.engagement.county_state : null,
      congress: (props.editPath && props.engagement.congress) ? props.engagement.congress : null,
      description: (props.editPath && props.engagement.description) ? props.engagement.description : null,
      calendar_date: (props.editPath && props.engagement.calendar_date) ? new Date(props.engagement.calendar_date) : null,
      start_time: (props.editPath && props.engagement.start_time) ? JSON.parse(props.engagement.start_time) : null,
      end_time: (props.editPath && props.engagement.end_time) ? JSON.parse(props.engagement.end_time) : null,
      data_set: (props.editPath && props.engagement.data_set) ? props.engagement.data_set : null,
      digital_link: (props.editPath && props.engagement.digital_link) ? props.engagement.digital_link : null,
    })

    function submit() {
      /*if(props.editPath) {
        Inertia.post(route().current('manage_engagement.create') ? route('manage_engagement.update', {id: props.engagement.id}) : route('engagement.update', {id: props.engagement.id}), form);
      }
      else {
        Inertia.post(route().current('manage_engagement.edit') ? route('manage_engagement.store') : route('engagement.store'), form)
      }*/
      Inertia.post(route().current('manage_schedule.create') ? route('manage_schedule.store') : route('schedule.store'), form)
    }

    return { form, submit }
  },
  methods: {
    clearInput(event) {
      if (event.target.value === 'In Person' && this.form.digital_link !== '') {
        return this.form.digital_link = ''
        // this.form.platform = ''
      }else{
        this.form.address_1 = ''
        this.form.address_2 = ''
        return this.form.digital_link = value
      }
    },
    addToSelect(event) {
      let kee = _.find(this.form.kee_id, function(o) { return o.name === event.target.innerHTML; });
      if (!kee) {
        this.form.kee_id.push({'id': event.target.value, 'name': event.target.innerHTML})
      }
    },
    removeFromSelect(event) {
      const position = _.findIndex(this.form.kee_id, {'id': event.target.value, 'name': event.target.innerHTML})
      if (position > -1) {
        this.form.kee_id.splice(position, 1);
        const keePosition = _.findIndex(this.form.kee_id, {'id': event.target.value, 'name': event.target.innerHTML})
        if (keePosition > -1) {
          this.form.kee_id.splice(keePosition, 1);
        }
      }
    },
    onChange(event) {
      const country_id = event.target.value
      $.get(route('getcity.index', {term: country_id}), function (data){
        $('#city').html(data).removeAttr("disabled")
      });
    },
  },
  computed: {
    filterKee(props) {
      let self = this;
      return props.kees.filter(function(kee){
        return (kee.firstname.toLowerCase()+kee.lastname.toLowerCase()).indexOf(self.search.toLowerCase())>= 0;
      });

    },
  },
  mounted(props) {
    //localStorage.setItem('county', props.countries)
    let uri = window.location.search.substring(1);
    let params = new URLSearchParams(uri);

    if (params.get('id')) {
      const activatedKee = document.querySelector('.search-dropdown__item[value="' + params.get('id') + '"]')
      this.form.kee_id.push({'id': params.get('id'), 'name': activatedKee.innerHTML})
    }
  }
}
</script>

<style scoped>

</style>
