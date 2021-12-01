<template>
  <app-layout :auth-user="user" :referer="referer">
  <div class="card card--narrowest card--center">
    <div class="card__inner">
                <span class="icon icon--green-gradient">
                    <Icons icon="tick" />
                </span>
      <h2 class="title">
        Complete
      </h2>
      <div class="card__content" v-if="path.includes('index')">
        <p>
          A new {{ name }} has been {{lastText}}
        </p>
      </div>
      <div class="card__content" v-else>
        <p>
          {{ name }} has been edited
        </p>
      </div>
      <a :href="route().current('engagement.show') ? route('calendar.index') : route(`${redirect}`)" class="button">
          Return
      </a>
    </div>
  </div>
    </app-layout>
</template>

<script>
import Icons from "../../../Components/Icons";
export default {
  name: "Confirmation.vue",
  components: {Icons},
  props: {
    path: String,
    name: String,
    redirect: String,
    lastText: String,
    user: Object,
    referer: String
  },

}
</script>

<style scoped>

</style>
