<template>
  <app-layout>
  <div class="card card--narrowest card--center">
    <div class="card__inner">
                <span class="icon icon--green-gradient">
                    <Icons icon="tick" />
                </span>
      <h2 class="title">
        Complete
      </h2>
      <div class="card__content" v-if="path.includes('index') || path.includes('publication/create')">
        <p>
          A new {{ name }} has been added
        </p>
      </div>
      <div class="card__content" v-else>
        <p>
          A new {{ name }} has been edited
        </p>
      </div>
      <a :href="route(`${redirect}`)" class="button">
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
    redirect: String
  },

}
</script>

<style scoped>

</style>
