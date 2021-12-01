<template>
        <Head :title="title" />

        <jet-banner />

        <div class="site-container">
            <header class="site-sidebar">
                <div class="site-sidebar__sticky">
                    <div class="site-sidebar__main">
                        <h1 class="site-logo">
                            <a :href="route('dashboard')">
                                <img src="../../images/logo.svg">
                            </a>
                        </h1>
                      <nav class="site-nav" v-if="authUser">
                            <ul>
                                <li class="site-nav__item">
                                  <Link :href="route('dashboard')" class="site-nav__link" @click=changeDashboard($event) :class="{'is-active':isActiveMain('dashboard') }">
                                        <span class="site-nav__icon">
                                            <Icons icon="dashboard" />
                                        </span>
                                    Dashboard
                                  </Link>
                                </li>
                                <li class="site-nav__item" v-if="authUser && authUser.status !== 'member'">
                                    <Link :href="route('schedule.create')" class="site-nav__link" :class="{'is-active': isActiveMain('schedule')}">
                                        <span class="site-nav__icon">
                                            <Icons icon="schedule" />
                                        </span>
                                        Schedule
                                    </Link>
                                </li>
                              <li class="site-nav__item" v-if="authUser && authUser.status !== 'member'">
                                <Link :href="route('attendance.index')" class="site-nav__link" :class="{'is-active': isActiveMain('attendance')}">
                                        <span class="site-nav__icon">
                                            <Icons icon="tick-circle" />
                                        </span>
                                  Attendance
                                </Link>
                              </li>
                                <li class="site-nav__item">
                                    <Link :href="route('calendar.index')" class="site-nav__link" :class="{'is-active': isActiveMain('calendar')}">
                                        <span class="site-nav__icon">
                                            <Icons icon="calendar" />
                                        </span>
                                        Calendar
                                    </Link>
                                </li>
                                <li class="site-nav__item">
                                    <Link :href="route('classification.index')" class="site-nav__link" :class="{'is-active': isActiveMain('classification') }">
                                        <span class="site-nav__icon">
                                            <Icons icon="person" />
                                        </span>
                                      KEEs
                                    </Link>
                                </li>
                                <li class="site-nav__item" v-if="authUser && authUser.status !== 'member'">
                                    <Link :href="route('manage.index')" class="site-nav__link" :class="{'is-active': isActiveMain('manage') }">
                                        <span class="site-nav__icon">
                                            <Icons icon="manage" />
                                        </span>
                                        Manage
                                    </Link>
                                </li>
                            </ul>
                        </nav>
                        <div class="site-sidebar__user" v-if="authUser">
                            <div class="site-sidebar__user-profile">
                                <Link :href="route('profiles.show', {id: authUser.id})" class="profile-link">
                                    <div class="site-sidebar__user-image">
                                        <img v-if="authUser.profile_photo_path !== 'placeholder-profile.jpg'" :src="authUser.profile_photo_path">
                                        <img v-else src="../../images/placeholder-profile.jpg">
                                    </div>
                                </Link>
                                <span class="site-sidebar__user-status site-sidebar__user-status--online"></span>
                            </div>
                            <div>
                                <span class="site-sidebar__user-link">
                                    {{ authUser.firstname }} {{ authUser.lastname }}
                                </span>
                            </div>
                            <form @submit.prevent="logout">
                                <button type="submit" class="link">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="site-sidebar__secondary" v-if="(authUser && authUser.status !== 'member') && routeContains(route().current())">
                        <div class="site-sidebar__secondary-icon">
                            <Icons icon="manage" />
                        </div>
                        <nav class="site-sidebar__secondary-nav">
                            <ul>
                                <li class="site-sidebar__secondary-item">
                                    <Link :href="route('role.index')" class="site-sidebar__secondary-link" :class="{'is-active': isActiveManage('role')}">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icons icon="star" />
                                        </div>
                                        Roles
                                    </Link>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <Link :href="route('permission.index')" class="site-sidebar__secondary-link" :class="{'is-active': isActiveManage('permission')}">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icons icon="lock" />
                                        </div>
                                        Permissions
                                    </Link>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <Link :href="route('user.index')" class="site-sidebar__secondary-link" :class="{'is-active': isActiveManage('user')}">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icons icon="person" />
                                        </div>
                                        Users
                                    </Link>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <Link :href="route('manage_kee.index')" class="site-sidebar__secondary-link" :class="{'is-active': isActiveManage('kee')}">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icons icon="person" />
                                        </div>
                                        KEEs
                                    </Link>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <Link :href="route('manage_engagement.index')" class="site-sidebar__secondary-link" :class="{'is-active': isActiveManage('engagement') }">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icons icon="location" />
                                        </div>
                                        Engagements
                                    </Link>
                                </li>
                                <li class="site-sidebar__secondary-item">
                                    <Link :href="route('manage_completed.index')" class="site-sidebar__secondary-link" :class="{'is-active':  isActiveManage(route().current() === 'manage_rank.show' ||
                                     route().current() === 'manage_rank.create' || route().current() === 'rank.index' ? 'rank' : 'completed') }">
                                        <div class="site-sidebar__secondary-link-icon">
                                            <Icons icon="sliders" />
                                        </div>
                                        Evaluate
                                    </Link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="site-sidebar__secondary" v-if="route().current('classification.index')">
                        <div class="site-sidebar__secondary-icon">
                            <Icons icon="person" />
                        </div>
                        <nav class="site-sidebar__secondary-nav">
                            <ul>
                                <li class="site-sidebar__secondary-item site-sidebar__secondary-item--padding site-sidebar__secondary-item--margin">

                                    <select class="select-white" name="filter-rank" v-model="keeform.rank" @input="filterKees({rank:$event.target.value})">
                                      <option value="Classification">
                                        Classification
                                      </option>
                                      <option :value="rank" v-for="(rank, index) in ranks" :key="index" value="index">
                                        {{rank}}
                                      </option>
                                    </select>
                                  <select class="select-white" name="filter-commitment" v-model="keeform.commitmentTerm" @input="filterKees({commitmentTerm:$event.target.value})">
                                    <option value="Commitment">
                                      Willingness to Partner
                                    </option>
                                    <option :value="commitment" v-for="(commitment, index) in commitments" :key="index" value="index">
                                      {{commitment}}
                                    </option>
                                    </select>
                                  <select class="select-white" name="filter-performance" v-model="keeform.performanceTerm" @input="filterKees({performanceTerm:$event.target.value})">
                                    <option value="Performance">
                                      Performance
                                    </option>
                                    <option :value="performance" v-for="(performance, index) in performances" :key="index" value="index">
                                      {{performance}}
                                    </option>
                                  </select>
                                  <select class="select-white" name="filter-specialism" v-model="keeform.specialismTerm" @input="filterKees({specialismTerm:$event.target.value})">
                                    <option value="Specialism">
                                      Specialism
                                    </option>
                                    <option :value="specialism" v-for="(specialism, index) in specialisms" :key="index" value="index">
                                      {{specialism}}
                                    </option>
                                  </select>
                                  <select class="select-white" name="filter-country" id="country_id" v-model="keeform.countryTerm" @input="filterKees({countryTerm:$event.target.value})">
                                    <option value="Country">
                                      Country
                                    </option>
                                    <option :value="country.name" v-for="country in countries" :key="country.id" value="country.id">
                                      {{country.name}}
                                    </option>
                                  </select>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </header>
            <div class="site-main">
                <!-- <div class="notifications-header" v-if="loginStatus">
                    <a href="#" class="notifications-header__link">
                        <span class="notifications-header__icon">
                            <span class="notification-header__alert"></span>
                            <Icons icon="bell" />
                        </span>
                        Notifications
                    </a>
                </div> -->
                <div class="site-main__wrapper">
                    <div class="site-main__header">
                        <slot name="header"></slot>
                    </div>
                    <slot></slot>
                </div>
            </div>
        </div>
        <footer class="site-footer" v-if="status !== null">
            <img class="site-footer__logo" src="../../images/astrazeneca-logo.svg">
        </footer>
