<template>
  <app-layout :auth-user="user">

    <!-- KEE Evaluate -->
    <div class="card card--extra-padding">
      <div class="card__heading card__heading--grid">
        <h2 class="card__title card__title--shrink">
          KEE Profile
        </h2>
        <div class="card__title">
          Evaluate
        </div>
        <div class="card__heading-button">
          <form class="" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
            <button type="submit" class="button">
              Save
            </button>
          </form>
        </div>
      </div>
      <div class="profile profile-grid">
        <div class="profile-grid__first">
          <div class="profile-image">
            <img v-if="(kee.kee_photo_path && kee.kee_photo_path !== 'placeholder-profile.jpg')" :src="`${kee.kee_photo_path}`" />
            <img v-else src="../../../../images/placeholder-profile.jpg">
          </div>
          <table class="profile__details">
            <tr>
              <td class="profile__details-title" v-if="kee.title">
                Title:
              </td>
              <td>
                {{ kee.title }}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                First Name:
              </td>
              <td>
                {{ kee.firstname }}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Last Name:
              </td>
              <td>
                {{ kee.lastname }}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Email:
              </td>
              <td>
                <span v-if="kee.email">{{ kee.email }}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Specialism:
              </td>
              <td>
                <span v-if="kee.specialism">{{ kee.specialism }}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Place of Work:
              </td>
              <td>
                <span v-if="kee.place_of_work">{{ kee.place_of_work }}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                City:
              </td>
              <td>
                <span v-if="kee.city">{{ kee.city }}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Country:
              </td>
              <td>
                <span v-if="kee.country">{{ kee.country }}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
          </table>
          <a :href="`${kee.h1_link}`" class="button" target="_blank" rel="noreferrer noopener">
            H1 Profile Link
          </a>
        </div>
        <div class="profile-grid__second">
          <form>
            <h2 class="form__item-heading form__required form__required--label">
              Did they attend?
            </h2>
            <div class="form__item form__inline">
              <div class="form__errors" v-if="errors.attendance">
                <p>{{ errors.attendance }}</p>
              </div>
              <div class="form__inline-item">
                <label for="attend-yes">
                  <input @click="checkYesValue" type="radio" id="attend-yes" name="attend" value="Yes"
                         v-model="form.attendance" checked>
                  Yes
                </label>
              </div>
              <div class="form__inline-item">
                <label for="attend-no">
                  <input @click="clearNoValue($event)" type="radio" id="attend-no" name="attend" value="No"
                         v-model="form.attendance">
                  No
                </label>
              </div>
            </div>
            <div v-show="form.attendance === 'Yes'">
              <div class="profile-chart">
                <h2 class="title-small">
                  Familiarity of Data:
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="form__required profile__select">
                  <select  id="chart__select"  v-model="form.understanding_data" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option selected value="understanding_data_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="understanding_data_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="understanding_data_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option value="understanding_data_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                  <div class="form__errors" v-if="errors.understanding_data">
                    <p>{{ errors.understanding_data }}</p>
                  </div>
                </div>
              </div>
              <div class="profile-chart" v-show="form.attendance === 'Yes'">
                <h2 class="title-small">
                  Willingness to Partner:
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Low
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Medium
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        High
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--gradient profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="form__required profile__select">
                  <select v-model="form.commitment" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="commitment_low" data-percentage="0%">
                      Low
                    </option>
                    <option selected value="commitment_medium" data-percentage="50%">
                      Medium
                    </option>
                    <option value="commitment_high" data-percentage="100%">
                      High
                    </option>
                  </select>
                  <div class="form__errors" v-if="errors.commitment">
                    <p>{{ errors.commitment }}</p>
                  </div>
                </div>
              </div>
              <div class="profile-chart" v-show="form.attendance === 'Yes'">
                <h2 class="title-small">
                  Performance/Delivery:
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="form__required profile__select">
                  <select v-model="form.performance_delivery" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="performance_delivery_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="performance_delivery_general" data-percentage="33.33%">
                      General
                    </option>
                    <option selected value="performance_delivery_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option value="performance_delivery_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                  <div class="form__errors" v-if="errors.performance_delivery">
                    <p>{{ errors.performance_delivery }}</p>
                  </div>
                </div>
              </div>
              <hr>
              <h2 class="title-large">
                Clinical Trial
              </h2>
              <div class="profile-chart">
                <h2 class="title-small">
                  FLAURA
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph clinical-trial" v-show="disabled !== 1">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.flaura" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="flaura_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="flaura_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="flaura_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="flaura_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                  <div class="form__inline-item">
                    <input type="checkbox" id="in-study-flaura" name="in-study-flaura"
                           v-model="form.flauraStudy"
                           value="flaura-Study"
                    >
                    <label>
                      Investigator in Study
                    </label>
                  </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  MYKONOS
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.mykonos" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="mykonos_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="mykonos_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="mykonos_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="mykonos_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <input type="checkbox" id="in-study-mykonos" name="in-study-mykonos"
                             v-model="form.mykonosStudy"
                             value="mykonos"
                      >
                      <label>
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  ELIOS
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.elios" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="elios_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="elios_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="elios_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="elios_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-elios" name="in-study-elios" value="Investigator in Study Elios"
                               v-model="form.eliosStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  SAVANNAH
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.savannah" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="savannah_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="savannah_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="savannah_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="savannah_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-savannah" name="in-study-savannah" value="Investigator in Study Savannah"
                               v-model="form.savannahStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  ORCHARD
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.orchard" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="orchard_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="orchard_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="orchard_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="orchard_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-orchard" name="in-study-orchard" value="Investigator in Study Orchard"
                               v-model="form.orchardStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  FLAURA-2
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.flaura_2" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="flaura_2_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="flaura_2_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="flaura_2_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="flaura_2_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-fluara-2" name="in-study-flaura-2" value="Investigator in Study Flaura-2"
                               v-model="form.flaura2Study">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  COMPEL
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.compel" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="compel_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="compel_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="compel_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="compel_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-compel" name="in-study-compel" value="Investigator in Study Compel"
                               v-model="form.compelStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  ADAURA
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.adaura" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="adaura_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="adaura_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="adaura_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="adaura_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-adaura" name="in-study-adaura" value="Investigator in Study Adaura"
                               v-model="form.adauraStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  NeoADAURA
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.neo_adaura" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="neo_adaura_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="neo_adaura_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="neo_adaura_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="neo_adaura_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-neoadaura" name="in-study-neoadaura" value="Investigator in Study NeoAdaura"
                               v-model="form.neoAdauraStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  ST1 ADAURA
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.st1_adaura" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="st1_adaura_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="st1_adaura_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="st1_adaura_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="st1_adaura_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-st1-adaura" name="in-study-st1-adaura" value="Investigator in Study St1 Adaura"
                               v-model="form.st1AdauraStudy">
                        Investigator in Study
                      </label>
                  </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  TARGET
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.target" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="target_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="target_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="target_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="target_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                    <div class="form__inline-item">
                      <label>
                        <input type="checkbox" id="in-study-target" name="in-study-target" value="Investigator in Study Target"
                               v-model="form.targetStudy">
                        Investigator in Study
                      </label>
                    </div>
                </div>
              </div>
              <div class="profile-chart">
                <h2 class="title-small">
                  LAURA
                </h2>
                <div class="profile-chart__labels">
                  <div class="profile-chart__label">
                                    <span>
                                        Foundation
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                  </div>
                  <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                  </div>
                </div>
                <div class="profile-chart__graph">
                  <span class="profile-chart__bar profile-chart__bar--empty"
                        :style="{ backgroundSize: chartWidth + 'px' }"></span>
                </div>
                <div class="profile__select profile__select--checkbox">
                  <select v-model="form.laura" class="chart-select" v-on:change="onChartChange($event)">
                    <option :value="null" disabled>
                      Evaluate
                    </option>
                    <option value="laura_foundation" data-percentage="0%">
                      Foundation
                    </option>
                    <option value="laura_general" data-percentage="33.33%">
                      General
                    </option>
                    <option value="laura_advanced" data-percentage="66.66%">
                      Advanced
                    </option>
                    <option selected value="laura_expert" data-percentage="100%">
                      Expert
                    </option>
                  </select>
                  <div class="form__inline-item">
                    <label>
                      <input type="checkbox" id="in-study-laura" name="in-study-laura" value="Investigator in Study Laura"
                             v-model="form.lauraStudy">
                      Investigator in Study
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="form.attendance === 'No'">
              - Recorded absence
            </div>
            <span class="form__item form__inline">
              <input type="text" id="kee_id" name="kee_id" v-model="form.kee_id" hidden>
            </span>
            <span class="form__item form__inline">
              <input type="text" id="engagement_id" name="engagement_id" v-model="form.engagement_id" hidden>
            </span>
          </form>
        </div>
      </div>
    </div>

  </app-layout>

