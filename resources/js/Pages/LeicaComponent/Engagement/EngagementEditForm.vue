<template>
  <EngagementHeader
    :engagement="engagement"
    :cities="cities"
    :countries="countries"
    :kees="kees"
    :edit-path="this.editPath"
    :auth-user="user"
    :errors="errors"
  />
</template>

<script>
import EngagementHeader from "./EngagementHeader";
import EngagementForm from "./EngagementForm";
export default {
  name: "EngagementEditForm.vue",
  components: {EngagementForm, EngagementHeader},
  props: {
    countries: Array,
    cities: Array,
    engagement: Array,
    kees: Array,
      user: Object,
    errors: Object,

},
  data() {
    return {
      editPath: true,

    }
  }
}
</script>

<style scoped>

</style>