</template>

<script>
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import Icons from '@/Components/Icons.vue';
import _ from "lodash";
import  { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
        props: {
          title: String,
          authUser: Object,
          countries: Array,
        },
        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
            Icons,
        },
        emits: ['testMethod'],
        data() {
            return {
              dashboard: true,
              calendar: false,
              term: null,
              ranks: ['A', 'B', 'C', 'D'],
              commitments: ['Low', 'Medium', 'High'],
              performances: ['Foundation', 'General', 'Advance', 'Expert'],
              specialisms: ['Medical Oncologist', 'Rad Oncologist', 'Clinical Oncologist','Pulmonologist/ Medical Oncologist', 'Thoracic Surgery'],
              showingNavigationDropdown: false,
              routePath: window.location.pathname,
            }
        },
        setup (props) {
          const keeform = reactive({
            rank: props.filter_rank && props.filter_rank !== 'Classification' ? props.filter_rank : 'Classification',
            commitmentTerm: props.filter_commitment && props.filter_commitment !== 'Commitment' ? props.filter_commitment : 'Commitment',
            performanceTerm: props.filter_performance && props.filter_performance !== 'Performance' ? props.filter_performance : 'Performance',
            specialismTerm: props.filter_specialism && props.filter_specialism !== 'Specialism' ? props.filter_specialism : 'Specialism',
            countryTerm: props.filter_country && props.filter_country !== 'Country' ? props.filter_country : 'Country',
          })
          return { keeform }
        },
        created() {
          //parse the url parameters
          let qp = new URLSearchParams(window.location.search);
          if ( qp.get('rank') && this.ranks.indexOf(qp.get('rank')) >= 0 ) {
            this.keeform.rank = qp.get('rank');
          }
          if ( qp.get('commitmentTerm') && this.commitments.indexOf(qp.get('commitmentTerm')) >= 0 ) {
            this.keeform.commitmentTerm = qp.get('commitmentTerm');
          }
          if ( qp.get('performanceTerm') && this.performances.indexOf(qp.get('performanceTerm')) >= 0 ) {
            this.keeform.performanceTerm = qp.get('performanceTerm');
          }
          if ( qp.get('specialismTerm') && this.specialisms.indexOf(qp.get('specialismTerm')) >= 0 ) {
            this.keeform.specialismTerm = qp.get('specialismTerm');
          }
          if ( qp.get('countryTerm') && this.countries.indexOf(qp.get('countryTerm')) >= 0 ) {
            this.keeform.countryTerm = qp.get('countryTerm');
          }
        },
        methods: {
          changeDashboard(event) {
           this.dashboard = true
          },
          filterKees: _.throttle(function (item) {
            for (var prop in item) {
              if (!item.hasOwnProperty(prop)) continue;
              this.keeform[prop] = item[prop];
            }
            this.$emit("filterUpdate", this.keeform);
          }, 1500),

          switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },

            isActiveMain(param) {

              let url = usePage().props.value.url;
              let active = "dashboard";

              if ( typeof url[1] != 'undefined' ){
                switch ( url[1].toLowerCase() ) {
                  case "schedule" :
                    active = "schedule";
                    break;
                  case "attendance" :
                    active = "attendance";
                    break;
                  case "engagement" :
                  case "calendar" :
                    active = "calendar";
                    break;
                  case "classification" :
                  case "kee" :
                  case "history" :
                    active = "classification";
                    break;
                  case "manage" :
                    active = "manage";
                    break;

                }
              }

              return param.toLowerCase() === active;

            },

          isActiveManage(param) {

            let url = usePage().props.value.url;
            let active = "";
//console.log( url[2].toLowerCase())
            if ( typeof url[2] != 'undefined' ){
              switch ( url[2].toLowerCase() ) {
                case "role" :
                case "permission" :
                case "user" :
                case "kee" :
                case "engagement" :
                case "completed" :
                case "rank" :
                  active =  url[2].toLowerCase();
                  break;
                case "schedule" :
                  active = "engagement";
                  break;
                case "history" :
                  active = "kee";
                  break;
              }
            }

            return param.toLowerCase() === active;

          },

          routeContains(route) {
                return this.routePath.indexOf('manage') > -1
            }
        },
    }
</script>
