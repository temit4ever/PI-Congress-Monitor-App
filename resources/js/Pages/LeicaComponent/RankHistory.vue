<template>
  <app-layout title="Rank History" :auth-user="user">
    <template #header>
      <h2>
        Classification History
      </h2>
      <p>
        A list of the top tier KEEs and ranking based on familiarity of data
      </p>
    </template>
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          KEE Classification History
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <button onclick="window.history.back();" class="button button--small">
              Back
            </button>
            <a :href="route().current('manage_history.index') ? route('manage_kee.show', {id: kee_id, eid: engagement_id}) : route('kee.shows', {id: kee_id, eid: engagement_id})" class="button button--small">
              Profile
            </a>
            <a v-if="engagement_id" :href="route().current('manage_history.index') ? route('manage_ehistory.index', {id: kee_id, eid: engagement_id ? engagement_id : ''}) : route('ehistory.index', {id: kee_id, eid: engagement_id ? engagement_id : ''})" class="button button--small">
              Engagements
            </a>
            <a v-if="user.status !== 'member'" :href="route().current('manage_history.index') ? route('manage_schedule.create', {id: kee_id}) : route('schedule.create', {id: kee_id})" class="button button--small button--green">
              Schedule
            </a>
          </div>
        </div>
      </div>
      <div class="profile-grid-evaluation" v-for="(rank, index) in rank_collection" :key="index">
        <div class="profile-grid">
          <div class="profile-grid__first">
            <div class="profile__rankings">
              <span v-if="rank.attendance"></span>
              <div class="profile__rankings-current">
                <div class="profile__ranking-title">
                  Evaluation - <span>{{dateTime(rank.created_at)}}</span>
                </div>
                <div v-if="rank.attendance === 'Yes' || rank.attendance === 'Default'">
                  <div class="profile__rankings-rank">
                    <img :src="`../../../../images/icon-award-${rank.overall_rank_status.toLowerCase() }.svg`">
                  </div>
                  <div class="profile__rankings-grade">
                    <div class="profile__rankings-text profile__rankings-text--grey">
                      Rank: {{rank.overall_rank_status}}
                    </div>
                    <div class="profile__rankings-text">
                      Grade: {{rank.rank}}
                    </div>
                    <img :src="`../../../../images/icon-grade-${rank.rank.toLowerCase() }.svg`" class="profile__rankings-grade-icon">
                  </div>
                </div>
                <div v-else class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
                  Rank: Recorded Absent
                </div>
              </div>
            </div>
          </div>
          <div class="profile-grid__second">
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
                <span class="profile-chart__bar" :style="setChartWidth(rank.understanding_data)"></span>
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
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--gradient" :style="setChartWidth(rank.commitment)"></span>
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
              <div class="profile-chart__graph">
                <span class="profile-chart__bar" :style="setChartWidth(rank.performance_delivery)"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import moment from "moment";
export default {
  name: "RankHistory.vue",
  components: {
    AppLayout,
  },
  props: {
    rank_collection: Array,
    kee_id: String,
    user: Object,
    engagement_id: String
  },
  methods: {
    dateTime: function (date) {
      return moment(date).format('DD-MM-YYYY');
    },
    setChartWidth(data) {
      if (data) {
        return {
          width: data + '%'
        }
      }
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

</style>
