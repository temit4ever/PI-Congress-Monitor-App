<template>
  <app-layout title="Manage" :auth-user="user">
    <template #header>
      <h2>
        Manage
      </h2>
      <p>
        Admin Management Console
      </p>
    </template>
    <div>
      <ul class="manage-buttons">
        <li class="manage-buttons__item">
          <Link :href="route('role.index')" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icons icon="star" />
              </div>
              Roles
            </div>
          </Link>
        </li>
        <li class="manage-buttons__item">
          <Link :href="route('permission.index')" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icons icon="lock" />
              </div>
              Permissions
            </div>
          </Link>
        </li>
        <li class="manage-buttons__item">
          <Link :href="route('user.index')" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icons icon="person" />
              </div>
              Users
            </div>
          </Link>
        </li>
        <li class="manage-buttons__item">
          <Link :href="route('manage_kee.index')" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icons icon="person" />
              </div>
              KEEs
            </div>
          </Link>
        </li>
        <li class="manage-buttons__item">
          <Link :href="route('manage_engagement.index')" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icons icon="location" />
              </div>
              Engagement
            </div>
          </Link>
        </li>
        <li class="manage-buttons__item">
          <Link :href="route('manage_completed.index')" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icons icon="sliders" />
              </div>
              Evaluate
            </div>
          </Link>
        </li>
      </ul>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import Icons from '@/Components/Icons.vue';
export default {
  name: "Manage.vue",
  components: {
    AppLayout,
    Icons,
  },
  props: {
    user: Object,
  }
}
</script>

<style scoped>

</style>
