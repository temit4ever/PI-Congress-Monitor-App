<template>
  <app-layout>
    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Add Engagement
        </h2>
        <div class="card__heading-button">
          <a :href="route('engagement.index')" class="button">
            Cancel
          </a>
        </div>
      </div>
      <form class="form" @submit.prevent="submit" method="post">
        <div class="form__item form__inline">
          <div class="form__inline-item">
            <label for="person">
              <input type="radio" id="person" v-model="form.platform" @change="engagementType = 'person'" value="In Person">
              In Person
            </label>
          </div>
          <div class="form__inline-item">
            <label for="digital">
              <input type="radio" id="digital" v-model="form.platform" @change="engagementType = 'digital'" value="Digital">
              Digital
            </label>
          </div>
        </div>
        <div class="form-split">
          <div class="form-split__item">
            <div class="form__item">
              <div class="form__input form__required">
                <select name="name"  id="name" v-model="form.name" >
                  <option :value="null" disabled> Select Engagement Name</option>
                  <option :value="congress_name.name" v-for="(congress_name, index) in congress" :key="index">
                    {{congress_name.name}}
                  </option>
                </select>
              </div>
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
                  <option :value="congress_name.type" v-for="(congress_name, index) in congress" :key="index">
                    {{congress_name.type}}
                  </option>
                </select>
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
                  <div class="form__input form__required">
                    <vue-timepicker id="start_time" name="start_time" v-model="form.start_time" :class="{'is-closed': startDropdownStatus === 'closed'}" @open="startDropdownStatus = 'opened'" @close="startDropdownStatus = 'closed'" placeholder="Time Start...">

                    </vue-timepicker>
                  </div>
                </div>
              </div>
              <div class="form-split__item">
                <div class="form__item">
                  <div class="form__input form__required">
                    <vue-timepicker id="end_time" name="end_time" v-model="form.end_time" :class="{'is-closed': endDropdownStatus === 'closed'}" @open="endDropdownStatus = 'opened'" @close="endDropdownStatus = 'closed'" placeholder="Time End...">
                    </vue-timepicker>
                  </div>
                </div>
              </div>
            </div>
            <div class="form__item">
              <h2 class="form__item-heading">
                KEEs
              </h2>
              <div class="search-dropdown">
                <input type="search" v-model="searchQuery" placeholder="Search KEE">
                <div class="search-dropdown__results">
                  <ul>
                    <li v-for="item in kees" :key="item.id">
                      <button :value="item.id" type="button" class="search-dropdown__item" @click="addToSelect($event)">
                        {{ item.title }} {{ item.firstname }} {{ item.lastname }}
                      </button>
                    </li>
                  </ul>
                </div>
              </div>
              <select multiple hidden>
              </select>
              <ul class="form__search-results">
                <li v-for="option in selectedOptions" :key="option">
                  <button type="button" class="search-result__item" @click="removeFromSelect($event)">
                    {{ option }}
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
              <div class="form__item" v-if="engagementType === 'person'">
                <div class="form__input">
                  <select name="country_id"  id="country_id" v-model="form.country_id" v-on:change="onChange($event)">
                    <option :value="null" disabled>
                      Select Country
                    </option>
                    <option :value="country.id" v-for="country in countries" :key="country.id">
                      {{country.name}}
                    </option>
                  </select>
                </div>
              </div>
            </transition>
            <transition name="fade-form-element">
              <div class="form__item" v-if="engagementType === 'person'">
                <select name="city"  id="city" v-model="form.city" required>
                  <option :value="null" disabled>
                    Select city
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
                  <input type="text" placeholder="Digital Link" v-model="form.digital_link">
                </div>
              </div>
            </transition>
            <div class="form__item">
              <div class="form__input form__required">
                <select  name="congress_link" v-model="form.congress_link">
                  <option :value="null" disabled>
                    Congress Link
                  </option>
                  <option :value="congress_link.links" v-for="(congress_link, index) in congress" :key="index">
                    {{congress_link.links}}
                  </option>
                </select>
              </div>
            </div>
            <div class="form__item">
              <div class="form__input form__required">
                <datepicker v-model="form.calendar_date" :inputFormat="'dd-MM-yyyy'" :weekStartsOn="0"  placeholder="Select date"/>
              </div>
            </div>
            <div class="form__item form__item--padding">
              <h2 class="form__item-heading">
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
            </div>
          </div>
        </div>
        <button type="submit" class="button">
          Save
        </button>
      </form>
    </div>

    <!-- <label class="typo__label">Search / dropdown for Kee</label>
    <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
      <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
    </multiselect>
    <pre class="language-json"><code>{{ value  }}</code></pre> -->
  </app-layout>