</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
export default {
  name: "RankForm.vue",
  components: {AppLayout,},
  props: {
    kee: Object,
    errors: Object,
    user: Object,
    engagement_id: BigInt,
    recent_rank: Object,
  },
  setup(props) {
    const form = reactive({
      understanding_data: props.recent_rank && props.recent_rank.understanding_data === '0' ? 'understanding_data_foundation' :
        props.recent_rank.understanding_data === '33.33' ? 'understanding_data_general' : props.recent_rank.understanding_data === '66.66' ?
          'understanding_data_advanced' : props.recent_rank.understanding_data === '100' ? 'understanding_data_expert' : null,

      commitment: props.recent_rank && props.recent_rank.commitment === '0' ? 'commitment_low' :
        props.recent_rank.commitment === '50' ? 'commitment_medium' : props.recent_rank.commitment === '100' ?
          'commitment_high' : null,

      performance_delivery: props.recent_rank && props.recent_rank.performance_delivery === '0' ? 'performance_delivery_foundation' :
        props.recent_rank.performance_delivery === '33.33' ? 'performance_delivery_general' : props.recent_rank.performance_delivery === '66.66' ?
          'performance_delivery_advanced' : props.recent_rank.performance_delivery === '100' ? 'performance_delivery_expert' : null,
      attendance: 'Yes',
      rank: null,
      overall: null,
      flaura: props.recent_rank && props.recent_rank.flaura === '0' ? 'flaura_foundation' :
        props.recent_rank.flaura === '33.33' ? 'flaura_general' : props.recent_rank.flaura === '66.66' ?
          'flaura_advanced' : props.recent_rank.flaura === '100' ? 'flaura_expert' : null,

      mykonos: props.recent_rank && props.recent_rank.mykonos === '0' ? 'mykonos_foundation' :
        props.recent_rank.mykonos === '33.33' ? 'mykonos_general' : props.recent_rank.mykonos === '66.66' ?
          'mykonos_advanced' : props.recent_rank.mykonos === '100' ? 'mykonos_expert' : null,

      elios: props.recent_rank && props.recent_rank.elios === '0' ? 'elios_foundation' :
        props.recent_rank.elios === '33.33' ? 'elios_general' : props.recent_rank.elios === '66.66' ?
          'elios_advanced' : props.recent_rank.elios === '100' ? 'elios_expert' : null,

      savannah: props.recent_rank && props.recent_rank.savannah === '0' ? 'savannah_foundation' :
        props.recent_rank.savannah === '33.33' ? 'savannah_general' : props.recent_rank.savannah === '66.66' ?
          'savannah_advanced' : props.recent_rank.savannah === '100' ? 'savannah_expert' : null,

      orchard: props.recent_rank && props.recent_rank.orchard === '0' ? 'orchard_foundation' :
        props.recent_rank.orchard === '33.33' ? 'orchard_general' : props.recent_rank.orchard === '66.66' ?
          'orchard_advanced' : props.recent_rank.orchard === '100' ? 'orchard_expert' : null,

      flaura_2: props.recent_rank && props.recent_rank.flaura_2 === '0' ? 'flaura_2_foundation' :
        props.recent_rank.flaura_2 === '33.33' ? 'flaura_2_general' : props.recent_rank.flaura_2 === '66.66' ?
          'flaura_2_advanced' : props.recent_rank.flaura_2 === '100' ? 'flaura_2_expert' : null,

      compel: props.recent_rank && props.recent_rank.compel === '0' ? 'compel_foundation' :
        props.recent_rank.compel === '33.33' ? 'compel_general' : props.recent_rank.compel === '66.66' ?
          'compel_advanced' : props.recent_rank.compel === '100' ? 'compel_expert' : null,

      adaura: props.recent_rank && props.recent_rank.adaura === '0' ? 'adaura_foundation' :
        props.recent_rank.adaura === '33.33' ? 'adaura_general' : props.recent_rank.adaura === '66.66' ?
          'adaura_advanced' : props.recent_rank.adaura === '100' ? 'adaura_expert' : null,

      neo_adaura: props.recent_rank && props.recent_rank.neo_adaura === '0' ? 'neo_adaura_foundation' :
        props.recent_rank.neo_adaura === '33.33' ? 'neo_adaura_general' : props.recent_rank.neo_adaura === '66.66' ?
          'neo_adaura_advanced' : props.recent_rank.neo_adaura === '100' ? 'neo_adaura_expert' : null,

      st1_adaura: props.recent_rank && props.recent_rank.st1_adaura === '0' ? 'st1_adaura_foundation' :
        props.recent_rank.st1_adaura === '33.33' ? 'st1_adaura_general' : props.recent_rank.st1_adaura === '66.66' ?
          'st1_adaura_advanced' : props.recent_rank.st1_adaura === '100' ? 'st1_adaura_expert' : null,

      target: props.recent_rank && props.recent_rank.target === '0' ? 'target_foundation' :
        props.recent_rank.target === '33.33' ? 'target_general' : props.recent_rank.target === '66.66' ?
          'target_advanced' : props.recent_rank.target === '100' ? 'target_expert' : null,

      laura: props.recent_rank && props.recent_rank.laura === '0' ? 'laura_foundation' :
        props.recent_rank.laura === '33.33' ? 'laura_general' : props.recent_rank.laura === '66.66' ?
          'laura_advanced' : props.recent_rank.laura === '100' ? 'laura_expert' : null,
      kee_id: props.kee.id,
      engagement_id: props.engagement_id
    })

    function submit() {
      Inertia.post(route('rank.store'), form)
    }

    return {form, submit}
  },
  data() {
    return {
      chartWidth: '0',
      percentage: 0,
    }
  },
  methods: {
    checkYesValue() {
      this.form.attendance = 'Yes';
    },
    clearNoValue() {

      $('.profile-chart__bar').width('0%');

      this.form.understanding_data = null;
      this.form.commitment = null;
      this.form.performance_delivery = null;
      this.form.flaura = null;
      this.form.mykonos = null;
      this.form.elios = null;
      this.form.savannah = null;
      this.form.orchard = null;
      this.form.flaura_2 = null;
      this.form.compel = null;
      this.form.st1_adaura = null;
      this.form.neo_adaura = null;
      this.form.target = null;
      this.form.laura = null;
      this.form.adaura = null;
      this.form.flauraStudy = null;
      this.form.mykonosStudy = null;
      this.form.eliosStudy = null;
      this.form.savannahStudy = null;
      this.form.orchardStudy = null;
      this.form.flaura2Study = null;
      this.form.compelStudy = null;
      this.form.st1AdauraStudy = null;
      this.form.neoAdauraStudy = null;
      this.form.targetStudy = null;
      this.form.lauraStudy = null;
      this.form.adauraStudy = null;
    },
    onChartChange(event) {
      this.changeChart(event.target)
    },
    changeChart(element) {
      const parentEl = element.parentElement
      const siblingEl = parentEl.previousSibling
      this.percentage = element.options[element.options.selectedIndex].dataset['percentage']
      siblingEl.querySelector('.profile-chart__bar').style.width = this.percentage
    },
    setBackgroundSize() {
      this.chartWidth = document.querySelector('.profile-chart__graph').clientWidth
    },
  },
  mounted() {
    this.setBackgroundSize()

    window.addEventListener('resize', this.setBackgroundSize)

    const chartsSelect = document.querySelectorAll('.chart-select')

    chartsSelect.forEach(select => {
      this.changeChart(select)
    })
    const charts = document.querySelectorAll('.profile-chart__bar--empty')
    setTimeout(() => {
      charts.forEach(chart => {
        chart.classList.remove('profile-chart__bar--empty')
      })
    }, 300);
  }
}
</script>

<style scoped>

</style>
