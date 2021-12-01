<template>
  <app-layout title="Users">
    <template #header>
      <h2>
        KEE
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>


    <!-- KEE Profile -->
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          KEE Ranking
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <a :href="route('kee.index')" class="button button--small">
              Back
            </a>
            <a :href="route('engagement.index')" class="button button--small">
              Engagements
            </a>
            <a href="#" class="button button--small">
              History
            </a>
            <a :href="route('publication.index')" class="button button--small">
              Publications
            </a>
            <a :href="route('engagement.create')" class="button button--small button--green">
              Schedule
            </a>
          </div>
        </div>
      </div>
      <div class="profile profile-grid">
        <div class="profile-grid__first">
          <img class="profile-image" :src="`${kee.kee_photo_path}`">
          <table class="profile__details">
            <tr>
              <td class="profile__details-title">
                Title...
              </td>
              <td>
                {{kee.title}}
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
                {{ kee.lastname}}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Email:
              </td>
              <td>
                {{ kee.email }}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Specialism:
              </td>
              <td>
                {{kee.specialism}}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Place of Work:
              </td>
              <td>
                {{kee.office_name}}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                City:
              </td>
              <td>
                {{ kee.city}}
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Country:
              </td>
              <td>
                {{ kee.country_name }}
              </td>
            </tr>
          </table>
          <a :href="`${kee.h1_link}`" class="button">
            H1 Profile Link
          </a>
        </div>
        <div class="profile-grid__second">
          <div class="profile__rankings">
            <div class="profile__rankings-current">
              <div class="profile__rankings-rank">
                <img src="../../../../images/icon-award-advanced.svg">
              </div>
              <div class="profile__rankings-grade">
                <div class="profile__rankings-text profile__rankings-text--grey">
                  Rank: Advanced
                </div>
                <div class="profile__rankings-text">
                  Grade: B
                </div>
                <img src="../../../../images/icon-grade-b.svg" class="profile__rankings-grade-icon">
              </div>
              <div class="profile__ranking-date">
                00/00/00
              </div>
            </div>
            <div class="profile__rankings-previous">
              <div class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
                Previous Rank: General
              </div>
              <div class="profile__rankings-rank">
                <img src="../../../../images/icon-award-general.svg">
              </div>
              <div class="profile__rankings-grade">
                <div class="profile__rankings-text">
                  Grade: C
                </div>
                <img src="../../../../images/icon-grade-c.svg" class="profile__rankings-grade-icon">
              </div>
              <div class="profile__ranking-date">
                00/00/00
              </div>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Understanding of Data:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
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
              <span class="profile-chart__bar" style="width: 66.66%;"></span>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Commitment:
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
              <span class="profile-chart__bar profile-chart__bar--gradient" style="width: 50%;"></span>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Performance/Delivery:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
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
              <span class="profile-chart__bar" style="width: 33.33%;"></span>
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
                                    Basic
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
              <span class="profile-chart__bar" style="width: 33.33%;"></span>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              MYKONOS
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
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
              <span class="profile-chart__bar" style="width: 100%;"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
export default {
  name: "KeeDetails.vue",
  components: {
    AppLayout
  },
  props: {
    kee: Object,
  }
}
</script>

<style scoped>

</style>