</template>

<script>
import Multiselect from 'vue-multiselect'
import VueTimepicker from 'vue3-timepicker'
import Datepicker from 'vue3-datepicker'
import AppLayout from "../../../Layouts/AppLayout";

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
    kees: Array
  },
  data () {
    return {
      keeValue: [],
      options: [
        { id: 'Vue.js', name: 'JavaScript' },
        { id: 'Adonis', name: 'JavaScript' },
        { id: 'Rails', name: 'Ruby' },
      ],
      engagementType: 'person',
      picked: new Date(),
      startDropdownStatus: 'closed',
      endDropdownStatus: 'closed',
      searchData: [
        { name: 'Option 1' },
        { name: 'Option 2' },
        { name: 'Option 3' }
      ],
      selectedOptions: [],
      congress: [
        { name: 'WCLC 21', type: 'Virtual AB', links: 'https://app.h1insights.com/curie/person/4645580' },
        { name: 'ESMO 21', type: 'Advisory Board', links:'https://app.h1insights.com/curie/person/7912876'},
        { name: 'ESMO A 21', type: 'Congress Symposium', links: 'https://app.h1insights.com/curie/person/8124674' }
      ],
      form: {
        platform: null,
        kee_id: [],
        name: null,
        type: null,
        house_number: null,
        city: null,
        address_1: null,
        address_2: null,
        post_code: null,
        county_state: null,
        congress_link: null,
        description: null,
        calendar_date: null,
        start_time: null,
        end_time: null,
        data_set: null,
        digital_link: null,
      }
    }
  },
  methods: {
    addToSelect(event) {
      //const selectedId = event.target.value
      this.keeValue.push({'id': event.target.value, 'name': event.target.innerHTML})
      console.log(this.keeValue)
      this.form.kee_id = Array.from(new Set(this.keeValue.map(JSON.stringify))).map(JSON.parse);
      console.log(this.form.kee_id)
      if (!this.selectedOptions.includes(event.target.innerHTML)) {
        this.selectedOptions.push(event.target.innerHTML)
      }

      console.log(this.selectedOptions)
    },
    removeFromSelect(event) {
      if (this.selectedOptions.includes(event.target.innerHTML)) {
        const index = this.selectedOptions.indexOf(event.target.innerHTML);
        if (index > -1) {
          this.selectedOptions.splice(index, 1);
        }
      }

      // let car = this.form.kee_id.filter(function(kee){ return kee.name.indexOf(this.selectedOptions) })
//console.log(car)
      //const value =  this.form.kee_id.indexOf(this.selectedOptions);
      //console.log(value)
      if (value === -1) {
        this.form.kee_id.splice(value, 1);
      }
/*
      $.each(this.form.kee, function (i, kee) {

      })*/

      console.log(this.selectedOptions)
    },
    onChange(event) {
      const country_id = event.target.value
      $.get(route('getcity.index', {term: country_id}), function (data){
        $('#city').html(data)
      });
    },
    bindValue(event){
      /*const selectedId = event.target.value
      this.form.kee_id.push(selectedId)*/
    }
  }
}
</script>

<style scoped>

</style>

