<template>
  <app-layout title="KEE" :auth-user="user">
    <template #header>
      <h2>
        KEE
      </h2>
    </template>

    <!-- KEE Profile -->
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          KEE Relationship
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <button onclick="window.history.back();" class="button button--small">
              Back
            </button>
            <Link v-if="engagement || last_rank" :href="route().current('manage_kee.show') ? route('manage_ehistory.index', {id: kee.id, eid: engagement ? engagement.id : recent_rank.engagement_id}) : route('ehistory.index', {id: kee.id, eid: engagement ? engagement.id : recent_rank.engagement_id})" class="button button--small">
                 Engagements
            </Link>
            <Link v-if="engagement" :href="route().current('manage_kee.show', {id: kee.id}) ? route('manage_history.index', {id: kee.id, eid: engagement ? engagement.id : recent_rank.engagement_id}) : route('history.index', {id: kee.id, eid: engagement ? engagement.id : recent_rank.engagement_id})" class="button button--small">
              History
            </Link>
            <Link v-else :href="route().current('manage_kee.show', {id: kee.id}) ? route('manage_history.index', {id: kee.id, eid: engagement ? engagement.id : ''}) : route('history.index', {id: kee.id, eid: engagement ? engagement.id : ''})" class="button button--small">
              History
            </Link>
            <!--            <a :href="route('publication.index')" class="button button&#45;&#45;small">
                          Publications
                        </a>-->
            <Link v-if="user.status !== 'member'" :href="route().current('manage_kee.show', {id: kee.id}) ? route('manage_schedule.create', {id: kee.id}) : route('schedule.create', {id: kee.id})" class="button button--small button--green">
              Schedule
            </Link>
          </div>
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
              <td class="profile__details-title">
                Title:
              </td>
              <td>
                <span v-if="kee.title">{{ kee.title}}</span>
                <span v-else>N/A</span>

              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                First Name:
              </td>
              <td>
                <span v-if="kee.firstname">{{ kee.firstname }}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Last Name:
              </td>
              <td>
                <span v-if="kee.lastname">{{ kee.lastname}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Email:
              </td>
              <td>
                <span v-if="kee.email">{{ kee.email}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Specialism:
              </td>
              <td>
                <span v-if="kee.specialism">{{ kee.specialism}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Place of Work:
              </td>
              <td>
                <span v-if="kee.place_of_work">{{ kee.place_of_work}}</span>
                <span v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                City:
              </td>
              <td>
                <span v-if="kee.city">{{ kee.city}}</span>
                <span v-else>N/A</span>              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Country:
              </td>
              <td>
                <span v-if="kee.country">{{ kee.country}}</span>
                <span class="profile__details-title" v-else>N/A</span>
              </td>
            </tr>
            <tr>
              <td v-if="!kee.h1_link" class="profile__details-title">
                H1 Link:
              </td>
              <td>
                <span v-if="!kee.h1_link">N/A</span>
              </td>
            </tr>
          </table>
          <a v-if="kee.h1_link" :href="`${kee.h1_link}`" class="button" target="_blank" rel="noreferrer noopener">
            H1 Profile Link
          </a>
        </div>
        <div class="profile-grid__second">
          <div class="profile__rankings">
            <span v-if="recent_rank">
            <div class="profile__rankings-current" v-if="recent_rank && recent_rank.attendance === 'Yes' || recent_rank && recent_rank.attendance === 'Default'" >
              <div class="profile__rankings-rank">
                {{recent_rank.overall_rank_status}}
                <img :src="`../../../../images/icon-award-${recent_rank.overall_rank_status.toLowerCase() }.svg`">
              </div>
              <div class="profile__rankings-grade">
                <div class="profile__rankings-text profile__rankings-text--grey">
                  Rank: {{recent_rank.overall_rank_status}}
                </div>
                <div class="profile__rankings-text">
                  Category: {{recent_rank.rank}}
                </div>
                <img :src="`../../../../images/icon-grade-${recent_rank.rank.toLowerCase() }.svg`" class="profile__rankings-grade-icon">
              </div>
              <div class="profile__ranking-date">
                {{dateTime(recent_rank.created_at)}}
              </div>
            </div>
              </span>
            <div v-else class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
              <div class="profile__rankings-previous" v-if="last_rank && last_rank.attendance === 'Yes' || last_rank && last_rank.attendance === 'Default'">
                <div class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
                  Previous Rank: {{last_rank.overall_rank_status}}
                </div>
                <div class="profile__rankings-rank">
                  <img :src="`../../../../images/icon-award-${last_rank.overall_rank_status.toLowerCase() }.svg`">
                </div>
                <div class="profile__rankings-grade">
                  <div class="profile__rankings-text">
                    Category: {{ last_rank.rank }}
                  </div>
                  <img :src="`../../../../images/icon-grade-${last_rank.rank.toLowerCase() }.svg`" class="profile__rankings-grade-icon">
                </div>
                <div class="profile__ranking-date">
                  {{dateTime(last_rank.created_at)}}
                </div>
              </div>
            </div>
            <span v-if="last_rank">
            <div class="profile__rankings-previous" v-if="last_rank.attendance === 'Yes' || last_rank.attendance === 'Default'">
              <div class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
                Previous Rank: {{last_rank.overall_rank_status}}
              </div>
              <div class="profile__rankings-rank">
                  <img :src="`../../../../images/icon-award-${last_rank.overall_rank_status.toLowerCase() }.svg`">
              </div>
              <div class="profile__rankings-grade">
                <div class="profile__rankings-text">
                  Category: {{ last_rank.rank }}
                </div>
                <img :src="`../../../../images/icon-grade-${last_rank.rank.toLowerCase() }.svg`" class="profile__rankings-grade-icon">
              </div>
              <div class="profile__ranking-date">
                {{dateTime(last_rank.created_at)}}
              </div>
            </div>
            </span>
            <span v-else>
              <div v-if="last_rank !== null && last_rank.attendance === 'No'" class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
              Previous Rank: Recorded Absent
            </div>
            </span>
          </div>
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
            <div class="profile-chart__graph" v-if="recent_rank">
              <span class="profile-chart__bar" :style="setChartWidth(recent_rank.understanding_data)"></span>
            </div>
          </div>
          <div class="profile-chart">
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
            <div class="profile-chart__graph" v-if="recent_rank">
              <span class="profile-chart__bar profile-chart__bar--gradient" :style="setChartWidth(recent_rank.commitment)"></span>
            </div>
          </div>
          <div class="profile-chart">
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
            <div class="profile-chart__graph" v-if="recent_rank">
              <span class="profile-chart__bar" :style="setChartWidth(recent_rank.performance_delivery)"></span>
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
            <div class="profile-chart__graph">
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.flaura)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { flauraStudy: 1 })">
              <input type="checkbox" id="in-study-flaura" name="in-study-flaura" checked :disabled="disabled"
                     value="flaura"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.mykonos)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { mykonosStudy: 1 })">
              <input type="checkbox" id="in-study-mykonos" name="in-study-mykonos" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.elios)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { eliosStudy: 1 })">
              <input type="checkbox" id="in-study-elios" name="in-study-elios" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.savannah)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { savannahStudy: 1 })">
              <input type="checkbox" id="in-study-savannah" name="in-study-savannah" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.orchard)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { orchardStudy: 1 })">
              <input type="checkbox" id="in-study-orchard" name="in-study-orchard" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.flaura_2)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { flaura2Study: 1 })">
              <input type="checkbox" id="in-study-flaura2" name="in-study-flaura2" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.compel)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { compelStudy: 1 })">
              <input type="checkbox" id="in-study-compel" name="in-study-compel" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.adaura)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { adauraStudy: 1 })">
              <input type="checkbox" id="in-study-adaura" name="in-study-adaura" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.neo_adaura)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { neoAdauraStudy: 1 })">
              <input type="checkbox" id="in-study-neoadaura" name="in-study-neoadaura" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.st1_adaura)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { st1AdauraStudy: 1 })">
              <input type="checkbox" id="in-study-st1adaura" name="in-study-st1adaura" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.target)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { targetStudy: 1 })">
              <input type="checkbox" id="in-study-target" name="in-study-target" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
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
              <span v-if="recent_rank" class="profile-chart__bar" :style="setChartWidth(recent_rank.laura)"></span>
            </div>
            <div class="profile--checkbox" v-if="isInvestigatorStudy(recent_rank, { lauraStudy: 1 })">
              <input type="checkbox" id="in-study-laura" name="in-study-laura" checked :disabled="disabled"
              >
              <label>
                Investigator in Study
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import moment from "moment";
import _ from "lodash";
export default {
  name: "KeeDetails.vue",
  components: {
    AppLayout
  },
  props: {
    user: Object,
    kee: Object,
    recent_rank: Object,
    last_rank: Object,
    engagement: Object,
    default_rank: Object

  },
  data() {
    return {
      disabled: 1,
    }
  },
  methods: {
    isInvestigatorStudy(recent_rank, objvalue) {
      const result = _.find(recent_rank.investigator_in_study,  objvalue );
      if (result) {
        return (result.flauraStudy === 1) || (result.mykonosStudy === 1) || (result.eliosStudy === 1) ||
          (result.savannahStudy === 1) || (result.orchardStudy === 1) || (result.flaura2Study === 1) ||
          (result.compelStudy === 1) || (result.adauraStudy === 1) || (result.st1AdauraStudy === 1) ||
          (result.targetStudy === 1) || (result.lauraStudy === 1) || (result.neoAdauraStudy === 1)
      }
    },
    setChartWidth(data) {
      if (data) {
        return {
          width: data + '%'
        }
      }
    },
    dateTime: function (date) {
      return moment(date).format('DD-MM-YYYY');
    },
    setBackgroundSize() {
      const charts = document.querySelectorAll('.profile-chart__graph')

      if (charts) {
        charts.forEach(chart => {
          let width = chart.clientWidth

          chart.querySelector('span').style.backgroundSize = width + 'px'
        })
      }
    },
  },
  mounted () {
    this.setBackgroundSize()

    window.addEventListener('resize', this.setBackgroundSize)
  }
}
</script>

<style scoped>
.profile--checkbox {
  margin-top: 1em;
}
</style>
